<?php

namespace App\Controllers;

use App\Controllers\Api\KategoriMenu;
use App\Models\MenuModel;
use App\Models\JenisMenuModel;
use App\Models\KategoriMenuModel;
use CodeIgniter\Config\Config;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class Kategori extends BaseController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    protected $rules = [
        'show' => ['label' => 'Show Home', 'rules' => 'required'],
        'title' => ['title' => 'Title', 'rules' => 'required'],
        'menu' => ['label' => 'Menu', 'rules' => 'required'],
    ];

    public function index()
    {
        $menu = new MenuModel();
        $selectMenu = $menu->selectMenu();
        return $this->template->setActiveUrl('Kategori')
            ->view("Kategori/index", [
                'selectMenu' => $selectMenu
            ]);
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['menu', 'kategori']);

        return parent::grid();
    }

    public function afterSimpan($primaryId){
        try {
            $dataMenu = [];
            $kategoriMenuModel = new KategoriMenuModel();
            $kategoriMenuModel->where(['ktmKtgId' => $primaryId])->delete();
            foreach ($this->request->getVar('menu') as $menuId) {
                $dataMenu[] = [
                    'ktmKtgId' => $primaryId,
                    'ktmMenuId' => $menuId,
                ];
            }

            $kategoriMenuModel->insertBatch($dataMenu);

        } catch (\Exception $ex) {
            $response =  $this->response(null, 500, $ex->getMessage());
            return $this->response->setJSON($response);
        }
    }

    public function beforeSimpan($primaryId)
    {
        $post = $this->request->getVar();
        if(empty($primaryId)){
    		$this->model->filterUsr($this->username);
            $post['urutan'] = count($this->model->find()) + 1;
            $this->request->setGlobal("request", $post);
        }   
    }

    public function simpan($primary = '')
	{
        return parent::simpan($primary);
	}

    public function findAll()
    {
        $this->model->select('*');
        $this->model->with(['menu']);
        $this->model->orderBy('ktgUrutan', 'ASC');
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
                    'ktgId' => $value['id'],
                    'ktgUrutan' => $urutanNumber,
                ];
            }
        }

        if (!empty($sortedData)) {
            $this->model->updateBatch($sortedData, 'ktgId');
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diurutkan'
        ]);
    }
}
