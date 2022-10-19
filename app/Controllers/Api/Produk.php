<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Models\ProdukModel;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class Produk extends MyResourceController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $format    = 'json';

    public function show($id = null)
    {
        if($id){
            $produkModel = new ProdukModel();
            $produkData = $produkModel->find($id);

            $produkModel->update($id, [
                'produkDilihat' => $produkData->dilihat + 1
            ]);
        }

        $this->model->select('*');
        $this->model->with(['gambar']);
        return parent::show($id);
    }

    public function rekomendasi(){
        $this->model->orderBy('produkDilihat', 'DESC');
        return parent::index();
    }
}
