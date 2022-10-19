<?php

namespace App\Libraries;

use Config\App;
use CodeIgniter\Config\Config;

class MyIpaymuPayment
{
    private static $instances = [];

    private $curl = null;

    private $apiKey = 'QbGcoO0Qds9sQFDmY0MWg1Tq.xtuh1';
    private $va = '1179000899';
    private $subdomain = ENVIRONMENT != 'production' ? 'sandbox' : 'my';
    private $baseUri = '';
    private $formData = [];

    public function __construct()
    {
        $this->baseUri = 'https://'.$this->subdomain.'.ipaymu.com/api/v2/';

        $this->options = [];
        $options['baseURI'] = $this->baseUri;
        $options['headers']['signature'] = $this->apiKey;
        $options['headers']['va'] = $this->va;
       
        $this->curl = \Config\Services::curlrequest($options);
    }

    /**
     * Ini adalah method static yang mengontrol akses ke singleton
     * instance. Saat pertama kali dijalankan, akan membuat objek tunggal dan menempatkannya
     * ke dalam array statis. Pada pemanggilan selanjutnya, ini mengembalikan klien yang ada
     * pada objek yang disimpan di array statis.
     *
     * Implementasi ini memungkinkan Anda membuat subclass kelas Singleton sambil mempertahankan
     * hanya satu instance dari setiap subclass sekitar.
     * @return MyIpaymuPayment
     */

    public static function getInstance(): MyIpaymuPayment
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    
   /**
    * Check Balance
    *
    * @return void
    */
    public function checkBalance()
    {
        $response = $this->setFormData([
            'account' => $this->va,
        ])->execute('POST', 'balance');
       
        return $response;
    }

    /**
     * Cek Transaksi terakhir
     *
     * @param [type] $transactionId
     * @return void
     */
    public function checkTransaction($transactionId)
    {
        $response = $this->setFormData([
            'transactionId' => $transactionId,
        ])->execute('POST', 'transaction');
       
        return $response;
    }

    public function directPayment($data)
    {
        $response = $this->setFormData($data)->execute('POST', 'payment/direct');
       
        return $response;
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
     * @param bool $multipart
     * @return $this
     */
    private function setFormData(array $params, bool $multipart = false)
    {
        $this->formData = $params;
        $this->curl->setForm($params, $multipart);
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
        $options['baseURI'] = $this->baseUri;
        $options['headers']['signature'] = $this->generateSignature($this->formData, $method);
        $options['headers']['timestamp'] = Date('YmdHis');
        $options['debug'] = WRITEPATH.'/logs/log_curl.txt';
        $options['http_errors'] = false;

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
    
    private function generateSignature($body, $method){
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody));
        $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->apiKey;
        $signature    = hash_hmac('sha256', $stringToSign, $this->apiKey);

        return $signature;
    }

}
