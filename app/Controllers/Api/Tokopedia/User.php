<?php namespace App\Controllers\Api\Tokopedia;

use App\Controllers\Api\Tokopedia\MyResourceTokopedia;

class User extends MyResourceTokopedia
{
    public function isAuth()
    {
        $response = $this->tokpedApi->isAuth();

        return $this->response($response);
    }

    public function cekVaNumber()
    {
        $response = $this->tokpedApi->checkVaNumberMitraBRI();

        return $this->response($response);
    }

    public function cekSaldoMitra()
    {
        $response = $this->tokpedApi->checkSaldoMitraBRI();

        return $this->response($response);
    }

    public function cekAkun()
    {
        $response = $this->tokpedApi->checkAkun();

        return $this->response($response);
    }

}
