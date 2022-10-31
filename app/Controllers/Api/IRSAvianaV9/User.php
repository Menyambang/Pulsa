<?php namespace App\Controllers\Api\IRSAvianaV9;

use App\Controllers\MyResourceController;

class User extends MyResourceController
{
    public function changePin()
    {
        $response = $this->irs->changePinV9($this->request->getVar());

        return $this->convertResponse($response, 200);
    }

}
