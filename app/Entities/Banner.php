<?php

namespace App\Entities;

use App\Entities\MyEntity;

class Banner extends MyEntity
{
  protected $datamap = [
    'id' => 'bnrId',
    'deskripsi' => 'bnrDeskripsi',
    'gambar' => 'bnrGambar',
    'url' => 'bnrUrl',
    'jenis' => 'bnrJenis',
    'type' => 'bnrType',
    'usrId' => 'bnrUsrId',
    'createdAt' => 'bnrCreatedAt',
    'updatedAt' => 'bnrUpdatedAt',
    'deletedAt' => 'bnrDeletedAt',
  ];

  protected $show = [
    'id',
    'deskripsi',
    'gambar',
    'url',
    'jenis',
    'type',
    'usrId',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
