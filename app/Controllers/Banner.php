<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class Banner extends BaseController
{
    protected $modelName = 'App\Models\BannerModel';
    protected $format    = 'json';

    protected $rules = [
       'type' => ['label' => 'Tipe', 'rules' => 'required'],
       'jenis' => ['label' => 'Jenis', 'rules' => 'required'],
       'gambar' => ['label' => 'Gambar', 'rules' => 'required|uploaded[gambar]|max_size[gambar,1024]|ext_in[gambar,jpeg,jpg,png]|mime_in[gambar, image/jpg,image/jpeg,image/png]'],
    //    'url' => ['label' => 'Url', 'rules' => 'required'],
   ];

   public function index()
   {
       $data['selectJenis'] = $this->model->selectJenis();
       $data['selectTipe'] = $this->model->selectTipe();

       return $this->template->setActiveUrl('Banner')
           ->view("Banner/index", $data);
   }

   public function grid()
   {
       $this->model->select('*');
       $this->model->with(['kategori', 'produk']);

       return parent::grid();
   }

   protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . PATH_BANNER;
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
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->gambar != '') {
                unset($this->rules['gambar']);
            }
        }
        
        return parent::simpan($primary);
    }

}
