<?php

namespace App\Libraries;

// hex2bin: merubah hex to string
// base64_decode: merubah base64 to string
class Cryptography
{

    protected $key = 'e19bfde71b2141cef379691aa53f7251';
    protected $iv = '';
    protected $option = 0;
    protected $method = 'AES-128-ECB';
    protected $encReturn = 'base64';

    public function __construct($key, $method, $encReturn = 'hex', $iv = '')
    {
        $this->key = $key;
        $this->method = $method;
        $this->iv = $iv;
        $this->encReturn = $encReturn;
    }

    public function sslEncrypt($string)
    {
        $data = openssl_encrypt(
            $string,
            $this->method,
            hex2bin($this->key),
            $this->option,
            $this->iv
        );

        if($this->encReturn == 'base64'){
            return $data;
        }

        return bin2hex(base64_decode($data));
    }

    public function sslDecrypt($string)
    {
        $dec = openssl_decrypt(
            base64_encode($string),
            $this->method,
            hex2bin($this->key),
            $this->option,
            $this->iv
        );

        return $this->isJson($dec) ? json_decode($dec) : $dec;
    }

    /**
     * Check if result isJson
     *
     * @param [type] $string
     * @return boolean
     */
    function isJson($string) {
        return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                is_array(json_decode($string))))) ? true : false;
    }
}
