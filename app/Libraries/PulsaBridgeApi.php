<?php

namespace App\Libraries;

use App\Models\SettingModel;
use CodeIgniter\Config\Config;
use CodeIgniter\Session\Session;
use Config\App;

class PulsaBridgeApi
{
    private static $instances = [];

    private $curl = null;

    private $baseUri = 'http://128.199.225.33:8089/api/h2h';
    private $id = 'SP6764';
    private $pin = '191288';
    private $user = '8222A3';
    private $pass = 'A64564';
    private $counter = '1';
    private $idtrx = '10120304';
    private $formData = [];

    public function __construct()
    {
        $this->options = [];
        $options['baseURI'] = $this->baseUri;

        $settingModel = new SettingModel();
        $settingData = $settingModel->getAllSettingKey();

        $this->baseUri  = @$settingData['h2h_endpoint'];
        $this->id       = @$settingData['h2h_id'];
        $this->pin      = @$settingData['h2h_pin'];
        $this->user     = @$settingData['h2h_user'];
        $this->pass     = @$settingData['h2h_pass'];
        $this->counter  = $settingData['h2h_counter'] ?? $this->counter;
        $this->idtrx    = @$settingData['h2h_idtrx'];

        $this->curl     = \Config\Services::curlrequest($options);
    }

    /**
     * Ini adalah method static yang mengontrol akses ke singleton
     * instance. Saat pertama kali dijalankan, akan membuat objek tunggal dan menempatkannya
     * ke dalam array statis. Pada pemanggilan selanjutnya, ini mengembalikan klien yang ada
     * pada objek yang disimpan di array statis.
     *
     * Implementasi ini memungkinkan Anda membuat subclass kelas Singleton sambil mempertahankan
     * hanya satu instance dari setiap subclass sekitar.
     * @return PulsaBridgeApi
     */

    public static function getInstance(): PulsaBridgeApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    /**
     * GET
     *
     * @param [type] $query
     * @return void
     */
    public function get($query)
    {
        $query = array_merge(
            [
                'id' => $this->id,
                'pin' => $this->pin,
                'user' => $this->user,
                'pass' => $this->pass,
                'counter' => $this->counter,
                'idtrx' => $this->idtrx,
            ],
            $query
        );

        $response = $this->execute('GET', '', [
            "query" => $query
        ]);

        return $response;;
    }

    /**
     * POST
     *
     * @param [type] $query
     * @return void
     */
    public function post($query)
    {
        
        $response = $this->execute('POST', '', [
            "query" => '
                        '
        ]);

        return $response;;
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
    public function execute($method, $url, $options = [])
    {
        $options['debug'] = WRITEPATH . '/logs/log_curl_pulsa_bridge.txt';
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
