<?php

namespace App\Libraries;

use App\Models\SettingModel;
use Exception;

class IRSAviana
{
    private static $instances = [];

    private $curl = null;
    private $baseUrl = 'http://128.199.225.33:8089';
    private $secretKey = '988FD5935BB9FBC3530314B2619BF603';
    private $noHp = '';
    private $body = [];
    private $apiVersion = 'v8';

    /**
     * Expired 1 Bulan
     *
     * @param [type] $userToken
     */
    public function __construct($user)
    {
        $pengaturan = new SettingModel();

        $this->baseUrl = $pengaturan->getValue($pengaturan::API_URL_KEY);
        $this->secretKey = $pengaturan->getValue($pengaturan::API_SECRET_KEY);

        $this->noHp = md5($user['noHp'] ?? $this->secretKey);

        $this->options = [];
        $options['http_errors'] = false;
        $options['baseURI'] = $this->baseUrl;
        $options['headers'] = [
            'irsauth' => $this->generateIRSAuth($this->noHp), // V8
            'x-auth-irs' => $this->generateXIRSAuth($this->noHp), // V9
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        if(isset($user['token'])){
            $options['headers']['Authorization'] = "Bearer $user[token]";
        }

        $this->curl = \Config\Services::curlrequest($options, null, null, false);

        $this->body = [
            'uuid' => $this->noHp,
        ];
        $this->curl->setForm($this->body);
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
        $this->body = array_merge($this->body,$body);
        $this->curl->setForm($this->body);
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
        $options['debug'] = WRITEPATH . '/logs/log_aviana.txt';

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        try {
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
        } catch (\Throwable $th) {
            return ['msg' => $th->getMessage()];
        }
    }

    private $routeMap = [
        'profile' => '/users/profile',
        'checkpin' => '/users/checkpin',
        'changepin' => '/users/changepin',
    ];

    public function getByApiVersion($route, $formData = [])
    {
        $route = $this->routeMap[$route] ?? '';
      
        $response = $this
            ->setBody($formData)
            ->execute('POST', "/apps/$this->apiVersion/$route");

        return $response;
    }

    // ========================== V8 =============================== //

    // ========================== AUTH =============================== //

    public function auth($phoneNumber)
    {
        $this->noHp = md5($phoneNumber);
        
        $options['headers'] = [
            'irsauth' => $this->generateIRSAuth($this->noHp), // V8
            'x-auth-irs' => $this->generateXIRSAuth($this->noHp), // V9
        ];

        $response = $this
            ->setBody([
                "phone" => $phoneNumber,
                'uuid' => $this->noHp,
            ])
            ->execute('POST', "/apps/v8/users/accountkit", $options);

        return $response;
    }

    // ========================== AKUN =============================== //

    public function getProfile()
    {
        return $this->execute('POST', "/apps/v8/users/profile");
    }

    public function cekPin($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/users/checkpin");
    }

    public function changePin($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/users/changepin");
    }

    public function register($data)
    {
        $this->noHp = md5($data['phone']);
        
        $data = array_merge(
            $data, [
                'uuid' => $this->noHp,
            ]
        );

        return $this->setBody($data)->execute('POST', "/apps/v8/users/register", [
            'headers' => [
                'irsauth' => $this->generateIRSAuth($this->noHp), // V8
                'x-auth-irs' => $this->generateXIRSAuth($this->noHp), // V9
            ]
        ]);
    }

    // ========================== END AKUN =============================== //

    // ========================== LOKASI =============================== //

    public function getProvinsi()
    {
        return $this->execute('POST', "/apps/v8/locations/provinces");
    }

    public function getCities($provinsiId)
    {
        return $this->setBody([
            'province_id' => $provinsiId
        ])->execute('POST', "/apps/v8/locations/cities");
    }

    public function getDistrict($citiesId)
    {
        return $this->setBody([
            'city_id' => $citiesId
        ])->execute('POST', "/apps/v8/locations/districts");
    }

    // ========================== END LOKASI =============================== //

    // ========================== PRODUCT =============================== //

    public function getGames()
    {
        return $this->execute('POST', "/apps/v8/products/games");
    }

    public function getByCategory($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/products/bycategory");
    }

    public function getPDAM()
    {
        return $this->execute('POST', "/apps/v8/products/pdam");
    }

    public function getFisik()
    {
        return $this->execute('POST', "/apps/v8/products/fisik");
    }

    public function getOperator($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/products/operators");
    }

    public function getOperatorTujuan($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/products/operators/bytujuan");
    }

    public function getPriceList()
    {
        return $this->execute('GET', "/apps/v8/products/pricelist/operators?uuid={$this->noHp}");
    }

    public function getByPrefix($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/products/byprefik");
    }

    public function getByDenom($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/products/bydenom");
    }

    // ========================== END PRODUCT =============================== //

    
    // ========================== TRANSAKSI =============================== //

    public function pay($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/transactions/pay");
    }

    public function reedem($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/transactions/redeem");
    }

    public function cetakStruk($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/transactions/cetakstruk");
    }

    // ========================== END TRANSAKSI =============================== //

    // ========================== HISTORI =============================== //

    public function deposit($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/deposit");
    }

    public function mutasi($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/mutasi");
    }

    public function transaksi($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/transaksi");
    }

    public function transaksifisik($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/transaksifisik");
    }

    public function rewards($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/rewards");
    }

    public function transfer($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/histories/transfer");
    }

    // ========================== END HISTORI =============================== //

    // ========================== TICKET =============================== //

    public function ticket_deposit($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/tickets/deposit");
    }

    public function ticket_transfer($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/tickets/transfer");
    }

    public function ticket_rekening($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v8/tickets/rekening");
    }

    // ========================== END TICKET =============================== //

    // ========================== END V8 =============================== //


    // ========================== V9 =============================== //
    
    // ========================== AKUN =============================== //
    public function changePinV9($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v9/gantipin");
    }
    // ========================== END AKUN =============================== //

    // ========================== HISTORI =============================== //
    public function rekapTrxV9($data)
    {
        $data['uuid'] = $this->noHp;
        return $this->execute('GET', "/apps/v9/rekaptrx?".http_build_query($data));
    }

    public function saldoV9($data)
    {
        $data['uuid'] = $this->noHp;
        return $this->execute('GET', "/apps/v9/historisaldo?".http_build_query($data));
    }

    public function transaksiV9($data)
    {
        $data['uuid'] = $this->noHp;
        return $this->execute('GET', "/apps/v9/historitrx?".http_build_query($data));
    }

    public function transferV9($data)
    {
        $data['uuid'] = $this->noHp;
        return $this->execute('GET', "/apps/v9/historitrf?".http_build_query($data));
    }

    public function topupV9($data)
    {
        $data['uuid'] = $this->noHp;
        return $this->execute('GET', "/apps/v9/historitopupdeposit?".http_build_query($data));
    }

    public function cetakV9($data)
    {
        return $this->setBody($data)->execute('POST', "/apps/v9/cetak");
    }

    // ========================== END HISTORI =============================== //
    // ========================== END V9 =============================== //

}
