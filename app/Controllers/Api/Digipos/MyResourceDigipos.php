<?php namespace App\Controllers\Api\Digipos;

use App\Libraries\DigiposApi;
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
class MyResourceDigipos extends ResourceController
{
    const LIFETIME_MINUTE = 60 * 24; // 60 Menit
    const LIFETIME_ACCESS_TOKEN = (60 * self::LIFETIME_MINUTE); // 1 Hari
    const LIFETIME_REFRESH_TOKEN = (60 * 60 * 24 * self::LIFETIME_MINUTE); // 1 Tahun

    protected $digiposApi;
    protected $validationMessage = [];
    protected $user;
    protected $secret;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->user = count($request->fetchGlobal('decoded')) > 0 ? $request->fetchGlobal('decoded') : ['role' => '', 'filterIdentifier' => ''];
        $this->userData = json_decode($this->user['userJson'] ?? '')->user ?? '';

        $this->digiposApi = new DigiposApi((object)$request->fetchGlobal('secret') ?? [], $request->fetchGlobal('version')['app_version'] ?? '', $this->userData);
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

    protected function convertResponse($data = null)
    {
        try {
            return parent::respond([
                'code' => $data->status == '0' ? 200 : 500,
                'message' => $data->message,
                'data' => $data->data
            ]);
        } catch (\Throwable $th) {
            return parent::respond([
                'code' => 200,
                'message' => '',
                'data' => $data
            ]);
        }
    }
}
