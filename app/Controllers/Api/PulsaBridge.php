<?php

namespace App\Controllers\Api;

use App\Libraries\PulsaBridgeApi;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class UserSaldo
 * @note Resource untuk mengelola data t_user_saldo
 * @dataDescription t_user_saldo
 * @package App\Controllers
 */
class PulsaBridge extends ResourceController
{
    public function index()
    {
        $url = $this->request->getVar();

        $pulsaBridge = new PulsaBridgeApi();
        $res = $pulsaBridge->get($url);

        return $this->response->setJSON($res);
    }

    public function xml()
    {
        $url = $this->request->getVar();

        $pulsaBridge = new PulsaBridgeApi();
        $res = $pulsaBridge->post($url);

        return $this->response->setJSON($res);
    }
}
