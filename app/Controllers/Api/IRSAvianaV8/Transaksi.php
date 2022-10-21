<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Transaksi extends MyResourceController
{
    public function pay()
    {
        $response = $this->irs->pay($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function reedem()
    {
        $response = $this->irs->reedem($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function cetakStruk()
    {
        $response = $this->irs->cetakStruk($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

}
