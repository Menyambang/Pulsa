<?php namespace App\Controllers\Api\Rita;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;
use App\Controllers\Api\Rita\MyResourceRita;

class Auth extends MyResourceRita
{
  
    public function sendOTP()
    {
        if ($this->validate([
            'msisdn' => 'required|numeric',
            'retailerId' => 'required|numeric',
        ], $this->validationMessage)) {
            $msisdn = $this->request->getPost('msisdn');
            $retailerId = $this->request->getPost('retailerId');

            $response = $this->ritaApi->sendOTP($msisdn, $retailerId);

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
            'retailerId' => 'required|numeric',
        ], $this->validationMessage)) {
            
            $otp = $this->request->getPost('otp');
            $msisdn = $this->request->getPost('msisdn');
            $retailerId = $this->request->getPost('retailerId');

            try {
                // Example Data
                $response = json_decode('{
                    "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJxckNvZGUiOiIwMDI1OTA5NCIsInVzZXJfbmFtZSI6IjA4OTk0NTg3MTA3Iiwic2NvcGUiOlsicmVhZCIsIndyaXRlIl0sInJldGFpbGVyTmFtZSI6IlN1bWJ1IENlbGwiLCJpc0ZpcnN0dGltZSI6ZmFsc2UsImdhdGV3YXlUb2tlbiI6InNmYnl0c3phMjVua3cydDMzdXphbTNzeCIsIm1zaXNkbiI6IjA4OTk0NTg3MTA3IiwiYXV0aG9yaXRpZXMiOlsiVVNFUiJdLCJqdGkiOiJjMGZiNDFjZC1mOTBmLTQ0ZmEtYjBhNi1lM2VmYTY1Njg3MGMiLCJjbGllbnRfaWQiOiJyaXRhMiIsInN0YXR1cyI6dHJ1ZX0.da59DrIKdNAYz8uem1FoEEe6t9UfmxqVVfp_EkeSAds",
                    "token_type": "bearer",
                    "scope": "read write",
                    "qrCode": "00259094",
                    "retailerName": "Sumbu Cell",
                    "isFirsttime": false,
                    "gatewayToken": "sfbytsza25nkw2t33uzam3sx",
                    "msisdn": "08994587107",
                    "status": true,
                    "jti": "c0fb41cd-f90f-44fa-b0a6-e3efa656870c"
                }', true);

                $response = $this->ritaApi->verifyToken($msisdn, $otp, $retailerId);
                
                if(isset($response['access_token'])){
                    $apiKeys = $this->request->getHeaderLine("X-ApiKey");
                    $keyAccess = config("App")->JWTKeyAccess;
                    $keyRefresh = config("App")->JWTKeyRefresh;
        
                    $accessPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_ACCESS_TOKEN,
                        "user" => $response,
                        "key" => $apiKeys
                    ];
                    $refreshPayload = [
                        "iss" => base_url(),
                        "aud" => base_url(),
                        "iat" => time(),
                        "nbf" => time(),
                        "exp" => time() + self::LIFETIME_REFRESH_TOKEN, 
                        "user" => $response,
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
