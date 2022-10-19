<?php

namespace App\Controllers;

use App\Models\SettingModel;
use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class LokasiCod extends BaseController
{
    protected $modelName = 'App\Models\LokasiCodModel';
    protected $format    = 'json';

    protected $rules = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'latitude' => ['label' => 'Latitude', 'rules' => 'required'],
        'longitude' => ['label' => 'Longitude', 'rules' => 'required'],
    ];

    protected $rulesSetting = [
        'biaya' => ['label' => 'Biaya', 'rules' => 'required|numeric'],
        'radius' => ['label' => 'Radius', 'rules' => 'required'],
    ];

    public function index()
    {
        $pengaturanModel = new SettingModel();
        $radius = $pengaturanModel->getValue(SettingModel::RADIUS_KEY);
        $biaya = $pengaturanModel->getValue(SettingModel::BIAYA_KEY);

        return $this->template->setActiveUrl('LokasiCod')
            ->view("LokasiCod/index", [
                'radius' => $radius,
                'biaya' => $biaya
            ]);
    }

    public function savePengaturan()
    {
        if ($this->request->isAJAX()) {

            if ($this->validate($this->rulesSetting)) {
                try {
                    $pengaturanModel = new SettingModel();
                    $pengaturanModel->saveKeyValue(SettingModel::RADIUS_KEY, $this->request->getPost('radius'));
                    $pengaturanModel->saveKeyValue(SettingModel::BIAYA_KEY, $this->request->getPost('biaya'));

                    return $this->response->setJSON([
                        'code' => 200,
                        'message' => 'Berhasil menyimpan pengaturan'
                    ]);
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
