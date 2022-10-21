<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class User extends MyResourceController
{
    public function getProfile()
    {
        $response = $this->irs->getProfile();

        return $this->response($response, 200);
    }

}
