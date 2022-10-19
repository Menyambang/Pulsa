<?php namespace App\Controllers;

use App\Models\KeranjangModel;
use CodeIgniter\Config\Config;
use App\Libraries\RajaOngkirShipping;
use App\Controllers\MyResourceController;
use App\Entities\UserWeb as EntitiesUserWeb;
use App\Models\UserAlamatModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class User extends BaseController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    private $rajaOngkir;
    private $originId = '35'; // Kalimantan Selatan
    public $kurirSupport = ['jne', 'jnt'];
    
    protected $rules = [
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'required|numeric'],
        'noWa' => ['label' => 'No Whatsapp', 'rules' => 'required|numeric'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'alamatNama' => ['label' => 'Nama Alamat', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
    ];

    function __construct()
    {
        $this->rajaOngkir = new RajaOngkirShipping();
    }
    
    public function index()
    {
        $data = [
            'provinsi' => $this->_selectProvinsi(),
        ];

        return $this->template->setActiveUrl('User')
            ->view("User/index", $data);
    }

    public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {

            if ($this->acl->isUpdate()) return $this->response->setJSON($this->acl->isUpdate());

			helper('form');
			if ($this->validate($this->rules)) {
				
				try {
					$primaryId = $this->request->getVar($primary);
					$entityClass = $this->model->getReturnType();
					$entity = new $entityClass();
					$entity->fill($this->request->getVar());

					$this->model->transStart();
                    $this->model->set($entity->toRawArray())
                        ->update($primaryId);

					$this->model->transComplete();
					$status = $this->model->transStatus();

                    $userAlamat = new UserAlamatModel();
                    $userAlamat->where('usralUsrEmail', $this->request->getVar($primary));
                    $userAlamat->where('usralIsFirst', 1);
                    $userAlamat->update(null, [
                        'usralProvinsiId' => $this->request->getVar('provinsiId'),
                        'usralKotaId' => $this->request->getVar('kotaId'),
                        'usralKecamatanId' => $this->request->getVar('kecamatanId'),
                        'usralNama' => $this->request->getVar('alamatNama'),
                        'usralJalan' => $this->request->getVar('jalan'),
                    ]);

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

    public function grid()
    {
        $this->model->select('*');
        $this->model->where('usralIsFirst', 1)->with(['alamat']);

        return parent::grid();
    }

    public function keranjangDetail($email){
        $keranjangModel = new KeranjangModel();
        
        $response =  $this->response($keranjangModel->getKeranjangDetail(null, $email), 200);
        return $this->response->setJSON($response);
    }

    // ============================================ //
    private function _selectProvinsi(){
        $data = $this->rajaOngkir->province();

        $provinsi = [];
        foreach($data['data'] as $row){
            $provinsi[$row['province_id']] = $row['province'];
        }

        return $provinsi;
    }

    public function selectKota($id){
        $data = $this->rajaOngkir->city(null, $id);

        return $this->response->setJSON($data['data']);
    }

    public function selectKecamatan($cityId){
        $data = $this->rajaOngkir->subdistrict($cityId);
     
        return $this->response->setJSON($data['data']);
    }
}
