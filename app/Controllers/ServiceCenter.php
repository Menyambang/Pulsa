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
class ServiceCenter extends BaseController
{
    protected $modelName = 'App\Models\ServiceCenterModel';
    protected $format    = 'json';

    protected $rules = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,1024]|ext_in[foto,jpeg,jpg,png]|mime_in[foto, image/jpg,image/jpeg,image/png]'],
        'whatsapp' => ['label' => 'Whatsapp', 'rules' => 'permit_empty'],
        'noHp' => ['label' => 'No Hp', 'rules' => 'permit_empty'],
        'telegram' => ['label' => 'Telegram', 'rules' => 'permit_empty'],
        'latitude' => ['label' => 'Latitude', 'rules' => 'permit_empty'],
        'longitude' => ['label' => 'Longitude', 'rules' => 'permit_empty'],
    ];

   public function index()
   {
       return $this->template->setActiveUrl('ServiceCenter')
           ->view("ServiceCenter/index");
   }

   protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . PATH_FOTO_SERVICE_CENTER;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['foto'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("foto");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['foto'] = '-';
            $this->request->setGlobal("request", $post);
        }else{
            unset($this->rules['foto']);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->foto != '') {
                unset($this->rules['foto']);
            }
        }
        
        return parent::simpan($primary);
    }

}
