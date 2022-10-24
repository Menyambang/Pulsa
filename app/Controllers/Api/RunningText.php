<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class RunningText
 * @note Resource untuk mengelola data m_running_text
 * @dataDescription m_running_text
 * @package App\Controllers
 */
class RunningText extends MyResourceController
{
    protected $modelName = 'App\Models\RunningTextModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'pesan' => ['label' => 'pesan', 'rules' => 'required'],
       'status' => ['label' => 'status', 'rules' => 'required'],
       'expired' => ['label' => 'expired', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'pesan' => ['label' => 'pesan', 'rules' => 'required'],
       'status' => ['label' => 'status', 'rules' => 'required'],
       'expired' => ['label' => 'expired', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
