<?php namespace App\Entities;
use App\Entities\MyEntity;

class Pembayaran extends MyEntity
{
    protected $datamap = [
        'id' => 'pmbId',
        'paymentType' => 'pmbPaymentType',
        'status' => 'pmbStatus',
        'time' => 'pmbTime',
        'signatureKey' => 'pmbSignatureKey',
        'orderId' => 'pmbOrderId',
        'merchantId' => 'pmbMerchantId',
        'grossAmount' => 'pmbGrossAmount',
        'currency' => 'pmbCurrency',
        'vaNumber' => 'pmbVaNumber',
        'rekNumber' => 'pmbRekNumber',
        'bank' => 'pmbBank',
        'billerCode' => 'pmbBillerCode',
        'billKey' => 'pmbBillKey',
        'userEmail' => 'pmbUserEmail',
        'expiredDate' => 'pmbExpiredDate',
        'paymentCode' => 'pmbPaymentCode',
        'store' => 'pmbStore',
    ];

    protected $show = [
		'id',
		'paymentType',
		'status',
		'time',
		'signatureKey',
		'orderId',
		'merchantId',
		'grossAmount',
		'currency',
		'vaNumber',
		'rekNumber',
		'bank',
		'billerCode',
		'billKey',
		'userEmail',
		'expiredDate',
    'paymentCode',
    'store',
    ];
}