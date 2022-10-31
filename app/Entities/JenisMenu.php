<?php

namespace App\Entities;

use App\Entities\MyEntity;

class JenisMenu extends MyEntity
{
  protected $datamap = [
    'id' => 'jnmId',
    'label' => 'jnmLabel',
    'isWebView' => 'jnsIsWebView',
    'withFilter' => 'jnsWithFilter',
    'isPPOB' => 'jnsIsPPOB',
    'isPPOBMulti' => 'jnsIsPPOBMulti',
    'isCategory' => 'jnsIsCategory',
    'createdAt' => 'jnmCreatedAt',
    'updatedAt' => 'jnmUpdatedAt',
    'deletedAt' => 'jnsDeletedAt',
  ];

  protected $show = [
    'id',
    'label',
    'isWebView',
    'withFilter',
    'isPPOB',
    'isPPOBMulti',
    'isCategory',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
