<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class UserAlamat
 * @note Resource untuk mengelola data m_user_alamat
 * @dataDescription m_user_alamat
 * @package App\Controllers
 */
class UserAlamat extends MyResourceController
{
    protected $modelName = 'App\Models\UserAlamatModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'usrEmail' => ['label' => 'usrEmail', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota / Kabupaten', 'rules' => 'required'],
        'kotaTipe' => ['label' => 'Tipe Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
        'keterangan' => ['label' => 'Catatan ke kurir', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
        'usrEmail' => ['label' => 'usrEmail', 'rules' => 'required'],
        'nama' => ['label' => 'nama', 'rules' => 'required'],
        'latitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'longitude' => ['label' => 'Lokasi Sekarang', 'rules' => 'required'],
        'kotaId' => ['label' => 'Id Kota / Kabupaten', 'rules' => 'required'],
        'kotaNama' => ['label' => 'Kota / Kabupaten', 'rules' => 'required'],
        'kotaTipe' => ['label' => 'Tipe Kota', 'rules' => 'required'],
        'provinsiId' => ['label' => 'Id Provinsi', 'rules' => 'required'],
        'provinsiNama' => ['label' => 'Provinsi', 'rules' => 'required'],
        'kecamatanId' => ['label' => 'Id Kecamatan', 'rules' => 'required'],
        'kecamatanNama' => ['label' => 'Kecamatan', 'rules' => 'required'],
        'jalan' => ['label' => 'Jalan', 'rules' => 'required'],
        'keterangan' => ['label' => 'Catatan ke kurir', 'rules' => 'required'],
    ];

    protected $rulesPengaturan = [
        'isAlamatUtama' => ['label' => 'Alamat Utama', 'rules' => 'required'],
    ];

    public function index()
    {
        $this->model->where('usralUsrEmail', $this->user['email']);
        return parent::index();
    }

    public function update($id = null)
    {
        $post = $this->request->getVar();
        $post['usrEmail'] = $this->user['email'];
        $this->request->setGlobal("request", $post);

        return parent::update($id);
    }

    public function create()
    {
        $post = $this->request->getVar();
        $post['usrEmail'] = $this->user['email'];
        $this->request->setGlobal("request", $post);

        return parent::create();
    }

    public function setActive($alamatId)
    {
        $this->model->where('usralUsrEmail', $this->user['email']);
        $find = $this->model->find($alamatId);

        if (!empty($find)) {
            $this->model->where('usralUsrEmail', $this->user['email']);
            $this->model->update(null, ['usralIsActive' => 0]);
   
            $this->model->where('usralUsrEmail', $this->user['email']);
            $this->model->update($alamatId, ['usralIsActive' => 1]);
            return $this->response(null, 200, 'Berhasil mengubah jadi aktif');
        } else {
            return $this->response(null, 500, 'Alamat id tidak ditemukan');
        }
    }

    /**
     * Mengubah alamat menjadi alamat utama
     *
     * @param [type] $alamatId
     * @return void
     */
    public function pengaturanAlamat($alamatId)
    {
        if ($this->validate($this->rulesPengaturan, $this->validationMessage)) {
            try {
                $this->model->where('usralUsrEmail', $this->user['email']);
                $find = $this->model->find($alamatId);
        
                if (!empty($find)) {
                    $isActive = $this->request->getVar('isAlamatUtama');

                    if($isActive == 1) {
                        $this->model->where('usralUsrEmail', $this->user['email']);
                        $this->model->update(null, ['usralIsActive' => 0]);

                        $this->model->where('usralUsrEmail', $this->user['email']);
                        $this->model->update($alamatId, ['usralIsActive' => 1]);
                        return $this->response(null, 200, 'Berhasil mengubah jadi aktif');
                    }else{
                        return $this->response(null, 403, 'Tidak bisa menonaktifkan alamat');
                    }

                } else {
                    return $this->response(null, 500, 'Alamat id tidak ditemukan');
                }
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
      
    }

    public function delete($id = null)
    {
        if ($id == null)
            $this->applyQueryFilter();
     
        try {
            $this->model->where('usralUsrEmail', $this->user['email']);
            $cek = current($this->model->find($id));
          
            if ($cek) {
                if($cek->isActive == 1){
                    return $this->response(null, 500, 'Tidak dapat menghapus alamat yang sedang digunakan');
                }

                if ($id == null)
                   $this->applyQueryFilter();
         
                $status = $this->model->delete($id);
                $status = $status ? 200 : 500;
                $message = '';
            } else {
                $status = 400;
                $message = 'Data tidak tersedia';
            }
            return $this->response(null, $status, $message);
        } catch (DatabaseException $ex) {
            return $this->response(null, 500, $ex->getMessage());
        } catch (\mysqli_sql_exception $ex) {
            if ($ex->getCode() === 1451) {
                return $this->response(null, 500, "Data tidak bisa dihapus karena direferensi oleh data lain");
            }
            return $this->response(null, 500, $ex->getMessage());
        } catch (\Exception $ex) {
            return $this->response(null, 500, $ex->getMessage());
        }
    }
}
