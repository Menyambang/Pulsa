<?php

namespace App\Controllers;

use App\Models\JadwalUmumModel;
use App\Models\JadwalKhususModel;
use App\Models\AntrianOnlineModel;
use App\Controllers\BaseController;

class Cetak extends BaseController
{

    public function __construct()
    {
        helper('datetime');
    }

    public function index()
    {
        $img = base_url('assets/images/menyambang/logo-lapas_ya.png');
        $imgData = base64_encode(file_get_contents($img));

        $data['logo'] = 'data:image/png;base64,' . $imgData;
        return view("Layouts/cetak", $data);
    }

    /**
     * getData
     *
     * mengambil data antrian sekarang
     *
     * @return void
     */
    public function getData($id = '', $returnJson = true)
    {
        $this->model->select('*');
        $this->model->with(['napi', 'pengunjung']);
        // $this->model->where(['antTanggal' => date('Y-m-d')]);
        $data = $this->model->find($id);
        if ($data) {
            $data = $data->toArray();

        }

        if ($id && $data) {
            $response = [
                'code' => 200,
                'data' => $data,
                'message' => 'success',
            ];
        } else {
            $response = [
                'code' => 400,
                'data' => [],
                'message' => 'error',
            ];
        }
        if ($returnJson) {
            return $this->response->setJSON($response);
        } else {
            return $response;
        }
    }

    /**
     * cetakData
     *
     * Mencetak Data
     *
     * @return void
     */
    public function cetakData($id)
    {
        return view("Layouts/cetak_antrian", []);
    }
}
