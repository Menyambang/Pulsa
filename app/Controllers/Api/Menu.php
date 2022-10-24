<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class Menu
 * @note Resource untuk mengelola data m_menu
 * @dataDescription m_menu
 * @package App\Controllers
 */
class Menu extends MyResourceController
{
    protected $modelName = 'App\Models\MenuModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'label' => ['label' => 'label', 'rules' => 'required'],
       'idOperator' => ['label' => 'idOperator', 'rules' => 'required'],
       'jenis' => ['label' => 'jenis', 'rules' => 'required'],
       'showHome' => ['label' => 'showHome', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'kodeProdukPPOB' => ['label' => 'kodeProdukPPOB', 'rules' => 'required'],
       'targetUrlWeb' => ['label' => 'targetUrlWeb', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'label' => ['label' => 'label', 'rules' => 'required'],
       'idOperator' => ['label' => 'idOperator', 'rules' => 'required'],
       'jenis' => ['label' => 'jenis', 'rules' => 'required'],
       'showHome' => ['label' => 'showHome', 'rules' => 'required'],
       'urutan' => ['label' => 'urutan', 'rules' => 'required'],
       'icon' => ['label' => 'icon', 'rules' => 'required'],
       'kodeProdukPPOB' => ['label' => 'kodeProdukPPOB', 'rules' => 'required'],
       'targetUrlWeb' => ['label' => 'targetUrlWeb', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
