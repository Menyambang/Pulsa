<?php namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class GlobalApi extends MyResourceController
{
    public function get($route)
    {
        $response = $this->irs->getByApiVersion($route, $this->request->getGet());

        return $this->response($response, 200);
    }

    public function post($route)
    {
        $response = $this->irs->getByApiVersion($route, $this->request->getPost());

        return $this->response($response, 200);
    }

}
