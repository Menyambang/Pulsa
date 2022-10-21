<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Product extends MyResourceController
{
    public function getGames()
    {
        $response = $this->irs->getGames();

        return $this->convertResponse($response);
    }

    public function getByCategory()
    {
        $response = $this->irs->getByCategory($this->request->getVar());

        return $this->convertResponse($response);
    }

    public function getPDAM()
    {
        $response = $this->irs->getPDAM();

        return $this->convertResponse($response);
    }

    public function getFisik()
    {
        $response = $this->irs->getFisik();

        return $this->convertResponse($response);
    }
    
    public function getOperator()
    {
        $response = $this->irs->getOperator($this->request->getVar());

        return $this->convertResponse($response);
    }

    public function getOperatorTujuan()
    {
        $response = $this->irs->getOperatorTujuan($this->request->getVar());

        return $this->convertResponse($response);
    }

    public function getPriceList()
    {
        $response = $this->irs->getPriceList();

        return $this->response($response, 200);
    }

    public function getByDenom()
    {
        $response = $this->irs->getByDenom($this->request->getVar());

        return $this->convertResponse($response);
    }

}
