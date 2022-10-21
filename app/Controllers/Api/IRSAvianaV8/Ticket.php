<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Ticket extends MyResourceController
{
    public function deposit()
    {
        $response = $this->irs->ticket_deposit($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function transfer()
    {
        $response = $this->irs->ticket_transfer($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function rekening()
    {
        $response = $this->irs->ticket_rekening($this->request->getVar());

        return $this->convertResponse($response, 200);
    }
}
