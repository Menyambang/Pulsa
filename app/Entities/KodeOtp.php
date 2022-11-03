<?php

namespace App\Entities;

use App\Entities\MyEntity;

class KodeOtp extends MyEntity
{
  protected $datamap = [
    'id' => 'ktId',
    'phoneNumber' => 'ktPhoneNumber',
    'otpCode' => 'ktOtpCode',
    'createdAt' => 'ktCreatedAt',
    'updatedAt' => 'ktUpdatedAt',
    'deletedAt' => 'ktDeletedAt',
  ];

  protected $show = [
    'id',
    'phoneNumber',
    'otpCode',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
