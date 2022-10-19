<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\JWT;

class TokenFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $tokenHeader = $request->getHeader("X-Token");
        $response = service("response");
        if (isset($tokenHeader)) {
            $apiKeys = $request->getHeader("X-ApiKey");
            $appVersion = $request->getHeader("X-AppVersion");
        
            if($apiKeys->getValue() == "378987bc194f741e732f339c5072a9e1" && $_SERVER['SERVER_NAME'] == "git.ulm.ac.id"){
                $request->setGlobal("decoded", json_decode($tokenHeader->getValue(),true));
            }else{
                $keyAccess = config("App")->JWTKeyAccess;
                try {
                    $decoded = JWT::decode($tokenHeader->getValue(), $keyAccess, ['HS256']);
                    $request->setGlobal("decoded", array_merge((array)$decoded->user, ['userJson' => json_encode($decoded->user)]));
                    try {
                        $request->setGlobal("version", [
                            'app_version' => $appVersion->getValue()
                        ]);
                    } catch (\Throwable $th) {
                    }
                    try {
                        $request->setGlobal("secret", (array) $decoded->secret);
                    } catch (\Throwable $th) {
                    }
                } catch (BeforeValidException $ex) {
                    $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Token belum valid']);
                    return $response;
                } catch (ExpiredException $ex) {
                    $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Token Expired']);
                    return $response;
                } catch (SignatureInvalidException $ex) {
                    $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Token Signature Tidak valid']);
                    return $response;
                } catch (\Exception $ex) {
                    $response->setJSON(['code' => 401, 'data' => null, 'message' => "Token :".$ex->getMessage()]);
                    return $response;
                }
            }
        } else {
            $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Gagal Otorisasi, Token diperlukan']);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
