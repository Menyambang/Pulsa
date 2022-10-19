<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class Ppob extends MyResourceDigipos
{
    public function getList()
    {
        $response = $this->digiposApi->ppobList();

        return $this->convertResponse($response);
    }

    public function getDetail($code = 'BPJS')
    {
        $response = $this->digiposApi->ppobDetail($code);

        return $this->convertResponse($response);
    }

    public function getPrice($shortCode = 'pdam_bukittinggi')
    {
        $response = $this->digiposApi->ppobPrice($shortCode);

        return $this->convertResponse($response);
    }

    public function preInquiry()
    {
        if ($this->validate([
            "billReferenceNumber" => "required",
            "initiatorName" => "required",
            "recieverName" => "required",
        ], $this->validationMessage)) {

            $response = $this->digiposApi->ppobPreInquiry([
                'billReferenceNumber' => $this->request->getPost('billReferenceNumber'),
                'initiatorName' => $this->request->getPost('initiatorName'),
                'recieverName' => $this->request->getPost('recieverName'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

    public function confirm()
    {
        if ($this->validate([
            "adminFee" => 'required',
            "channelSessionId" => "required",
            "confirmation" => 'required',
            "initiatorName" => "required",
            "pin" => "required",
        ], $this->validationMessage)) {

            $response = $this->digiposApi->ppobConfirm([
                'channelSessionId' => $this->request->getPost('channelSessionId'),
                'adminFee' => $this->request->getPost('adminFee'),
                'confirmation' => $this->request->getPost('confirmation'),
                'initiatorName' => $this->request->getPost('initiatorName'),
                'securityCredential' => $this->request->getPost('pin'),
            ]);

            return $this->convertResponse($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
