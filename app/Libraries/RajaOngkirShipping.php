<?php

namespace App\Libraries;

use CodeIgniter\Config\Config;
use CodeIgniter\Session\Session;
use Config\App;

class RajaOngkirShipping
{
    private static $instances = [];

    private $curl = null;

    private $apiKey = 'f70a07c9eb25d5f27b81093e624ce50b';
    private $baseUri = 'https://pro.rajaongkir.com/api/';
    private $formData = [];

    public function __construct()
    {
        $this->options = [];
        $options['baseURI'] = $this->baseUri;
        $options['headers']['key'] = $this->apiKey;

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
     * @return RajaOngkirShipping
     */

    public static function getInstance(): RajaOngkirShipping
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * Check Province
     *
     * @return void
     */
    public function province($id = null)
    {
        $response = $this->execute('GET', 'province', [
            "query" => [
                'id' => $id
            ]
        ]);

        return $this->parsingResponse($response);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id ID kota/kabupaten
     * @param [type] $province ID propinsi
     * @return void
     */
    public function city($id = null, $province = null)
    {
        $response = $this->execute('GET', 'city', [
            "query" => [
                'id' => $id,
                'province' => $province,
            ]
        ]);

        return $this->parsingResponse($response);
    }

    /**
     * Undocumented function
     *
     * @param [type] $origin ID kota atau kabupaten asal
     * @param [type] $destination ID kota atau kabupaten tujuan
     * @param [type] $weight Berat kiriman dalam gram
     * @param [type] $courier Kode kurir: jne, pos, tiki.
     * @return void
     */
    public function cost($origin, $destination, $weight, $courier, $originType = 'city', $destinationType = 'city')
    {
        $data = [];
        $data['origin'] = $origin;
        $data['destination'] = $destination;
        $data['weight'] = $weight;
        $data['courier'] = $courier;
        $data['originType'] = $originType;
        $data['destinationType'] = $destinationType;

        $response = $this->setFormData($data)->execute('POST', 'cost');

        return $this->parsingResponse($response);
    }

    public function waybill($waybill, $courier)
    {
        $data = [];
        $data['waybill'] = $waybill;
        $data['courier'] = $courier;

        $response = $this->setFormData($data)->execute('POST', 'waybill');

        return $this->parsingResponse($response);
    }

    public function subdistrict($city)
    {
        $response = $this->execute('GET', 'subdistrict', [
            "query" => [
                'city' => $city,
            ]
        ]);

        return $this->parsingResponse($response);
    }

    public function currency()
    {
        $response = $this->execute('GET', 'currency', [
            "query" => [
            ]
        ]);

        return $this->parsingResponse($response);
    }

    private function parsingResponse($response){
        $data = [];

        $rajaOngkir = $response['rajaongkir'];
        $data['code'] = $rajaOngkir['status']['code'];
        $data['message'] = $rajaOngkir['status']['description'];
        $data['data'] = $rajaOngkir['results'] ?? $rajaOngkir['result'] ?? null;
        
        if(isset($rajaOngkir['origin_details'])){
            $data['extra'] = [
                'origin_details' => $rajaOngkir['origin_details'] ?? [],
                'destination_details' => $rajaOngkir['destination_details'] ?? [],
            ];
        }

        return $data;
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
    private function setFormData(array $params)
    {
        $this->formData = $params;
        $this->curl->setForm($params);
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
        $options['debug'] = WRITEPATH . '/logs/log_curl_raja_ongkir.txt';
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
}
