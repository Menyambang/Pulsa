<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Libraries\Notification;
use App\Controllers\MyResourceController;
/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class RunningText extends BaseController
{
    protected $modelName = 'App\Models\RunningTextModel';
    protected $format    = 'json';

    protected $rules = [
       'pesan' => ['label' => 'Pesan', 'rules' => 'required'],
       'status' => ['label' => 'Status', 'rules' => 'required'],
       'expired' => ['label' => 'Expired', 'rules' => 'required'],
   ];

   public function index()
   {
       return $this->template->setActiveUrl('RunningText')
           ->view("RunningText/index");
   }

}
