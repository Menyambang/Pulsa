<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
/**
 * Class KodeOtp
 * @note Resource untuk mengelola data t_kode_otp
 * @dataDescription t_kode_otp
 * @package App\Controllers
 */
class KodeOtp extends MyResourceController
{
    protected $modelName = 'App\Models\KodeOtpModel';
    protected $format    = 'json';

    protected $rulesCreate = [
       'phoneNumber' => ['label' => 'phoneNumber', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];

    protected $rulesUpdate = [
       'phoneNumber' => ['label' => 'phoneNumber', 'rules' => 'required'],
       'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
   ];
}
