<?php

namespace App\Controllers\Api\Tokopedia;

use App\Controllers\Api\Tokopedia\MyResourceTokopedia;

class Payment extends MyResourceTokopedia
{
    public function beliPulsa()
    {
        if ($this->validate([
            'msisdn' => 'required|numeric',
            'produkId' => 'required',
        ], $this->validationMessage)) {
            $msisdn = $this->request->getPost('msisdn');
            $produkId = $this->request->getPost('produkId');

            $response = $this->tokpedApi->beliPulsa($msisdn, $produkId);

            if (isset($response['express_checkout']['status']) && $response['express_checkout']['status']) {
                $queryString = $response['express_checkout']['data']['attributes']['query_string'];
                $response = $this->tokpedPaymentApi->paymentHtmlPage($queryString);
                
                $start = strpos($response, 'window.REQUEST_DATA');
                $end = strpos($response, 'gateway_option: ""');
                $htmlVar = str_replace('window.REQUEST_DATA = ', '', substr($response, $start, $end - $start + 28));

                // FIX DATA FORMAT
                foreach ([
                    'merchant_code', 'profile_code', 'transaction_id', 'transaction_date', 'gateway_code', 'pid', 'bid', 'nid', 'item_name', 'item_quantity', 'item_price', 'currency', 'amount', 'customer_name', 'customer_email', 'customer_msisdn', 'user_defined_value', 'payment_metadata', 'language', 'back_url', 'signature', 'instant_saldo', 'disallow_ovopoints', 'new_cc_iframe', 'method', 'gateway_option',
                ] as $value) {
                    $htmlVar = str_replace("$value:", '"' . $value . '":', $htmlVar);
                }

                $arrDataHtml = json_decode($htmlVar, true);
                $arrDataHtml['items'] = [
                    'name' => $arrDataHtml['item_name'],
                    'price' => $arrDataHtml['item_price'],
                    'quantity' => $arrDataHtml['item_quantity'],
                ];

                unset($arrDataHtml['item_name'], $arrDataHtml['item_price'], $arrDataHtml['item_quantity']);
                $buildQuery = http_build_query($arrDataHtml);
                $buildQuery = str_ireplace('%5B0', '', $buildQuery);
                $buildQuery = str_ireplace('%5D%5D', '%5D', $buildQuery);

                $response = $this->tokpedPaymentApi->paymentGenerateCode($buildQuery);

                // Geneate Data
                if ($response['success'] == 1) {
                    // Data Send 
                    $dataSend = [
                        "customer_name" => $response['data']['userInfo']['userName'],
                        "gateways" => $response['data']['paymentInfo']['gatewayStr'],
                        "payment_amount" => $response['data']['amount'],
                        "signature" => $response['data']['signatureInfo']['basic'],
                        "transaction_id" => $response['data']['paymentInfo']['transactionId'],
                        "user_id" => $response['data']['userInfo']['userId'],
                    ];

                    $response = $this->tokpedPaymentApi->paymentConfirmMitraVa($dataSend);

                    return $this->response($response);
                } else {
                    return $this->response($response, 400, 'Pembayaran Mitra VA Gagal');
                }
                
                return $this->response($response);
            } else {
                return $this->response($response, 400, 'Gagal membeli pulsa');
            }

            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
