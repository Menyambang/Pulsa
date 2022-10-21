<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class User extends MyResourceController
{
    public function getProfile()
    {
        $response = $this->irs->getProfile();

        return $this->convertResponse($response, 200);
    }

    public function cekPin()
    {
        $response = $this->irs->cekPin($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

    public function changePin()
    {
        $response = $this->irs->changePin($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

}
