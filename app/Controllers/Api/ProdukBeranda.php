<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class ProdukBeranda extends MyResourceController
{
    protected $modelName = 'App\Models\ProdukBerandaModel';
    protected $format    = 'json';

    public function index()
    {
        // return $this->response( $this->model->getDetailProdukBeranda(), 200);

        $this->model->select('*');
        $this->model->with(['products']);

        return parent::index();
    }
}
