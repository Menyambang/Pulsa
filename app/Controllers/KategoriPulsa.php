<?php

namespace App\Controllers;

use App\Models\Pulsa\MenuDigitalModel;
use CodeIgniter\Config\Config;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class KategoriPulsa extends BaseController
{
    protected $modelName = 'App\Models\Pulsa\KategoriPulsaModel';
    protected $format    = 'json';

    protected $rules = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        // 'prefix' => ['label' => 'Kelompok', 'rules' => 'required'],
        'icon' => ['label' => 'Icon', 'rules' => 'required|uploaded[icon]|max_size[icon,1024]|ext_in[icon,jpeg,jpg,png]|mime_in[icon, image/jpg,image/jpeg,image/png]'],
    ];

    public function index()
    {
        $menuModel = new MenuDigitalModel();
        $selectMenu = $menuModel->selectMenu();
        return $this->template->setActiveUrl('KategoriPulsa')
            ->view("KategoriPulsa/index", [
                'selectMenu' => $selectMenu
            ]);
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['menu']);

        return parent::grid();
    }

    protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . PATH_ICON_KATEGORI_PULSA;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("icon");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['icon'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("icon");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['icon'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->icon != '') {
                unset($this->rules['icon']);
            }
        }

        $post = $this->request->getVar();
        if(empty($primary)){
            $post['urutan'] = count($this->model->find()) + 1;
            $this->request->setGlobal("request", $post);
        }

        return parent::simpan($primary);
    }

    public function findAll()
    {
        $this->model->orderBy('kpUrutan', 'ASC');
        return parent::findAll();
    }

    public function simpanUrutan()
    {
        $post = $this->request->getVar('data');
        $sortedData = [];
        foreach ($post as $key => $value) {
            $urutanNumber = ($key + 1);
            if ($value['urutan'] != $urutanNumber) {
                $sortedData[] = [
                    'kpId' => $value['id'],
                    'kpUrutan' => $urutanNumber,
                ];
            }
        }

        if (!empty($sortedData)) {
            $this->model->updateBatch($sortedData, 'kpId');
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diurutkan'
        ]);
    }
}
