<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\BerandaModel;
use App\Controllers\BaseController;
use App\Models\UserModel;

class Beranda extends BaseController
{
    protected $activeUrl = 'Beranda';
   
    public function index()
    {

        return $this->template->setActiveUrl($this->activeUrl)
            ->view("Beranda/index");
    }

    public function dataBeranda()
    {
        $produkModel = new ProdukModel();
        $userModel = new UserModel();
        $userModel->select('*');
        $userModel->with(['alamat']);
        $userData = $userModel->where('usralIsFirst', 1)->find();
        
        $data = [
            'pengguna' => $userData,
            'card' => [
                'jlhPengguna' => count($userData),
                'jlhProduk' => $produkModel->countAllResults(),
                'jlhStokHabis' => $produkModel->where(['produkStok' => 0])->countAllResults(),
                'jlhStokSedikit' => $produkModel->where(['produkStok <' => 5])->countAllResults(),
            ],
        ];

        return $this->response->setJSON($data);
    }
}
