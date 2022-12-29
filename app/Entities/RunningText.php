<?php

namespace App\Entities;

use App\Entities\MyEntity;

class RunningText extends MyEntity
{
  protected $datamap = [
    'id' => 'rtId',
    'pesan' => 'rtPesan',
    'status' => 'rtStatus',
    'expired' => 'rtExpired',
    'usrId' => 'rtUsrId',
    'createdAt' => 'rtCreatedAt',
    'updatedAt' => 'rtUpdatedAt',
    'deletedAt' => 'rtDeletedAt',
  ];

  protected $show = [
    'id',
    'pesan',
    'status',
    'expired',
    'usrId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
