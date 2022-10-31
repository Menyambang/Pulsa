<?php namespace App\Controllers\Api\IRSAvianaV9;

use App\Controllers\MyResourceController;

class Histori extends MyResourceController
{
    public function rekapTrx()
    {
        $response = $this->irs->rekapTrxV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function saldo()
    {
        $response = $this->irs->saldoV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transaksi()
    {
        $response = $this->irs->transaksiV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transfer()
    {
        $response = $this->irs->transferV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function topup()
    {
        $response = $this->irs->topupV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function cetak()
    {
        $response = $this->irs->cetakV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

}
