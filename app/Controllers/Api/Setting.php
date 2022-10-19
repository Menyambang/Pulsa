<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class Setting
 * @note Resource untuk mengelola data m_setting
 * @dataDescription m_setting
 * @package App\Controllers
 */
class Setting extends MyResourceController
{
    protected $modelName = 'App\Models\SettingModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'key' => ['label' => 'key', 'rules' => 'required'],
       'value' => ['label' => 'value', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'key' => ['label' => 'key', 'rules' => 'required'],
       'value' => ['label' => 'value', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
