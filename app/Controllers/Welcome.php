<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\Eloquent\Users;
use App\Models\Eloquent\ProdukM;
use App\Controllers\BaseController;
use App\Models\Eloquent\ProdukBerandaM;
use App\Models\Eloquent\UserM;

class Welcome extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';

    public function index()
    {   
        $kategoriModel = new KategoriModel();

        $data = [
            'kategori' => $kategoriModel->find(),
        ];

        return view('Welcome/index',$data);
    }
     /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori', 'gambar']);
        // $this->model->withGambarProduk();

        return parent::grid();
    }

    public function coming_soon()
    {
        return view('Welcome/coming-soon');
    }
    
}
