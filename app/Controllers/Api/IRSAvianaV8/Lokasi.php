<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Lokasi extends MyResourceController
{
    public function getProvinsi()
    {
        $response = $this->irs->getProvinsi();

        return $this->convertResponse($response, 200);
    }

    public function getCities($provinsiId)
    {
        $response = $this->irs->getCities($provinsiId);

        return $this->convertResponse($response, 200);
    }

    public function getDistrict($citiesID)
    {
        $response = $this->irs->getDistrict($citiesID);

        return $this->convertResponse($response, 200);
    }

}
