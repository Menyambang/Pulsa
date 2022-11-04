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

    public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {
			helper('form');
			if ($this->validate($this->rules)) {

                $post = $this->request->getVar();
              
				try {
					$primaryId = $this->request->getVar($primary);

                    $post = $this->request->getVar();
                    if(empty($primaryId)){
                        $post['urutan'] = count($this->model->find()) + 1;
                        $this->request->setGlobal("request", $post);
                    }
                    
					$entityClass = $this->model->getReturnType();
					$entity = new $entityClass();
					$entity->fill($this->request->getVar());

					$this->model->transStart();
					if ($primaryId == '') {
						$this->model->insert($entity, false);
						if ($this->model->getInsertID() > 0) {
							$primaryId = $this->model->getInsertID();
							$entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
						}
					} else {
						$this->model->set($entity->toRawArray())
							->update($primaryId);
					}

					$this->model->transComplete();
					$status = $this->model->transStatus();

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

					$response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
					return $this->response->setJSON($response);
				} catch (DatabaseException $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\mysqli_sql_exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\Exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				}
			} else {
				$response =  $this->response(null, 400, $this->validator->getErrors());
				return $this->response->setJSON($response);
			}
		}
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
