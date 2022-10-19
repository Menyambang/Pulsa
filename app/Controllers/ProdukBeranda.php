<?php namespace App\Controllers;

use App\Models\ProdukModel;
use CodeIgniter\Config\Config;
use App\Models\ProdukGambarModel;
use App\Models\ProdukBerandaModel;
use App\Models\ProdukBerandaTransModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class ProdukBeranda extends BaseController
{
    protected $modelName = 'App\Models\ProdukBerandaModel';
    protected $format    = 'json';

    protected $rules = [
       'banner' => ['label' => 'Banner', 'rules' => 'max_size[banner,1024]|ext_in[banner,jpeg,jpg,png]|mime_in[banner, image/jpg,image/jpeg,image/png]'],
       'judul' => ['label' => 'Judul', 'rules' => 'required'],
       'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required'],
   ];


   public function index()
    {
        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/index");
    }

    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['produk']);

        return parent::grid();
    }

    public function test(){
        $data = $this->model->getDetailProdukBeranda(1);
        return $this->response->setJSON($data);
    }

    public function tambah()
    {
        $data = [
       ];
      
        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/tambah", $data);
    }

    public function cari(){
        $cari = $this->request->getPost('cari');

        $produkModel = new ProdukModel();
        $produkModel->select('*');
        $produkModel->with(['gambar']);
        $data = $produkModel->like(['produkNama' => $cari])->find();
        return $this->response->setJSON($data);
    }

    public function ubah($produkId)
    {
        $this->model->select('*');
        $this->model->with(['produk', 'kategori', 'products']);

        $data = [
           'data' => $this->model->find($produkId),
           'id' => $produkId,
       ];

        return $this->template->setActiveUrl('ProdukBeranda')
           ->view("ProdukBeranda/tambah", $data);
    }

    protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "banner_gambar";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("banner");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['banner'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {

        // echo '<pre>';
        // print_r($this->request->getPost());
        // echo '</pre>';exit;
        $file = $this->request->getFile("banner");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['banner'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->banner != '') {
                unset($this->rules['banner']);
            }
        }

        if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
				if(!$this->isUploadWithId){
					try {
						$this->uploadFile(null);
					} catch (\Exception $ex) {
						$response =  $this->response(null, 500, $ex->getMessage());
						return $this->response->setJSON($response);
					}
				}

				try {
					$primaryId = $this->request->getVar($primary);
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

                    if($status){
                        $produkBerandaTrans = new ProdukBerandaTransModel();
                        $dataDb = $produkBerandaTrans->where('tpbPbId', $primaryId)->asObject()->find();
                        $dataDb = array_column($dataDb, 'tpbProdukId');
                        $dataProduk = $this->request->getPost('produkId');
                        $dataProduk = explode(',', $dataProduk);
                        $willInsert = array_diff($dataProduk, $dataDb);
                        $willDelete = array_diff($dataDb, $dataProduk);
                     
                        if(!empty($willDelete)){
                            $produkBerandaTrans->where(['tpbPbId' => $primaryId]);
                            $produkBerandaTrans->whereIn('tpbProdukId', $willDelete);
                            $produkBerandaTrans->delete();
                        }

                        $insertData = [];
                        foreach ($willInsert as  $value) {
                            $insertData[] = [
                                'tpbProdukId' => $value,
                                'tpbPbId' => $primaryId,
                            ];
                        }

                        if(!empty($insertData)){
                            $produkBerandaTrans->insertBatch($insertData);
                        }
                    
                        if($this->isUploadWithId){
                            try {
                                $this->uploadFile($primaryId);
                            } catch (\Exception $ex) {
                                $response =  $this->response(null, 500, $ex->getMessage());
                                return $this->response->setJSON($response);
                            }
                        }
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
}
