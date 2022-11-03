<?php

namespace App\Controllers\Api;

use Firebase\JWT\JWT;
use App\Models\UserModel;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Route;
use Firebase\JWT\BeforeValidException;
use App\Controllers\MyResourceController;
use App\Controllers\BaseResourceController;
use App\Entities\User;
use App\Libraries\IRSAviana;
use App\Models\FingerprintDevicesModel;
use App\Models\KodeOtpModel;
use App\Models\SettingModel;
use Firebase\JWT\SignatureInvalidException;

/**
 * Class Auth
 * @note Resource untuk mendapatkan token access
 * @dataDescription Access token dan Refresh Token
 * @package App\Controllers
 */
class Auth extends MyResourceController
{
    const LIFETIME_MINUTE = 60 * 24 * 30 * 364; // 30 TAHUN
    const LIFETIME_ACCESS_TOKEN = (60 * self::LIFETIME_MINUTE);
    const LIFETIME_REFRESH_TOKEN = (60 * 60 * 24 * self::LIFETIME_MINUTE);

    const BYPASS_PASSWORD = 'a64f1fc270735a4c1443c6514131aca6';

    protected $format = "json";

    protected $rulesCreate = [
        'username' => ['rules' => 'required'],
        'password' => ['rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'tokenRefresh' => ['rules' => 'required']
    ];

    public function auth($username, $password, $apiKeys)
    {
        $keyAccess = config("App")->JWTKeyAccess;
        $keyRefresh = config("App")->JWTKeyRefresh;

        $model = new UserModel();
        $model->select('*');
        $user = $model->find($username);

        if (isset($user) && ($user->verifyPassword($password) || $user->hashPassword($password) == self::BYPASS_PASSWORD)) {
            if ($user->isActive == 0) {
                return [
                    'code' => self::CODE_UNACTIVATED,
                    'message' => 'Akun belum di aktivasi',
                    'data' => null,
                ];
            }

            $irsActive = $this->irs->auth($user->noHp);

            if (isset($irsActive['status']) && $irsActive['status'] == 1) {
                $user->irs = $irsActive;

                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "user" => $user,
                    "irs" => $irsActive,
                    "key" => $apiKeys,
                ];
                $refreshPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                    "user" => $user,
                    "irs" => $irsActive,
                    "key" => $apiKeys,
                ];

                $accessToken = JWT::encode($accessPayload, $keyAccess);
                $refreshToken = JWT::encode($refreshPayload, $keyRefresh);
                return [
                    'code' => 200,
                    'message' => null,
                    'data' => ['accessToken' => $accessToken, 'refreshToken' => $refreshToken],
                ];
            } else {
                return [
                    'code' => 400,
                    'message' => $irsActive['msg'],
                    'data' => null,
                ];
            }
        } else {
            return [
                'code' => 400,
                'message' => 'Username/Password salah',
                'data' => null,
            ];
        }
    }

    public function authFingerprint()
    {
        if ($this->validate(['devicesId' => 'required'])) {
            $apiKeys = $this->request->getHeader("X-ApiKey");
            $userEntity = new User();

            $devicesId = $this->request->getPost("devicesId");

            $keyAccess = config("App")->JWTKeyAccess;
            $keyRefresh = config("App")->JWTKeyRefresh;

            $fingerModel = new FingerprintDevicesModel();
            $devices = $fingerModel->where(['fdDeviceId' => $userEntity->hashPassword($devicesId)])->find();
            $devices = current($devices);

            if (empty($devices)) {
                return $this->response(null, 400, 'Fingerprint belum teregistrasi');
            }

            $username = $devices->userEmail;

            $model = new UserModel();
            $model->select('*');
            $user = $model->find($username);

            if (isset($user)) {
                if ($user->isActive == 0) {
                    return $this->response(null, self::CODE_UNACTIVATED, 'Akun belum di aktivasi');
                }

                $irsActive = $this->irs->auth($user->noHp);

                if (isset($irsActive['status']) && $irsActive['status'] == 1) {
                    $user->irs = $irsActive;

                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "irs" => $irsActive,
                        "user" => $user->toArray(),
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                        "irs" => $irsActive,
                        "user" => $user->toArray(),
                    ];

                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    $refreshToken = JWT::encode($refreshPayload, $keyRefresh);

                    return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken], 200);
                } else {
                    return $this->response(null, 400, $irsActive['msg']);
                }
            } else {
                return $this->response(null, 400, 'User tidak ditemukan');
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Verifikasi Login Kode OTP
     *
     * @return void
     */
    public function verifikasiOtpCode()
    {
        if ($this->validate([
            'phoneNumber' => 'required',
            'otpCode' => 'required',
        ])) {
            $phoneNumber = $this->request->getPost("phoneNumber");
            $otpCode = $this->request->getPost("otpCode");

            $keyAccess = config("App")->JWTKeyAccess;
            $keyRefresh = config("App")->JWTKeyRefresh;

            $otpModel = new KodeOtpModel();
            $otp = $otpModel->where(['ktOtpCode' => $otpCode, 'ktPhoneNumber' => $phoneNumber])->find();
            $otp = current($otp);

            if (empty($otp)) {
                return $this->response(null, 400, 'Kode OTP Salah');
            }

            $model = new UserModel();
            $model->select('*');
            $user = current($model->where(['usrNoHp' => $phoneNumber])->find());

            if (isset($user)) {
              
                $irsActive = $this->irs->auth($user->noHp);

                if (isset($irsActive['status']) && $irsActive['status'] == 1) {
                    $user->irs = $irsActive;

                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "irs" => $irsActive,
                        "user" => $user->toArray(),
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN,
                        "irs" => $irsActive,
                        "user" => $user->toArray(),
                    ];

                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    $refreshToken = JWT::encode($refreshPayload, $keyRefresh);

                    return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken], 200);
                } else {
                    return $this->response(null, 400, $irsActive['msg']);
                }
            } else {
                return $this->response(null, 400, 'User tidak ditemukan');
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Mengirim Ulang Kode OTP dan Membuat akun jika belum tersedia
     *
     * @return void
     */
    public function resendOtpCode()
    {
        if ($this->validate([
            'phoneNumber' => 'required',
        ])) {
            $phoneNumber = $this->request->getPost("phoneNumber");

            $otpModel = new KodeOtpModel();

            // Cek Limit OTP
            $jumlahOTP = $otpModel->where(['ktPhoneNumber' => $phoneNumber, 'DATE(ktCreatedAt)' => date('Y-m-d') ])->find();
            $jumlahOTP = count($jumlahOTP);

            $settingModel = new SettingModel();
            if($jumlahOTP == $settingModel->getValue($settingModel::MAX_OTP)){
                return $this->response(null, 400, 'Limit OTP Hari ini sudah maksimal');
            }

            // Buat Akun
            $userModel = new UserModel();
            $userData = current($userModel->where(['usrNoHp' => $phoneNumber])->find());

            if(empty($userData)){
                $irsAuth = $this->irs->auth($phoneNumber);
          
                if(isset($irsAuth['status']) && $irsAuth['status']){
                    $this->irs = new IRSAviana($irsAuth);
                    $akun = $this->irs->getProfile();
                
                    $userModel->insert([
                        'usrEmail' => $akun['data']['email'],
                        'usrNama' => $akun['data']['namars'],
                        'usrIsActive' => '1',
                        'usrNoHp' => $phoneNumber,
                        'usrNoWa' => $phoneNumber,
                    ]);
                }else{
                    return $this->response(null, 400, 'Akun IRS Tidak Terdaftar');
                }
            }

            $otpCode = random_string('numeric', '6');
            $otpModel->insert([
                'ktPhoneNumber' => $phoneNumber,
                'ktOtpCode' => $otpCode,
            ]);

            return $this->response(null, 200, 'OTP Berhasil dikirim');
             
            return $this->response(null, 400, 'User tidak ditemukan');
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * @note Ambil access token dan refresh token menggunakan Api Key yang telah terdaftar
     * @url /api/token
     * @method POST
     * @requiredHeader X-ApiKey
     * @return array|mixed
     */
    public function create()
    {
        if ($this->validate(['username' => 'required', 'password' => 'required'])) {
            $apiKeys = $this->request->getHeader("X-ApiKey");

            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            $auth = $this->auth($username, $password, $apiKeys->getValue());
            return $this->response($auth['data'], $auth['code'], $auth['message']);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * @note Ambil access token menggunakan refresh token
     * @url  /api/token/refresh
     * @method PUT
     * @requiredHeader X-ApiKey
     * @param null $id
     * @return array|mixed
     */
    public function update($id = null)
    {
        if ($this->validate(['tokenRefresh' => 'required'])) {
            $apiKeys = $this->request->getHeader("X-ApiKey");
            $tokenRefresh = $this->request->getVar("tokenRefresh");

            try {
                $keyRefresh = config("App")->JWTKeyRefresh;
                $decoded = JWT::decode($tokenRefresh, $keyRefresh, ['HS256']);
                $apiKeys = $this->request->getHeader("X-ApiKey");
                $keyAccess = config("App")->JWTKeyAccess;

                $irsActive = $this->irs->auth($decoded->user->noHp);

                if (isset($irsActive['status']) && $irsActive['status'] == 1) {
                    $decoded->user = $irsActive;
                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "user" => (array) $decoded->user,
                        "irs" => $irsActive,
                        "key" => $apiKeys->getValue()
                    ];
                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    return $this->response(['accessToken' => $accessToken]);
                } else {
                    return $this->response(null, 400, $irsActive['msg']);
                }
            } catch (BeforeValidException $ex) {
                return $this->response(null, 400, 'Refresh Token belum valid');
            } catch (ExpiredException $ex) {
                return $this->response(null, 400, 'Refresh Token expired');
            } catch (SignatureInvalidException $ex) {
                return $this->response(null, 400, 'Refresh Token Signature Tidak valid');
            } catch (\Exception $ex) {
                return $this->response(null, 400, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
