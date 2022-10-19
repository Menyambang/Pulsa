<?php


namespace App\Libraries;


use CodeIgniter\HTTP\DownloadResponse;

class MyDownloadResponse extends DownloadResponse
{
    private $notForce = false;

    public function __construct(string $filename, bool $setMime)
    {
        $data = null;
        if ($filename === '' || $data === '')
        {
            return null;
        }

        $filepath = '';
        if ($data === null)
        {
            $filepath = $filename;
            $filename = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $filename));
            $filename = end($filename);
        }

        parent::__construct($filename, $setMime);

        if ($filepath !== '')
        {
            $this->setFilePath($filepath);
        }
        elseif ($data !== null)
        {
            $this->setBinary($data);
        }

    }

    public function buildHeaders()
    {
        parent::buildHeaders();
        if($this->notForce){
            $this->removeHeader("Content-Disposition");
        }
    }

    public function notForce(){
        $this->notForce = true;
        return $this;
    }

}