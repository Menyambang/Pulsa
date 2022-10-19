<?php

namespace App\Controllers\Api;

use App\Entities\User;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class FingerprintDevices
 * @note Resource untuk mengelola data m_fingerprint_devices
 * @dataDescription m_fingerprint_devices
 * @package App\Controllers
 */
class FingerprintDevices extends MyResourceController
{
    protected $modelName = 'App\Models\FingerprintDevicesModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'deviceId' => ['label' => 'deviceId', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'userEmail' => ['label' => 'userEmail', 'rules' => 'required'],
        'deviceId' => ['label' => 'deviceId', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    public function register()
    {
        $userEntity = new User();

        if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            $hashDevicesId = $userEntity->hashPassword($this->request->getVar('deviceId'));
            
            try {
                $find = $this->model->where(['fdDeviceId' => $hashDevicesId])->find();

                if (empty($find)) {
                    $entityClass = $this->model->getReturnType();
                    $entity = new $entityClass();
                    $entity->fill($this->request->getVar());
                    $entity->userEmail = $this->user['email'];
                    $entity->deviceId = $hashDevicesId;
                    
                    // Delete email yang terkoneksi dengan perangkat lain
                    $this->model->where(['fdUserEmail' => $this->user['email']])->delete();

                    $status = $this->model->insert($entity, false);
                    
                    if ($this->model->getInsertID() > 0) {
                        $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                    }
                    return $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 400), ($status ? 'Fingerprint berhasil diregistrasi' : 'Fingerprint gagal diregistrasi'));
                }else{
                    return $this->response(null, 400, 'Fingerprint sudah diregistrasi');
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

    public function unregister()
    {
        $userEntity = new User();

        // if ($this->validate($this->rulesCreate, $this->validationMessage)) {
            
            $hashDevicesId = $userEntity->hashPassword($this->request->getVar('deviceId'));
            
            try {
                // $find = $this->model->where(['fdDeviceId' => $hashDevicesId])->find();
                // $find = current($find);

                // if (!empty($find)) {
                    $this->model->where(['fdUserEmail' => $this->user['email']])->delete();

                    return $this->response(( null), (200), 'Fingerprint berhasil dihapus');
                // }else{
                //     return $this->response(null, 400, 'Fingerprint tidak tersedia');
                // }
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        // } else {
        //     return $this->response(null, 400, $this->validator->getErrors());
        // }
    }
}
