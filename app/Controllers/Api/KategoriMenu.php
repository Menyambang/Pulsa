<?php

namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Entities\Menu;

/**
 * Class KategoriMenu
 * @note Resource untuk mengelola data t_kategori_menu
 * @dataDescription t_kategori_menu
 * @package App\Controllers
 */
class KategoriMenu extends MyResourceController
{
    protected $modelName = 'App\Models\KategoriMenuModel';
    protected $format    = 'json';

    protected $rulesCreate = [
        'ktgId' => ['label' => 'ktgId', 'rules' => 'required'],
        'menuId' => ['label' => 'menuId', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'ktgId' => ['label' => 'ktgId', 'rules' => 'required'],
        'menuId' => ['label' => 'menuId', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];
}
