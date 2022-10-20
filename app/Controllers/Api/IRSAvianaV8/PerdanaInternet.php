<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class PerdanaInternet extends MyResourceDigipos
{
    public function getPerdanaInternet($mssidn, $paymentMethod)
    {
        $response = $this->digiposApi->getProduct($mssidn, $paymentMethod, 'perdana_internet');

        return $this->convertResponse($response);
    }

    public function check()
    {
        if ($this->validate([
            'product_id' => 'required',
            'user_id' => 'required',
        ], $this->validationMessage)) {

            $response = $this->digiposApi->check([
                'product_id' => $this->request->getPost('product_id'),
                'user_id' => $this->request->getPost('user_id'),
            ], 'perdana_internet');

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function recharge()
    {
        if ($this->validate([
            "msisdn" => "required",
            "packageId" => "required",
            "paymentMethod" => "required",
            "price" => 'required',
            "trxType" => "required",
            "vasUserId" => "required",
            "vasUserName" => "required"
        ], $this->validationMessage)) {

            $response = $this->digiposApi->recharge([
                'msisdn' => $this->request->getPost('msisdn'),
                'packageId' => $this->request->getPost('packageId'),
                'paymentMethod' => $this->request->getPost('paymentMethod'),
                'price' => $this->request->getPost('price'),
                'trxType' => $this->request->getPost('trxType'),
                'vasUserId' => $this->request->getPost('vasUserId'),
                'vasUserName' => $this->request->getPost('vasUserName'),
            ], 'perdana_internet');

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function confirm()
    {
        if ($this->validate([
            'pin' => 'required',
            'token' => 'required',
        ], $this->validationMessage)) {

            $response = $this->digiposApi->confirm([
                'pin' => $this->request->getPost('pin'),
                'token' => $this->request->getPost('token'),
            ], 'perdana_internet');

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
