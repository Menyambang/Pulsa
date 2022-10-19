<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class PaketData extends MyResourceDigipos
{
    public function getPaketData($mssidn, $paymentMethod)
    {
        $response = $this->digiposApi->getProduct($mssidn, $paymentMethod, 'paket_data');

        return $this->convertResponse($response);
    }

    public function recharge()
    {
        if ($this->validate([
            'msisdn' => 'required',
            'originTrxType' => 'required',
            'packageId' => 'required',
            'paymentMethod' => 'required',
            'price' => 'required',
            'trxType' => 'required',
        ], $this->validationMessage)) {
            
            $response = $this->digiposApi->recharge([
                'msisdn' => $this->request->getPost('msisdn'),
                'originTrxType' => $this->request->getPost('originTrxType'),
                'packageId' => $this->request->getPost('packageId'),
                'paymentMethod' => $this->request->getPost('paymentMethod'),
                'price' => $this->request->getPost('price'),
                'trxType' => $this->request->getPost('trxType'),
            ], 'paket_data');

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
            ], 'paket_data');

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
