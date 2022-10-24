<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class JenisMenu
 * @note Resource untuk mengelola data r_jenis_menu
 * @dataDescription r_jenis_menu
 * @package App\Controllers
 */
class JenisMenu extends MyResourceController
{
    protected $modelName = 'App\Models\JenisMenuModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'label' => ['label' => 'label', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'label' => ['label' => 'label', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
