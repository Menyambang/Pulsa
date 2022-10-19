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
class Broadcast extends BaseController
{
    protected $modelName = 'App\Models\BroadcastModel';
    protected $format    = 'json';

    protected $rules = [
       'judul' => ['label' => 'Judul', 'rules' => 'required'],
       'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required'],
       'gambar' => ['label' => 'Gambar', 'rules' => 'uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,jpeg,jpg,png]|mime_in[gambar, image/jpg,image/jpeg,image/png]'],
    //    'url' => ['label' => 'Url', 'rules' => 'required'],
   ];

   public function index()
   {
       return $this->template->setActiveUrl('Broadcast')
           ->view("Broadcast/index");
   }

   protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "broadcast_gambar";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("gambar");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['gambar'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("gambar");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['gambar'] = '-';
            $this->request->setGlobal("request", $post);
        }else{
            unset($this->rules['gambar']);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->gambar != '') {
                unset($this->rules['gambar']);
            }
        }
        
        $res = parent::simpan($primary);
        $data = json_decode($this->response->getJSON($res));
        $data = $data->data;
        $data = $this->model->find($data->id);
       
        // Boradcast all to general topic
        $notif = Notification::sendBroadcastNotif($data->judul, $data->deskripsi, base_url('File/get/broadcast_gambar/'.$data->gambar));
        return $res;
    }

}
