<?php

namespace App\Entities;

use App\Entities\MyEntity;

class KodeOtp extends MyEntity
{
  protected $datamap = [
    'id' => 'ktId',
    'phoneNumber' => 'ktPhoneNumber',
    'otpCode' => 'ktOtpCode',
    'usrId' => 'ktUsrId',
    'createdAt' => 'ktCreatedAt',
    'updatedAt' => 'ktUpdatedAt',
    'deletedAt' => 'ktDeletedAt',
  ];

  protected $show = [
    'id',
    'phoneNumber',
    'otpCode',
    'usrId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
