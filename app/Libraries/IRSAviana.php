<?php

namespace App\Libraries;

use Exception;

class IRSAviana
{
    private static $instances = [];

    private $curl = null;
    private $versionApk = '5.13.1.235';
    private $baseUrl = 'http://128.199.225.33:8089';
    private $secretKey = '988FD5935BB9FBC3530314B2619BF603';

    /**
     * Expired 1 Bulan
     *
     * @param [type] $userToken
     */
    public function __construct($user)
    {
        $uuid = 'Ye93XnPQEIfFInSvW92TZM9H2M57';

        $this->options = [];
        $options['http_errors'] = false;
        $options['baseURI'] = $this->baseUrl;
        $options['headers'] = [
            'irsauth' => $this->generateIRSAuth($uuid), // V8
            'x-auth-irs' => $this->generateXIRSAuth($uuid), // V9
            // 'Authorization' => 'Bearer ',
            'Accept' => '*/*',
            'Host' => '128.199.225.33:8089',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/x-www-form-urlencoded',
            // 'Content-Length' => '52'
        ];

        // echo '<pre>';
        // print_r($options);
        // echo '</pre>';exit;

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    private function generateIRSAuth($uuid){
        return md5(md5(md5($this->secretKey.$uuid)));
    }

    private function generateXIRSAuth($uuid){
        return md5($this->secretKey.$uuid);
    }


    public static function getInstance($userToken): IRSAviana
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
        $uuid = 'Ye93XnPQEIfFInSvW92TZM9H2M57';
        $body = (array_merge([
            'uuid' => $uuid,
        ], $body));
        $this->body = $body;
        $this->curl->setForm($body);
        return $this;
    }

    /**
     * Eksekusi request ke API
     * @param $method
     * @param $url
     * @param array $options
     * @return array|mixed
     */
    private function execute($method, $url, $options = [])
    {
        // $options['debug'] = WRITEPATH . '/logs/log_aviana.txt';

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);

        if ($response->getStatusCode() == 200) {
            $jsonArray = json_decode($response->getBody(), true);
            return $jsonArray;
        } else {
            return json_decode($response->getBody(), true);
            return [
                'code' => $response->getStatusCode(),
                'message' => json_decode($response->getBody(), true),
                'data' => null,
            ];
        }
    }



    // ========================== V8 =============================== //

    // ========================== AUTH =============================== //

    public function auth($phoneNumber)
    {
        $response = $this
            ->setBody([
                "phone" => $phoneNumber,
            ])
            ->execute('POST', "/apps/v8/users/accountkit");

        return $response;
    }

    // ========================== END AUTH =============================== //

    // ========================== END V8 =============================== //
}
