<?php namespace App\Controllers\Api\Tokopedia;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use App\Controllers\Api\Tokopedia\MyResourceTokopedia;

class Auth extends MyResourceTokopedia
{
  
    public function sendOTP()
    {
        if ($this->validate([
            'msisdn' => 'required|numeric',
        ], $this->validationMessage)) {
            $msisdn = $this->request->getPost('msisdn');

            $response = $this->tokpedApi->sendOTP($msisdn);

            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function auth()
    {
        if ($this->validate([
            'otp' => 'required|numeric|min_length[6]|max_length[6]',
            'msisdn' => 'required|numeric',
        ], $this->validationMessage)) {
            
            try {
                // Example Data
                $response = json_decode('{
                    "login_token": {
                        "access_token": "_qFVPuOGSwmbWMNtEMNuAQ",
                        "refresh_token": "GIb3AMKKR3WODG0a0nQNyA",
                        "token_type": "Bearer",
                        "sid": "3h-2S5hWjPoAGUBdhe6H2rL_wjamS6KnMYXusPcHOD9vktg3eoaF0xIxQbkDTkVC0Mg487zfp_Mfqxlk8pBbiDdFBhl9RSeHFVPc0-5y0kK6am1GvKMZcBh02YIEuWQd",
                        "acc_sid": "",
                        "errors": [],
                        "popup_error": {
                            "header": "",
                            "body": "",
                            "action": "",
                            "__typename": "PopupTokenError"
                        },
                        "sq_check": false,
                        "cotp_url": "",
                        "uid": 208950763,
                        "action": 0,
                        "event_code": "SuccessLoginPhone",
                        "expires_in": 5184000,
                        "__typename": "TokenInfoV2"
                    }
                }', true);

                $otp = $this->request->getPost('otp');
                $msisdn = $this->request->getPost('msisdn');

                $response = $this->tokpedApi->validasiOTP($otp, $msisdn);
                $response = $this->tokpedApi->loginMutationV2($response['OTPValidate']['validateToken'], $msisdn);
                
                if(!empty($response['login_token']['access_token'])){
                    $response['login_token']['msisdn'] = $msisdn;
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
        
                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "user" => $response['login_token'],
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + $response['login_token']['expires_in'], // Expires Tokopedia Nakama
                        "user" => $response['login_token'],
                        "key" => $apiKeys
                    ];
    
                    $accessToken = JWT::encode($accessPayload, $keyAccess);
                    $refreshToken = JWT::encode($refreshPayload, $keyRefresh);
    
                    return $this->response(['accessToken' => $accessToken, 'refreshToken' => $refreshToken], 200);
                }

                return $this->response($response, 403, 'Login gagal');
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function refresh()
    {
        if ($this->validate(['tokenRefresh' => 'required'])) {
            $apiKeys = $this->request->getHeaderLine("X-ApiKey");
            $tokenRefresh = $this->request->getVar("tokenRefresh");

            try {
                $keyRefresh = config("App")->JWTKeyRefresh;
                $decoded = JWT::decode($tokenRefresh, $keyRefresh, ['HS256']);
                $keyAccess = config("App")->JWTKeyAccess;
                $accessPayload = [
                    "iss" => base_url(),
                    "aud" => base_url(),
                    "iat" => time(),
                    "nbf" => time(),
                    "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                    "user" => (array) $decoded->user,
                    "key" => $apiKeys
                ];
                $accessToken = JWT::encode($accessPayload, $keyAccess);
                return $this->response(['accessToken' => $accessToken]);
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

    public function isAuth()
    {
        $response = $this->tokpedApi->isAuth();

        return $this->response($response);
    }
}
