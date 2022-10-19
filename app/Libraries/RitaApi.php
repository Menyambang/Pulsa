<?php

namespace App\Libraries;

use DateTime;
use Config\App;
use CodeIgniter\Config\Config;
use CodeIgniter\Session\Session;
use Exception;

class RitaApi
{
    private static $instances = [];

    private $curl = null;
    private $key = 'r2dgdc2ftby4ngcj6fatx43v';
    private $secret = 'ZATDWd27EG';

    /**
     * Expired 1 Bulan
     *
     * @param [type] $userToken
     */
    public function __construct($userToken)
    {
        $this->options = [];
        $options['http_errors'] = false;
        $options['baseURI'] = 'https://rita2.tri.co.id';
        $options['headers'] = [
            'Host' => 'rita2.tri.co.id',
            'Cache-Control' => 'public, max-age=5',
            'Content-Type' => 'application/json',
            'User-Agent' => 'okhttp/4.9.0',
            // 'Connection' => 'close',
            'Authorization' => 'Bearer ' . $userToken,
        ];

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    private function getSigNature()
    {
        $secret = $this->key . $this->secret . strtotime(date('Y-m-d H:i:s'));

        return md5($secret);
    }

    public static function getInstance($userToken): RitaApi
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
        $options['debug'] = WRITEPATH . '/logs/log_rita.txt';

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);
        
        if($response->getStatusCode() == 200){
            $data = json_decode($response->getBody(), true);
    
            if (isset($data['data'])) {
                return $data['data'];
            } else {
                return $data;
            }
        }

        throw new Exception($response->getBody());

    }

    // ========================== AUTH =============================== //

    public function sendOTP($msisdn, $retailerId)
    {
        $response = $this
            ->setBody('{
                            "force": 1,
                            "msisdn": "' . $msisdn . '",
                            "qrCode": "' . $retailerId . '"
                        }')

            ->execute('POST', "/api/v2/login/otp-request?api_key=" . $this->key . "&sig=" . $this->getSigNature());

        return $response;
    }


    public function verifyToken($username, $password, $retailerId)
    {
        $response = $this
            ->execute('POST', "/api/v2/oauth/token?grant_type=password&username=$username&password=$password&qrCode=$retailerId&api_key=" . $this->key . "&sig=" . $this->getSigNature(), [
                'headers' => [
                    'Authorization' => 'Basic cml0YTI6cml0YTJzM2NyM3Q1',
                ],
            ]);

        return $response;
    }

    // ========================== END AUTH =============================== //

    // ========================== USER =============================== //

    public function getProfile()
    {
        return $this->execute('GET', "/api/v2/homescreen/profile");
    }

    public function getBalance()
    {
        return $this->execute('GET', "/api/v2/profile/balance");
    }

    public function getHome()
    {
        return $this->execute('GET', "/api/v2/profile/home");
    }

    // ========================== END USER =============================== //

    // ========================== TRANSACTION =============================== //

    public function getTransactionList()
    {
        return $this->execute('GET', "/api/v2/transaction/get");
    }

    // ========================== END TRANSACTION =============================== //

    // ========================== PRODUCT =============================== //

    public function getProduct($categoryId)
    {
        return $this->execute('GET', "/api/v2/product/get-product/$categoryId");
    }

    public function rechargeProduct($msisdn, $trxMsisdn, $pin, $productCode, $productPrice, $productName)
    {
        return $this
            ->setBody('{
                "groupFeature": "RITATOPUP",
                "msisdn": "'.$msisdn.'",
                "pin": "'.$pin.'",
                "productCode": "'.$productCode.'",
                "productName": "'.$productName.'",
                "productPrice": "'.$productPrice.'",
                "trxMsisdn": "'.$trxMsisdn.'"
            }')
            ->execute('POST', "/api/v2/product/activation-product-recharges");
    }

    // ========================== END PRODUCT =============================== //
}
