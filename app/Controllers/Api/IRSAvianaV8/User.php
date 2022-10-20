<?php namespace App\Controllers\Api\Digipos;

use App\Controllers\Api\Digipos\MyResourceDigipos;

class User extends MyResourceDigipos
{
    public function getKategori()
    {
        $response = $this->digiposApi->getKategori();

        return $this->convertResponse($response);
    }

    public function getProfile()
    {
        $response = $this->digiposApi->getProfile();

        return $this->convertResponse($response);
    }

    public function cekSaldo($type = 'linkaja')
    {
        $response = $this->digiposApi->cekSaldo($type);

        return $this->convertResponse($response);
    }

}
