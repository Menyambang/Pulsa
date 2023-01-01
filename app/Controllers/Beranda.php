<?php

namespace App\Controllers;

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
        $userModel = new UserModel();
        $userModel->select('*');
        $userModel->where('usrId', $this->username);
        $userModel->with(['alamat']);
        $userData = $userModel->where('usralIsFirst', 1)->find();
        
        $data = [
            'pengguna' => $userData,
            'card' => [
                'totalAgen' => count($userData),
                'agenAktifToday' => 0,
                'tokenSms' => 0,
                'saldoIrsMarket' => 0,
            ],
        ];

        return $this->response->setJSON($data);
    }
}
