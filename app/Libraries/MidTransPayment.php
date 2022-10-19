<?php

namespace App\Libraries;

use CodeIgniter\Config\Config;
use Config\App;

class MidTransPayment
{
    private static $instances = [];

    private $curl = null;

    private $clientKey = 'SB-Mid-client-c9oS0MIEod22eWh7';
    private $serverKey = 'SB-Mid-server-cTEXN7XJavbaIeg11JuUZiyy';
    private $idMerchant = 'G005407818';
    private $baseUri = 'https://api.sandbox.midtrans.com';
    
    private $formData = [];
    private $appConfig;

    const PAYMENT_TYPE_ECHANNEL = 'echannel';
    const PAYMENT_TYPE_BANK_TRANSFER = 'bank_transfer';
    const PAYMENT_TYPE_CSTORE = 'cstore';

    const BANK_BNI = 'bni';
    const BANK_BCA = 'bca';
    const BANK_PERMATA = 'permata';

    public function __construct()
    {
        $this->appConfig = new \Config\App();
        $this->baseUri = $this->appConfig->midTransBaseUri;
        $this->serverKey = $this->appConfig->midTransServerKey;
        $this->clientKey = $this->appConfig->midTransClientKey;
        $this->idMerchant = $this->appConfig->midTransIdMerchant;

        $this->options = [];
        $options['baseURI'] = $this->baseUri;
        $options['headers']['Authorization'] = "Basic " . base64_encode($this->serverKey);
        $options['headers']['Accept'] = "application/json";

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
     * @return MidTransPayment
     */

    public static function getInstance(): MidTransPayment
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
    public function transactionStatus($orderId)
    {
        $response = $this->execute('GET', $orderId . '/status');

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param [payment] $paymentType
     * @param array $customerDetail 
        array(
            'email' => 'noreply@example.com',
            'first_name' => 'Ahmad Juhdi',
            'last_name' => 'utomo',
            'phone' => '+6281 1234 1234',
        )
     * @param array $itemDetails
        array(
            0 => array(
                'id' => 'item01',
                'price' => 1,
                'quantity' => 1,
                'name' => 'Ayam Zozozo',
            )
        ),
     * @param string $bankTransfer
     * @param string $grossAmount
     * @param string $type
     * @return void
     */
    public function charge($payment, array $customerDetail, array $itemDetails, $bankTransfer = 'bni', $grossAmount, $type = 'TOPUP')
    {
        $paymentType = $payment->tipe;

        $formData = array(
            'payment_type' => $paymentType,
            'transaction_details' => array(
                'gross_amount' => $grossAmount,
                'order_id' => $type.'-' . strtotime("now"),
            ),
            'customer_details' => $customerDetail,
            'item_details' => $itemDetails
        );

        $metodePembayaran = [];

        if ($paymentType == self::PAYMENT_TYPE_BANK_TRANSFER) {
            $metodePembayaran = [
                "bank_transfer" => [
                    "bank" => $bankTransfer,
                    "va_number" => $payment->vaNumber,
                ],
            ];
        }else if($paymentType == self::PAYMENT_TYPE_ECHANNEL){
            $metodePembayaran = [
                "echannel" => [
                    "bill_info1" => "Payment For",
                    "bill_info2" => "TopUp"
                ]
            ];
        // INDOMARET / ALFAMART
        }else if($paymentType == self::PAYMENT_TYPE_CSTORE){
            $metodePembayaran = [
                "cstore" => [
                    "store" => strtolower($payment->nama),
                ]
            ];
        }

        $formData = array_merge($formData, $metodePembayaran);
        $response = $this->setFormData($formData)->execute('POST', 'charge');

        return $response;
    }

    /**
     * Undocumented function
     *
     * @param [type] $paymentType
     * @param array $customerDetail 
        array(
            'email' => 'noreply@example.com',
            'first_name' => 'Ahmad Juhdi',
            'last_name' => 'utomo',
            'phone' => '+6281 1234 1234',
        )
     * @param array $itemDetails
        array(
            0 => array(
                'id' => 'item01',
                'price' => 1,
                'quantity' => 1,
                'name' => 'Ayam Zozozo',
            )
        ),
     * @param string $bankTransfer
     * @param string $grossAmount
     * @return void
     */
    public function snapCharge(array $customerDetail, array $itemDetails, $grossAmount)
    {
        $this->baseUri = "{$this->baseUri}/snap/v1/";

        $formData = array(
            'transaction_details' => array(
                'gross_amount' => $grossAmount,
                'order_id' => 'TOPUP-' . strtotime("now"),
            ),
            "credit_card"=> [
                "secure"=> true
            ],
            'customer_details' => $customerDetail,
            'item_details' => $itemDetails
        );

        $formData = array_merge($formData);
        $response = $this->setFormData($formData)->execute('POST', 'transactions');

        return $response;
    }

    /**
     * Charge Bank BNI VA
     *
     * @return void
     */
    public function chargeGopay()
    {
        $response = $this->setFormData(array(
            'payment_type' => 'gopay',
            'transaction_details' => array(
                'gross_amount' => 2,
                'order_id' => 'order-101h-' . strtotime("now"),
            ),
            'gopay' => array(
                'enable_callback' => true,
                'callback_url' => 'someapps://callback',
            ),
            'customer_details' => array(
                'email' => 'noreply@example.com',
                'first_name' => 'Ahmad',
                'last_name' => 'Juhdi',
                'phone' => '+6281251554104',
            ),
            'item_details' => array(
                0 => array(
                    'id' => 'item01',
                    'price' => 1,
                    'quantity' => 1,
                    'name' => 'Ayam Zozozo',
                ),
                1 => array(
                    'id' => 'item02',
                    'price' => 1,
                    'quantity' => 1,
                    'name' => 'Ayam Xoxoxo',
                ),
            ),
        ))->execute('POST', 'charge');

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
     * @return $this
     */
    private function setFormData(array $params)
    {
        $this->formData = $params;
        $this->curl->setJSON($params);
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
        $options['debug'] = WRITEPATH . '/logs/log_curl_mid_trans.txt';
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
