<?php

namespace App\Entities;

use App\Entities\MyEntity;

class CheckoutPulsa extends MyEntity
{

  protected $casts = [
    'pembayaran' => 'json',
    'produk' => 'json',
  ];

  protected $datamap = [
    'id' => 'cktpId',
    'email' => 'cktpEmail',
    'usalId' => 'cktpUsalId',
    'idProduk' => 'cktpIdProduk',
    'status' => 'cktpStatus',
    'tujuan' => 'cktpTujuan',
    'createdAt' => 'cktpCreatedAt',
    'updatedAt' => 'cktpUpdatedAt',
    'deletedAt' => 'cktpDeletedAt',
  ];

  protected $show = [
    'id',
    'email',
    'usalId',
    'idProduk',
    'status',
    'tujuan',
    'pembayaran',
    'produk',
    'createdAt',
    'updatedAt',
    'deletedAt',
  ];
}
