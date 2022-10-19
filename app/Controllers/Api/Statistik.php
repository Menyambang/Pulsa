<?php

namespace App\Controllers\Api;

use App\Models\KeranjangModel;
use App\Models\StatistikModel;
use App\Controllers\MyResourceController;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class UserSaldo
 * @note Resource untuk mengelola data t_user_saldo
 * @dataDescription t_user_saldo
 * @package App\Controllers
 */
class Statistik extends MyResourceController
{
    public function index()
    {
        $statistikModel = new StatistikModel();
        // $keranjangModel = new KeranjangModel();

        // $this->applyQueryFilter(true);
        // $keranjangModel->where(['krjUserEmail' => $this->user['email']]);
        // $keranjangModel->where(['cktStatus' => 'selesai']);
        // $keranjangModel->select('*');
        // $keranjangModel->with(['products', 'checkout']);

        // $limit = $this->request->getGet("limit") ? $this->request->getGet("limit") : $this->defaultLimitData;
        // $offset = $this->request->getGet("offset") ? $this->request->getGet("offset") : 0;
        // if ($limit != "-1") {
        //     $keranjangModel->limit($limit);
        // }
        // $keranjangModel->offset($offset);
        
        return $this->response([
            'bulanIni' => $statistikModel->getBulanIni($this->user['email']),
            'tahunIni' => $statistikModel->getTahunIni($this->user['email']),
            'pesananPerBulan' => $statistikModel->getPesananPerBulan($this->user['email']),
            'pesananTopProduk' => $statistikModel->getPesananTopProduk($this->user['email']),
            // 'pesananTopProduk' => [
            //     'rows' => $keranjangModel->find(),
            //     'limit' => $limit,
            //     'offset' => $offset,
            // ],
        ]);
    }
  
}
