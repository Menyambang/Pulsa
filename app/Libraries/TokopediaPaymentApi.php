<?php

namespace App\Libraries;

class TokopediaPaymentApi
{
    private static $instances = [];

    private $curl = null;

    /**
     * Expired 1 Bulan
     *
     * @param [type] $SID_TOKOPEDIA
     */
    public function __construct($SID_TOKOPEDIA)
    {
        $this->options = [];
        $options['http_errors'] = true;
        $options['baseURI'] = 'https://pay.tokopedia.com';
        $options['headers'] = [
            'Cookie' => '_SID_Tokopedia_='.$SID_TOKOPEDIA,
            'Host' => 'pay.tokopedia.com',
            'Cache-Control' => 'max-age=0',
            'Origin' => 'https://mitra.tokopedia.com',
            'Upgrade-Insecure-Requests' => '1',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'Mozilla/5.0 (Linux; Android 7.1.2; G011A Build/N2G48H) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.70 Mobile Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Referer' => 'https://mitra.tokopedia.com/digital/pulsa/1',
            // 'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-US,en;q=0.9',
        ];

        $this->curl = \Config\Services::curlrequest($options, null, null, false);
    }

    public static function getInstance($SID_TOKOPEDIA): TokopediaPaymentApi
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static($SID_TOKOPEDIA);
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
    private function setBody(string $body)
    {
        $this->body = $body;
        $this->curl->setBody($body)
            ->setHeader('Content-Length', strlen($body));
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
        $options['debug'] = WRITEPATH . '/logs/log_tokped.txt';
        $options['http_errors'] = false;

        if (!isset($options['timeout'])) {
            $options['timeout'] = 60;
            $options['connect_timeout'] = 60;
        }

        $response = $this->curl->request($method, $url, $options);
     
        $data = json_decode($response->getBody(), true);
        
        if(is_array($data) && isset(current($data)['data'])){
            return current($data)['data'];
        } if(is_array($data)){
            return $data;
        } else{
            return $response->getBody();
        }
    }

    // ========================== PAYMENT =============================== //

    public function paymentHtmlPage($body)
    {
        return $this
            ->setBody($body)
            ->execute('POST', '/v2/payment');
    }

    public function paymentGenerateCode($body)
    {
        return $this
            ->setBody($body)
            ->execute('POST', '/v3/payment/json');
    }

    public function paymentConfirmMitraVa($data)
    {
        $body = [
            "back_url" => "https://mitra.tokopedia.com/digital/pulsa/",
            "bank_code" => "",
            "bid" => "",
            "cfee" => 0,
            "gateway_code" => "MITRAVA",
            "history_state" => 0,
            "is_combine_va" => false,
            "is_mobile" => true,
            "is_quickpay" => false,
            "is_topup" => false,
            "is_use_cash_points" => 0,
            "is_use_ovo" => 0,
            "is_use_ovopoints" => 0,
            "is_use_pemuda" => 0,
            "is_use_pemudapoints" => 0,
            "is_use_phoenix" => 0,
            "is_use_points_only" => 0,
            "is_use_saldo" => 0,
            "is_use_saldopenghasilan" => 0,
            "kfee" => 0,
            "ksig" => "d2b8fda24f3c5004479392ae7e1546278361d5b77974d6df65c3540ffd270752",
            "merchant_code" => "tokopediapulsa",
            "merchant_id" => 3,
            "ovo_points_amount" => 0,
            "phoenix_conversion_rate" => "0:0",
            "profile_code" => "PULSA_MITRA_DEFAULT",
            "topup_amount" => 0,
            "topup_fee" => 0,
            "voucher_code" => ""
        ];
        $body = array_merge($body, $data);

        return $this
            ->setBody(http_build_query($body))
            ->execute('POST', '/v2/payment/confirm/MITRAVA');
    }

    // ======================= END  PAYMENT ============================= //

}
