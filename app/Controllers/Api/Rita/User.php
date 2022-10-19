<?php namespace App\Controllers\Api\Rita;

use App\Controllers\Api\Rita\MyResourceRita;

class User extends MyResourceRita
{
    public function getProfile()
    {
        $response = $this->ritaApi->getProfile();

        return $this->response($response);
    }

    public function getBalance()
    {
        $response = $this->ritaApi->getBalance();

        return $this->response($response);
    }

    public function getHome()
    {
        $response = $this->ritaApi->getHome();

        return $this->response($response);
    }

}
