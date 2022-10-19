<?php namespace App\Entities;
use App\Entities\MyEntity;

class CheckoutDetail extends MyEntity
{
    protected $datamap = [
        'id' => 'cktdtId',
        'checkoutId' => 'cktdtCheckoutId',
        'keterangan' => 'cktdtKeterangan',
        'biaya' => 'cktdtBiaya',
        'createdAt' => 'cktdtCreatedAt',
        'updatedAt' => 'cktdtUpdatedAt',
        'deletedAt' => 'cktdtDeletedAt',
    ];

    protected $show = [
		'id',
		'checkoutId',
		'keterangan',
		'biaya',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}