<?php

namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class Notifikasi
 * @note Resource untuk mengelola data m_notifikasi
 * @dataDescription m_notifikasi
 * @package App\Controllers
 */
class Notifikasi extends MyResourceController
{
    protected $modelName = 'App\Models\NotifikasiModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'judul' => ['label' => 'judul', 'rules' => 'required'],
        'pesan' => ['label' => 'pesan', 'rules' => 'required'],
        'tanggal' => ['label' => 'tanggal', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'judul' => ['label' => 'judul', 'rules' => 'required'],
        'pesan' => ['label' => 'pesan', 'rules' => 'required'],
        'tanggal' => ['label' => 'tanggal', 'rules' => 'required'],
    ];

    public function index()
    {
        $post = $this->request->getVar();
        $post['penerima_email']['eq'] = $this->user['email'];
        $this->request->setGlobal("get", $post);

        return parent::index();
    }

    public function getNotif()
    {
        $userEmail = $this->user['email'];

        $data = $this->model->query("SELECT * FROM (

            SELECT * FROM `m_notifikasi` ntf        
            LEFT JOIN `t_notifikasi_to` ntft ON (ntf.`notifId` = ntft.`tnotifNotifId`)        
            WHERE ntft.`tnotifEmail` IS NULL              
            
            UNION                 
            
            SELECT * FROM `m_notifikasi` ntf        
            LEFT JOIN `t_notifikasi_to` ntft ON (ntf.`notifId` = ntft.`tnotifNotifId`) 
            WHERE 
            ntft.`tnotifEmail` = " . $this->model->escape($userEmail) . ") datas
            
            ORDER BY datas.`notifTanggal` DESC
            LIMIT 10")->getResult();

        return $this->response($data, 200);
    }
}
