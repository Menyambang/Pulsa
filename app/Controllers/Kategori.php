<?php namespace App\Controllers;

use CodeIgniter\Config\Config;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class Kategori extends BaseController
{
    protected $modelName = 'App\Models\KategoriModel';
    protected $format    = 'json';

    protected $rules = [
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'icon' => ['label' => 'Icon', 'rules' => 'required|uploaded[icon]|max_size[icon,1024]|ext_in[icon,jpeg,jpg,png]|mime_in[icon, image/jpg,image/jpeg,image/png]'],
    ];
 
   public function index()
   {
       return $this->template->setActiveUrl('Kategori')
           ->view("Kategori/index");
   }

   protected function uploadFile($id)
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . PATH_KATEGORI_PRODUK;
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("icon");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['icon'] = $filename;
            $this->request->setGlobal("request", $post);
        }
    }

    public function simpan($primary = '')
    {
        $file = $this->request->getFile("icon");
        if ($file && $file->getError() == 0) {
            $post = $this->request->getVar();
            $post['icon'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('id');
        if ($id != '') {
            $checkData = $this->checkData($id);
            if (!empty($checkData) && $checkData->icon != '') {
                unset($this->rules['icon']);
            }
        }
        
        return parent::simpan($primary);
    }
}
