<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class Notifikasi
 * @note Resource untuk mengelola data m_notifikasi
 * @dataDescription m_notifikasi
 * @package App\Controllers
 */
class NotifikasiTo extends MyResourceController
{
    protected $modelName = 'App\Models\NotifikasiToModel';
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

   public function markRead($notifToId){
        $dataFind = $this->model->find($notifToId);
        $dataFind->isRead = 1;

        $this->model->save($dataFind);

        return $this->response(null, 200, 'Berhasil Ditandai sebagai dibaca');

   }

}
