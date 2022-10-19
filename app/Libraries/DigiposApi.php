<?php

namespace App\Libraries;

use Exception;

class DigiposApi
{
    private static $instances = [];

    private $curl = null;
    private $versionApk = '5.13.1.235';
    private $secretKeyPin = 'digiposoutletapp';
    public $secretKey = '';
    private object $userData;

    /**
     * Expired 1 Bulan
     *
     * @param [type] $userToken
     */
    public function __construct($secretKeyUser, $versionApk = '', $userData = [])
    {
        $this->secretKey = $secretKeyUser;
        $this->secretKeyPin = md5($this->secretKeyPin);

        $userToken = [];
        if (isset($secretKeyUser->md5Hex)) {
            $userToken = $this->generateAuthorization($secretKeyUser);
        }

        if(!empty($versionApk)){
            $this->versionApk = $versionApk;
        }

        if(!empty($userData)){
            $this->userData = $userData;
        }

        $this->options = [];
        $options['http_errors'] = false;
        $options['baseURI'] = 'https://digipos.telkomsel.com';
        $options['headers'] = [
            'Host' => 'digipos.telkomsel.com',
            'Authorization' => 'Bearer ' . @$userToken['authorization'] ?? '',
            'X-Dgp-Nonce' => @$userToken['nonce1'] ?? '',
            'Content-Type' => 'application/json; charset=UTF-8',
            'Accept-Encoding' => 'gzip, deflate',
            'User-Agent' => 'okhttp/3.12.12'
        ];

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    function generateAuthorization($secretKeyUser)
    {
        $secretKeyUserHex = $secretKeyUser->md5Hex;
        
        ob_start();
        $cookieFile = readfile(WRITEPATH . "cookie/digipos/$secretKeyUserHex.json");
        $cookieFile = ob_get_clean();
        $cookieData = json_decode($cookieFile);
        
        $cryptResponse = new Cryptography($secretKeyUserHex, 'AES-128-ECB');
        $responseDec = $cryptResponse->sslDecrypt((hex2bin($cookieData->authorization)));
        
        if(!empty($responseDec)){
            $authorizationKey = explode( '|', $responseDec)[0];
            $generateKey = "$authorizationKey|".strtotime(date("Y-m-d H:i:s"))."000|".$this->versionApk;
            $generateKey = $cryptResponse->sslEncrypt($generateKey);
        }else{
            return [];
        }
      
        $str = $generateKey;//"44a787903ca28cf0c740eb33ee044c1c400fcd53fd5f1d69f31826e99565b4be153c1292653ed59fd112fecb178afd14c5946c9b7c47700a1ebeaed28242e72a9cadc2c01c886899d269d3fc842bb124dee5d46f93e5fa0fb2fabd68da07eed1e110b0a6f7708b62720059a8a1bee282ad13bf637d6624b05674a9f93a1a1ff6aca8359b2e584d9bdd05285bbc7490210b2157494d0e2718d4da6eeb3887b83f89f935204e238eeab9d3acb8a80aa641b8d74cd749b2c0e72a33a627fa8e997c57d70aad97f74383aba26c7d20189063018cfca7615f055499355bad4ab816120a7dc3ae90635d4eded3c6af55940e685f19ecc30164c61854df1f3a462ba9bcc0d8ccc24a594c8b59d47d7d42859213c407e89f209e2d08d5a4161fdf650e1630855d5d8ebaca0dbabf2d6de6cb51a116cab4428ba0c859e96531c7f78a9c2ad211b777afc2a57987e41bee8e52f7eb6419ec75c5f3fba8d7964870f3d70e98fc4cb26b8d449f87552cd79379e391f0ecce09a3d21d84c2c9d3372de31cf47e28b9b693afd86bc5ee2da1b93cc213e8870cdea06070a2cb1e69fd287f719cd48f939f9de1ec7201036c739b98e689174da4a74049f4732f410dbfea4268c7b56324a97184758d26bd9e4292529f5266754e9f966a47c13833c742276a410898569728059041764d1124c28521dbf1d4da389e87789903d0b03bf760683a95e81d538e5d17d98ab683ba83fe93e395621a9440af0f9f64402b0344333a870dcb231e33123ee1f2ef58795673b86e24645f44b90dd05c4c892135736ff3ec2446c710e535e3d5de3258fd1501d89e7a8a17bcbd4f26674568a2a3409f53212a61";
        // secretKey
        $str2 = $secretKeyUser->base64 ;//"MsbuwcXLI1lEnC2-WUiB5Q==";

        $bigInteger = 0;
        $length = (int)(strlen($str) / 2);
        $length2 = strlen($str2) + $length;
        $i = 0;
        while ($i < strlen($str2)) {
            $i2 = $length + $i;
            $nextInt = $i == 0 ? rand(0, $i2 - 1) + 1 : rand(0, $i2);
            $i == 0 ? rand(0, $i2 - 1) + 1 : rand(0, $i2);
            $str = $this->_addStrAtOffset($str, bin2hex($str2[$i]), $nextInt * 2);

            $bigInteger = bcadd(bcmul($bigInteger, $length2), $nextInt);
            $i++;
        }

        return [
            'authorization' => $str,
            'nonce1' => $bigInteger,
        ];
    }

    private function _addStrAtOffset($origStr, $insertStr, $offset, $paddingCha = ' ')
    {
        $origStrArr = str_split($origStr, 1);

        if ($offset >= count($origStrArr)) {
            for ($i = count($origStrArr); $i <= $offset; $i++) {
                if ($i == $offset) $origStrArr[] = $insertStr;
                else $origStrArr[] = $paddingCha;
            }
        } else {
            $origStrArr[$offset] = $insertStr . $origStrArr[$offset];
        }

        return implode($origStrArr);
    }


    function generateSecretKey($authorization = '', $nonce = '', $nonce1 = '')
    {
        // Authorization
        $str = "$authorization";
        // X-DGP-nonce
        $bigInteger = "$nonce";
        // X-DGP-nonce1
        $bigInteger2 = "$nonce1";
        $sb = "";

        $length = strlen($bigInteger);
        $valueOf = $length;
        $iArr = array_fill(0, $length, 0);
        for ($i = 0; $i < $length; $i++) {
            $iArr[intval(bcmod($bigInteger2, $valueOf))] = intval(bcmod($bigInteger, 10));
            $bigInteger = bcdiv($bigInteger, 10);
            $bigInteger2 = bcdiv($bigInteger2, $valueOf);
        }

        $i2 = 0;
        for ($i3 = 0; $i3 < $length; $i3++) {
            $i2 += $iArr[$i3];
            $i4 = $i2 * 2;
            $sb .= substr($str, $i4, 2);
            $str = substr_replace($str, '', $i4, 2);
        }

        $secretKeyBase64 = implode(array_map("chr", $this->_generateBase64Format($sb)));
        $result = md5(($this->_base64url_decode($secretKeyBase64)));

        // Save Cookie Files
        $this->saveCookieFile(WRITEPATH . 'cookie/digipos/' . $result . '.json', [
            'authorization' => $str,
            'nonce' => $nonce,
            'nonce1' => $nonce1,
        ]);

        $secretKeyResponse = (object)[
            'md5Hex' => $result,
            'base64' => $secretKeyBase64,
        ];

        $this->secretKey = $secretKeyResponse;

        return $secretKeyResponse;

    }

    private function _base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), 4 - ((strlen($data) % 4) ?: 4), '=', STR_PAD_RIGHT));
    }

    private function _generateBase64Format($str)
    {
        $length = (int)(strlen($str) / 2);
        $bArr = array_fill(0, $length, 0);
        for ($i = 0; $i < $length; $i++) {
            $i2 = $i * 2;
            $bArr[$i] = intval(substr($str, $i2, 2), 16);
        }
        return $bArr;
    }

    private function saveCookieFile($path, $data)
    {
        helper('filesystem');
        if (file_exists($path))
            $statusLog = write_file($path, json_encode($data, JSON_PRETTY_PRINT));
        else
            $statusLog = write_file($path, json_encode($data, JSON_PRETTY_PRINT));

        return $statusLog;
    }

    // private function generateAuthorization()
    // {
    //     $secretKeyPin = $this->secretKeyPin . strtotime(date('Y-m-d H:i:s'));

    //     return md5($secretKeyPin);
    // }

    public static function getInstance($userToken): DigiposApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($userToken);
        }

        return self::$instances[$cls];
    }

    /**
     * Mengembalikan CURL default
     * @return \CodeIgniter\HTTP\CURLRequest
     */
    private function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param array $params
     * @return $this
     */
    private function setBody($body)
    {
        $this->body = $body;
        $this->curl->setBody($body);
        return $this;
    }

    /**
     * Eksekusi request ke API
     * @param $method
     * @param $url
     * @param array $options
     * @return array|mixed
     */
    public function execute($method, $url, $options = [])
    {
        $options['debug'] = WRITEPATH . '/logs/log_digipos.txt';

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);

        if ($response->getStatusCode() == 200) {
            $authorization = ''; $nonce = ''; $nonce1 = '';
            try {
                $authorization = trim($response->getHeader('Authorization')->getValue());
            } catch (\Throwable $th) {
            }
            try {
                $nonce = trim($response->getHeader('X-DGP-nonce')->getValue());
            } catch (\Throwable $th) {
            }
            try {
                $nonce1 = trim($response->getHeader('X-DGP-nonce1')->getValue());
            } catch (\Throwable $th) {
            }

            if(!empty($this->secretKey) || $url == "/api/secure/auth/otp/v2"){
                // Generate Pas Logiin
                if($url == "/api/secure/auth/otp/v2"){
                    $this->generateSecretKey($authorization, $nonce, $nonce1);

                }else{
                    try {
                        $this->saveCookieFile(WRITEPATH . 'cookie/digipos/' . $this->secretKey->md5Hex . '.json', [
                            'authorization' => $authorization,
                            'nonce' => $nonce,
                            'nonce1' => $nonce1,
                        ]);
                    } catch (\Throwable $th) {
                    }
                }

            }

            // Cek hexdecimal response
            if(ctype_xdigit($response->getBody())){
                $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
                $responseDec = $cryptResponse->sslDecrypt((hex2bin($response->getBody())));
    
                if(!empty($responseDec)){
                    return ($responseDec);
                }
            }
        
            $data = json_decode($response->getBody());

            return $data;
        }

        $data = json_decode($response->getBody());

        // return $data;
        throw new Exception($data->message ?? $response->getBody());
    }

    // ========================== AUTH =============================== //

    public function sendOTP($username, $password)
    {
        $passwordHash = md5($password);

        $response = $this
            ->setBody(json_encode([
                "appVersion" => "5.13.1",
                "browser" => "Native",
                "browserVersion" => "",
                "deviceId" => "353739786799247",
                "fcmToken" => "f0-qrBStRvC2xK0GTIjall:APA91bGR--rzG5fv5vV4sH9tTgoypsMx8hs-f1yz1OVh4TQlnIA7C78sEbsCbO7SckXQuxzwo786FUYjCnnFvYaG53SP_6Io78zNro2DvycptRLRyqEleGx2n_-St6NfwUU85MN0ojS5",
                "forceLogin" => "true",
                "isBrowser" => "false",
                "karyawan" => "false",
                "keepMeLoggedIn" => true,
                "os" => "Android",
                "osVersion" => "7.1.2",
                "password" => "yas{$passwordHash}",
                "username" => $username
            ]))
            ->execute('POST', "/api/secure/user/auth/v2");

        return $response;
    }

    public function auth($otp, $token)
    {
        $response = $this
            ->setBody(json_encode([
                "otp" => $otp,
                "token" => $token,
            ]))
            ->execute('POST', "/api/secure/auth/otp/v2");

        return $response;
    }

    // ========================== USER =============================== //

    public function getKategori()
    {
        $response = $this
            ->execute('GET', "/api/secure/messages/categories");

        return $response;
    }

    public function getProfile()
    {
        $response = $this
            ->execute('GET', "/api/secure/reward/summary");

        return $response;
    }

    public function cekSaldo($type = 'linkaja')
    {
        $response = $this
            ->execute('GET', "/api/secure/balance/v2/$type");

        return $response;
    }

    // ========================== PRODUCT =============================== //

   
    private $urlMap = [
        'pulsa' => [
            'product' => '/api/secure/recharge/denom?',
            'recharge' => "/api/secure/recharge/v3", 
            'confirm' => "/api/secure/recharge/confirm/v2",
        ],
        'paket_data' => [
            'product' => '/api/secure/product/v6?categoryCode=DATA&', // HVC = PRODUK Rekomendasi
            'recharge' => "/api/secure/package-activation/v7",
            'confirm' => "/api/secure/package-activation/confirm/v7",
        ],
        'digital' => [
            'product' => '/api/secure/product/v6?categoryCode=DIGITAL&digitalProductType=DIRECT_TOP_UP&',
            'check' => "/api/secure/package-activation/submit/dtu/v2",
            'recharge' => "/api/secure/package-activation/v7",
            'confirm' => "/api/secure/package-activation/confirm/v7",
        ],
        'perdana_internet' => [
            'product' => '/api/secure/product/v6?trxType=ARP&categoryCode=NSB&paymentMethod=LINKAJA&brand=SIMPATI&',
            'check' => "/api/secure/package-activation/submit/dtu/v2",
            'recharge' => "/api/secure/package-activation/v7",
            'confirm' => "/api/secure/package-activation/confirm/v7",
        ],
        'roaming' => [
            'product' => '/api/secure/product/v6?categoryCode=ROAMING&',
            'recharge' => "/api/secure/package-activation/v6",
            'confirm' => "/api/secure/package-activation/confirm/v6",
        ],
    ];

    public function getProduct($msisdn, $paymentMethod = 'LINKAJA', $url = 'pulsa')
    {
        $response = $this
            ->execute('GET', $this->urlMap[$url]['product']."msisdn=$msisdn&paymentMethod=$paymentMethod");

        return $response;
    }

    public function check($data, $url = 'pulsa')
    {
        $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
        
        $formData = $cryptResponse->sslEncrypt(json_encode($data));
        
        $response = $this
            ->setBody($formData)
            ->execute('POST', $this->urlMap[$url]['check']);

        return $response;
    }

    public function recharge($data, $url = 'pulsa')
    {
        $data['userId'] = $this->userData->userId;
        $data['rsNumber'] = $this->userData->rsOutlet->rsNumber;
        $data['outletId'] = $this->userData->rsOutlet->outletId;
     
        $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
        
        $formData = $cryptResponse->sslEncrypt(json_encode($data));
        
        $response = $this
            ->setBody($formData)
            ->execute('POST', $this->urlMap[$url]['recharge']);

        return $response;
    }

    public function confirm($data, $url = 'pulsa')
    {
        $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
        $cryptPin = new Cryptography($this->secretKeyPin, 'AES-128-ECB');
        $data['pin'] =  $cryptPin->sslEncrypt($data['pin']);
        
        $formData = $cryptResponse->sslEncrypt(json_encode($data));
      
        $response = $this
            ->setBody($formData)
            ->execute('POST', $this->urlMap[$url]['confirm']);

        return $response;
    }

    // ========================== END PRODUCT =============================== //

    // ========================== PPOB =============================== //

    public function ppobList()
    {
        $response = $this
            ->execute('GET', '/api/secure/ppob/ppob-list/v2');

        return $response;
    }

    public function ppobDetail($code = 'BPJS')
    {
        $response = $this
            ->execute('GET', '/api/secure/ppob/ppob-list/detail?code='.$code);

        return $response;
    }

    public function ppobPrice($shortCode = 'pdam_bukittinggi')
    {
        $response = $this
            ->execute('GET', '/api/secure/ppob/ppob-list/detail/price?shortcode='.$shortCode);

        return $response;
    }

    public function ppobPreInquiry($data)
    {
        $data['userId'] = $this->userData->userId;
        $data['rsNumber'] = $this->userData->rsOutlet->rsNumber;
        $data['outletId'] = $this->userData->rsOutlet->outletId;
     
        $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
        
        $formData = $cryptResponse->sslEncrypt(json_encode($data));
        
        $response = $this
            ->setBody($formData)
            ->execute('POST', '/api/secure/ppob/pre-ppob-with-inquiry/v2');

        return $response;
    }

    public function ppobConfirm($data)
    {
        $data['userId'] = $this->userData->userId;
        $data['rsNumber'] = $this->userData->rsOutlet->rsNumber;
        $data['outletId'] = $this->userData->rsOutlet->outletId;

        $cryptResponse = new Cryptography($this->secretKey->md5Hex, 'AES-128-ECB');
        $cryptPin = new Cryptography($this->secretKeyPin, 'AES-128-ECB');
        $data['securityCredential'] =  $cryptPin->sslEncrypt($data['securityCredential']);

        $formData = $cryptResponse->sslEncrypt(json_encode($data));
      
        $response = $this
            ->setBody($formData)
            ->execute('POST', '/api/secure/ppob/confirmation');

        return $response;
    }

    // ========================== END PPOB =============================== //


}
