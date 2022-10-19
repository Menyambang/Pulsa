<?php

namespace App\Filters;

use App\Libraries\MyMultipartParser\MyRequestParser;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiKeyFilter implements FilterInterface
{
    public const API_KEY_TOKPED = 'tokpedauthtenticator';
    public const API_KEY_DIGIPOS = 'digiposapisecret';
    /**
     * Cek Keberadaan Api Key di header request.
     * @param RequestInterface $request
     * @param null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service("response");
        $response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', 'X-ApiKey,X-Token')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST,OPTIONS, PUT, DELETE');

        if ($request->getMethod() == "put") {
            $request->setMethod("custom");
            $param = MyRequestParser::parse();
            foreach ($param->files as $key => $file) {
                $param->files[$key]['size'] = self::toBytes($file['size']) / 100;
            }
            if (count($param->files) > 0)
                $_FILES = $param->files;

            $request->setGlobal("request", $param->params);
        }

        $apiKeys = [config("App")->apiKeys, self::API_KEY_TOKPED, self::API_KEY_DIGIPOS];

        $apiKeyHeader = $request->getHeader("X-ApiKey");

        if (!isset($apiKeyHeader)) {
            $response = service("response");
            $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Gagal Otorisasi, Api Key diperlukan']);
            return $response;
        } elseif (!in_array($apiKeyHeader->getValue(), $apiKeys)) {
            $response->setJSON(['code' => 401, 'data' => null, 'message' => 'Gagal Otorisasi, Api Key Salah']);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    /**
     * Formatted bytes to bytes
     * @param string $formattedBytes
     *
     * @return int|null
     */
    private static function toBytes(string $formattedBytes): ?int
    {
        $units = ['B', 'K', 'M', 'G', 'T', 'P'];
        $unitsExtended = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $number = (int)preg_replace("/[^0-9]+/", "", $formattedBytes);
        $suffix = preg_replace("/[^a-zA-Z]+/", "", $formattedBytes);

        //B or no suffix
        if (is_numeric(substr($suffix, 0, 1))) {
            return preg_replace('/[^\d]/', '', $formattedBytes);
        }

        $exponent = array_flip($units)[$suffix] ?? null;
        if ($exponent === null) {
            $exponent = array_flip($unitsExtended)[$suffix] ?? null;
        }

        if ($exponent === null) {
            return null;
        }
        return $number * (1024 ** $exponent);
    }
}
