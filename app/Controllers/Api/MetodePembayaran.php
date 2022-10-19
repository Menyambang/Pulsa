<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class MetodePembayaran
 * @note Resource untuk mengelola data m_metode_pembayaran
 * @dataDescription m_metode_pembayaran
 * @package App\Controllers
 */
class MetodePembayaran extends MyResourceController
{
    protected $modelName = 'App\Models\MetodePembayaranModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'tipe' => ['label' => 'tipe', 'rules' => 'required'],
       'gambar' => ['label' => 'gambar', 'rules' => 'required'],
       'vaNumber' => ['label' => 'vaNumber', 'rules' => 'required'],
       'bank' => ['label' => 'bank', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'id' => ['label' => 'id', 'rules' => 'required'],
       'nama' => ['label' => 'nama', 'rules' => 'required'],
       'deskripsi' => ['label' => 'deskripsi', 'rules' => 'required'],
       'tipe' => ['label' => 'tipe', 'rules' => 'required'],
       'gambar' => ['label' => 'gambar', 'rules' => 'required'],
       'vaNumber' => ['label' => 'vaNumber', 'rules' => 'required'],
       'bank' => ['label' => 'bank', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
