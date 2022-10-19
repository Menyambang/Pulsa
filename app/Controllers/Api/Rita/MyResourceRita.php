<?php namespace App\Controllers\Api\Rita;

use App\Libraries\RitaApi;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * Class ProdukBeranda
 * @note Resource untuk mengelola data m_produk_beranda
 * @dataDescription m_produk_beranda
 * @package App\Controllers
 */
class MyResourceRita extends ResourceController
{
    const LIFETIME_MINUTE = 60 * 24; // 60 Menit
    const LIFETIME_ACCESS_TOKEN = (60 * self::LIFETIME_MINUTE); // 1 Hari
    const LIFETIME_REFRESH_TOKEN = (60 * 60 * 24 * self::LIFETIME_MINUTE); // 1 Tahun

    protected $ritaApi;
    protected $validationMessage = [];
    protected $user;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->user = count($request->fetchGlobal('decoded')) > 0 ? $request->fetchGlobal('decoded') : ['role' => '', 'filterIdentifier' => ''];
        $this->ritaApi = new RitaApi($this->user['gatewayToken'] ?? '');
		date_default_timezone_set('Asia/Kuala_Lumpur');
    }

    protected function response($data = null, int $code = 200, $message = null)
    {
        return parent::respond([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
