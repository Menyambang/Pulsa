<?php namespace App\Controllers\Api\Rita;

use App\Controllers\Api\Rita\MyResourceRita;

class Product extends MyResourceRita
{
    public function getProduct()
    {
        if ($this->validate([
            'categoryId' => 'required',
        ])) {
            $categoryId = $this->request->getPost('categoryId');
    
            $response = $this->ritaApi->getProduct($categoryId);
    
            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function rechargeProduct()
    {
        if ($this->validate([
            'msisdn' => 'required',
            'pin' => 'required',
            'productCode' => 'required',
            'productName' => 'required',
            'productPrice' => 'required',
            'trxMsisdn' => 'required',
        ])) {
            $msisdn = $this->request->getPost('msisdn');
            $pin = $this->request->getPost('pin');
            $productCode = $this->request->getPost('productCode');
            $productName = $this->request->getPost('productName');
            $productPrice = $this->request->getPost('productPrice');
            $trxMsisdn = $this->request->getPost('trxMsisdn');
    
            $response = $this->ritaApi->rechargeProduct($msisdn, $trxMsisdn, $pin, $productCode, $productPrice, $productName);
    
            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

}
