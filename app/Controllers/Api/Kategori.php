<?php

namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class Kategori extends MyResourceController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'title' => ['label' => 'title', 'rules' => 'required'],
        'show' => ['label' => 'show', 'rules' => 'required'],
        'urutan' => ['label' => 'urutan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'title' => ['label' => 'title', 'rules' => 'required'],
        'show' => ['label' => 'show', 'rules' => 'required'],
        'urutan' => ['label' => 'urutan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    public function index()
    {
        $data = parent::index();
        $data = json_decode($data->getBody(), true);

        foreach ($data['data']['rows'] as $kK => $vK) {
            sort($vK['menu']);
            $data['data']['rows'][$kK]['menu'] = $vK['menu'];
        }
        
        return $this->respond($data);
    }
}
