<?php namespace App\Controllers\Api\Rita;

use App\Controllers\Api\Rita\MyResourceRita;

class Transaksi extends MyResourceRita
{
    public function getTransactionList()
    {
        $response = $this->ritaApi->getTransactionList();

        return $this->response($response);
    }
}
