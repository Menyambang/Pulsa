<?php namespace App\Entities;
use App\Entities\MyEntity;

class NotifikasiTo extends MyEntity
{
    protected $datamap = [
        'id' => 'tnotifId',
        'email' => 'tnotifEmail',
        'notifId' => 'tnotifNotifId',
        'isRead' => 'tnotifIsRead',
        'createdAt' => 'tnotifCreatedAt',
        'updatedAt' => 'tnotifUpdatedAt',
        'deletedAt' => 'tnotifDeletedAt',
    ];

    protected $show = [
		'id',
		'email',
		'notifId',
		'isRead',
		'createdAt',
		'updatedAt',
		'deletedAt',
    ];
}