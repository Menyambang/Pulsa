<?php namespace App\Controllers\Api\Tokopedia;

use App\Controllers\Api\Tokopedia\MyResourceTokopedia;

class Transaksi extends MyResourceTokopedia
{
    public function getTransactionList()
    {
        $response = $this->tokpedApi->getTransactionList();

        return $this->response($response);
    }

    public function getTransactionWaitingList()
    {
        $response = $this->tokpedApi->getTransactionWaitingList();

        return $this->response($response);
    }

}
