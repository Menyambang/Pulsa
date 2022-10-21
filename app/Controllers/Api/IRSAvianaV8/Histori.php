<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Histori extends MyResourceController
{
    public function deposit()
    {
        $response = $this->irs->deposit($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function mutasi()
    {
        $response = $this->irs->mutasi($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transaksi()
    {
        $response = $this->irs->transaksi($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transaksifisik()
    {
        $response = $this->irs->transaksifisik($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function rewards()
    {
        $response = $this->irs->rewards($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transfer()
    {
        $response = $this->irs->transfer($this->request->getVar());

        return $this->convertResponse($response, 200);
    }
}
