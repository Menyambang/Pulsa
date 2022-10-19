<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
/**
 * Class Banner
 * @note Resource untuk mengelola data m_banner
 * @dataDescription m_banner
 * @package App\Controllers
 */
class NoRekening extends BaseController
{
    protected $modelName = 'App\Models\MetodePembayaranModel';
    protected $format    = 'json';

    protected $rules = [
       'rekNumber' => ['label' => 'Nomor Rekening', 'rules' => 'required|numeric'],
   ];

   public function index()
   {
       return $this->template->setActiveUrl('NoRekening')
           ->view("Pengaturan/NoRekening/index");
   }

   /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->where('mpbTipe', 'manual_transfer');

        return parent::grid();
    }
}
