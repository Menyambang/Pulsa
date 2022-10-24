<?php

namespace App\Entities;

use App\Entities\MyEntity;

class JenisMenu extends MyEntity
{
  protected $datamap = [
    'id' => 'jnmId',
    'label' => 'jnmLabel',
    'createdAt' => 'jnmCreatedAt',
    'updatedAt' => 'jnmUpdatedAt',
    'deletedAt' => 'jnsDeletedAt',
  ];

  protected $show = [
    'id',
    'label',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
