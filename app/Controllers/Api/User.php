<?php

namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use CodeIgniter\Config\Config;
use App\Libraries\Notification;
use App\Models\UserAlamatModel;
use App\Entities\User as EntitiesUser;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class User
 * @note Resource untuk mengelola data m_user
 * @dataDescription m_user
 * @package App\Controllers
 */
class User extends MyResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format = 'json';

    protected $rulesCreate = [
        'email' => ['label' => 'email', 'rules' => 'required|cek_email_terdaftar|valid_email'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'password' => ['label' => 'password', 'rules' => 'required'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'required|numeric'],
        'noWa' => ['label' => 'No Whatsapp', 'rules' => 'required|numeric'],
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota / Kabupaten', 'rules' => 'required'],
        'kotaTipe' => ['label' => 'Tipe Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
    ];

    protected $rulesUpdatePassword = [
        'new_password' => ['label' => 'Password Baru', 'rules' => 'required'],
        'verif_password' => ['label' => 'Verifikasi Password', 'rules' => 'required'],
    ];

    protected $rulesFirebase = [
        'firebaseToken' => ['label' => 'Firebase Token', 'rules' => 'required'],
    ];

    protected $rulesLokasi = [
        'latitude' => ['label' => 'Latitude', 'rules' => 'required'],
        'longitude' => ['label' => 'Longitude', 'rules' => 'required'],
    ];

    protected $rulesVerifikasiOtp = [
        'email' => ['label' => 'Email', 'rules' => 'required'],
        'otpCode' => ['label' => 'Kode OTP', 'rules' => 'required'],
    ];

    protected $rulesUpdateProfile = [
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'username' => [
            'label' => 'Username', 'rules' => 'required'],
        'jk' => ['label' => 'Jenis Kelamin', 'rules' => 'required|in_list[Laki-Laki,Perempuan]'],
        'tglLahir' => ['label' => 'Tanggal Lahir', 'rules' => 'required|valid_date[Y-m-d]'],
        'bio' => ['label' => 'Biodata', 'rules' => 'required'],
        'foto' => ['label' => 'Foto Profil', 'rules' => 'required|is_image[foto]|max_size[foto,5024]|mime_in[foto, image/jpg,image/jpeg,image/png,image/x-png]'],
        'fotoKtp' => ['label' => 'Foto KTP', 'rules' => 'required|is_image[fotoKtp]|max_size[fotoKtp,5024]|mime_in[fotoKtp, image/jpg,image/jpeg,image/png,image/x-png]'],
    ];

    /**
     * Get My Profile
     *
     * @return void
     */
    public function getMyProfile()
    {
        $modelUser = new UserModel();
        $modelUser->select('*');
        $modelUser->with(['fingerprint']);
        $data = $modelUser->find($this->user['email']);
        return $this->response($data, 200, '');
    }

    protected function uploadFile($uploadName)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . PATH_FOTO_USER;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile($uploadName);
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post[$uploadName] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function updateProfile()
    {
        $post = $this->request->getVar();

        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {
            $post['foto'] = '-';
        }

        $file = $this->request->getFile("fotoKtp");
        if ($file && $file->getError() == 0) {
            $post['fotoKtp'] = '-';
        }
        $this->request->setGlobal("request", $post);
      
        $keyUpdate = current(array_keys($this->request->getVar()));

        if (!isset($this->rulesUpdateProfile[$keyUpdate])) {
            return $this->response(null, 400, 'Key Update Tidak Ditemukan');
        }

        if ($this->validate([$keyUpdate => $this->rulesUpdateProfile[$keyUpdate]], $this->validationMessage)) {
            // Upload Foto
            try {
                $this->uploadFile('foto');
                $this->uploadFile('fotoKtp');
            } catch (\Exception $ex) {
                $response =  $this->response(null, 500, $ex->getMessage());
                return $this->response->setJSON($response);
            }

            try {
                $data = $this->model->find($this->user['email']);
                $data->{$keyUpdate} = $this->request->getVar($keyUpdate);
                $status = $this->model->save($data);

                return $this->response(null, ($status ? 200 : 500), 'Berhasil mengupdate profil');
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Memperbaharui Firebase token user
     *
     * @return void
     */
    public function updateFirebaseToken()
    {
        if ($this->validate($this->rulesFirebase, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }

            try {

                $status = $this->model
                    ->update($this->user['email'], [
                        'usrFirebaseToken' => $this->request->getVar('firebaseToken'),
                    ]);

                return $this->response('Berhasil memperbaharui token', ($status ? 200 : 500));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Memperbaharui Firebase token user
     *
     * @return void
     */
    public function updateLokasi()
    {
        if ($this->validate($this->rulesLokasi, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }

            try {
                $status = $this->model
                    ->update($this->user['email'], [
                        'usrLatitude' => $this->request->getVar('latitude'),
                        'usrLongitude' => $this->request->getVar('longitude'),
                    ]);

                return $this->response('Berhasil memperbaharui lokasi', ($status ? 200 : 500));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Registrasi akun baru
     *
     * @return void
     */
    public function register()
    {
        if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            try {
                $this->afterValidation();
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }

            $otpCode = random_string('numeric', '6');
            $uuidV4 = Uuid::uuid4();

            $entityClass = $this->model->getReturnType();
            $entity = new $entityClass();
            $entity->fill($this->request->getVar());
            $entity->password = $entity->hashPassword($entity->password);
            $entity->activeCode = $uuidV4;
            $entity->otpCode = $otpCode;

            try {
                $status = $this->model->insert($entity, false);

                $insertId = $this->model->getInsertID();
                if ($insertId > 0) {
                    $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                }

                if ($status) {
                    $modelUserAlamat = new UserAlamatModel();
                    $modelUserAlamat->insert([
                        'usralUsrEmail' => $entity->email,
                        'usralNama' => 'Rumah',
                        'usralLatitude' => $this->request->getVar('latitude'),
                        'usralLongitude' => $this->request->getVar('longitude'),
                        'usralKotaId' => $this->request->getVar('kotaId'),
                        'usralKotaNama' => $this->request->getVar('kotaNama'),
                        'usralKotaTipe' => $this->request->getVar('kotaTipe'),
                        'usralProvinsiId' => $this->request->getVar('provinsiId'),
                        'usralProvinsiNama' => $this->request->getVar('provinsiNama'),
                        'usralKecamatanId' => $this->request->getVar('kecamatanId'),
                        'usralKecamatanNama' => $this->request->getVar('kecamatanNama'),
                        'usralJalan' => $this->request->getVar('jalan'),
                        'usralIsActive' => 1,
                        'usralIsFirst' => 1,
                    ]);
                }

                $this->_waMessageOTP($entity->noWa, $otpCode);
                Notification::sendEmail($entity->email, 'Verifikasi', view('Template/email/verifikasi', [
                    'nama' => $entity->nama,
                    'key' => $uuidV4,
                ]));
                return $this->response(null, ($status ? 200 : 500), ($status ? 'Akun berhasil didaftarkan, silahkan cek email atau Kode OTP pada WA anda untuk mengaktivasi akun anda' : null));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Message WA
     *
     * @param [type] $noWa
     * @param [type] $otpCode
     * @return void
     */
    private function _waMessageOTP($noWa, $otpCode)
    {
        $waMessage = "KODE OTP : $otpCode kode ini bersifat rahasia, jangan diberikan ke orang lain";

        Notification::sendWa($noWa, $waMessage);
    }

    /**
     * Resend OTP Code
     *
     * @return void
     */
    public function resendOtpCode()
    {
        $username = $this->request->getVar('email');

        if ($this->validate([
            'email' => ['label' => 'Email', 'rules' => 'required'],
        ], $this->validationMessage)) {
            try {

                $userModel = new UserModel();
                $data = $userModel->find($username);
                $otpCode = random_string('numeric', '6');
                $data->otpCode = $otpCode;
                $userModel->save($data);

                $this->_waMessageOTP($data->noWa, $otpCode);
                return $this->response(null, 200, 'Kode OTP berhasil dikirim ke WA anda');
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Verifikasi VIA WEB
     *
     * @return void
     */
    public function verifikasiOtpCode()
    {
        $username = $this->request->getVar('email');
        $otpCode = $this->request->getVar('otpCode');

        if ($this->validate($this->rulesVerifikasiOtp, $this->validationMessage)) {
            try {

                $userModel = new UserModel();
                $data = $userModel->find($username);

                if ($data->otpCode == $otpCode) {
                    $data->isActive = 1;
                    $data->otpCode = null;
                    $userModel->save($data);

                    return $this->response(null, 200, 'Akun berhasil di aktivasi');
                } else {
                    return $this->response(null, 403, 'Kode OTP anda salah');
                }
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Reset Password
     *
     * @return void
     */
    public function resetPassword()
    {
        if ($this->validate([
            'email' => ['label' => 'email', 'rules' => 'required|cek_email_tidak_terdaftar'],
        ], $this->validationMessage)) {

            $uuidV4 = Uuid::uuid4();
            $email = $this->request->getVar('email');

            try {
                $status = true;

                $userModel = new UserModel();
                $userModel->update($this->request->getVar('email'), [
                    'usrActiveCode' => $uuidV4,
                ]);

                $userModel = new UserModel();
                $userData = $userModel->find($email);
                
               
                $status = Notification::sendEmail($email, 'Ubah Password', view('Template/email/reset_password', [
                    'nama' => $userData->nama,
                    'key' => $uuidV4,
                ]));

                if(!$status){
                    $waMessage = "Anda telah mengirim permintaan reset password, jika itu memang anda maka silahkan buka tautan ini untuk mengubah password anda akun anda. ".base_url('user/reset_password?key='.$uuidV4);
                    Notification::sendWa($userData->noWa, $waMessage);
                }

                helper('string');
                $filterNoHp = phone_number_sensor($userData->noWa);
                $waMessage = "Anda mengirim permintaan reset password, silahkan buka email atau wa anda di nomor {$filterNoHp} untuk mengubah password baru anda";
                // Notification::sendWa($userData->noWa, $waMessage);

                return $this->response(null, ($status ? 200 : 500), ($status ? $waMessage : null));
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    /**
     * Cek PIN Status
     *
     * @param [type] $pins
     * @return void
     */
    public function checkPin($pins)
    {
        $userModel = new UserModel();
        $userData = $userModel->find($this->user['email']);

        if ($userData->pin == $pins || $userData->pin == null) {
            return $this->response(null, 200, 'Pin Benar');
        } else {
            return $this->response(null, 403, 'Pin Salah');
        }
    }

    /**
     * Mengubah PIN
     *
     * @return void
     */
    public function updatePin()
    {
        if ($this->validate([
            'pinLama' => ['label' => 'Pin Lama', 'rules' => 'required|numeric|min_length[6]|max_length[6]'],
            'pinBaru' => ['label' => 'Pin Baru', 'rules' => 'required|numeric|min_length[6]|max_length[6]'],
        ], $this->validationMessage)) {
            try {
                $post = $this->request->getVar();
                $userModel = new UserModel();
                $userData = $userModel->find($this->user['email']);

                if ($userData->pin == $post['pinLama'] || $userData->pin == null) {
                    $userData->pin = $post['pinBaru'];
                    $userModel->save($userData);
                    return $this->response(null, 200, 'Pin berhasil di ubah');
                } else {
                    return $this->response(null, 403, 'Pin lama salah');
                }
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }


    public function testEmail()
    {
        $data = Notification::sendEmail('ahmadjuhdi007@gmail.com', 'Verifikasi', view('Template/email/verifikasi', [
            'nama' => 'Ahmad Juhdi',
            'key' => Uuid::uuid4(),
        ]));

        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    /**
     * Verifikasi VIA WEB
     *
     * @return void
     */
    public function verifikasi()
    {
        $key = $this->request->getGet('key');

        $modelUser = new UserModel();
        $status = $modelUser->where('usrActiveCode', $key)->update(null, [
            'usrIsActive' => '1',
        ]);

        $data = $modelUser->where('usrActiveCode', $key);

        return view('Template/sukses_verifikasi');
    }

    /**
     * Reset Password VIA Web
     *
     * @return void
     */
    public function reset_password()
    {
        $key = $this->request->getGet('key');
        if (empty($key)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $modelUser = new UserModel();
        $userEntity = new EntitiesUser();
        $dataUser = current($modelUser->where('usrActiveCode', $key)->find());

        if ($this->request->isAJAX()) {
            $newPassword = $this->request->getPost('new_password');
            $verifyPassword = $this->request->getPost('verify_password');

            if (empty($newPassword) || empty($verifyPassword)) {
                return $this->response(null, 401, 'Password wajib di isi');
            } else if ($newPassword !== $verifyPassword) {
                return $this->response(null, 401, 'Password baru dan password tidak sama');
            }

            $status = $modelUser->update($dataUser->email, [
                'usrPassword' => $userEntity->hashPassword($newPassword),
                'usrActiveCode' => null,
            ]);

            return $this->response(null, $status ? 200 : 500, $status ? 'Password berhasil diubah' : 'Password gagal di ubah');
        } else {
            if (!empty($dataUser)) {
                return view('Template/reset_password', [
                    'key' => $key,
                    'user' => $dataUser
                ]);
            }

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
