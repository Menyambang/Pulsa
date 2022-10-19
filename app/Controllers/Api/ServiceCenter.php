<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class ServiceCenter extends MyResourceController
{
    protected $modelName = 'App\Models\ServiceCenterModel';
    protected $format    = 'json';

}
