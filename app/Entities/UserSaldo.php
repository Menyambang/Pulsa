<?php

namespace App\Entities;

use App\Entities\MyEntity;

class UserSaldo extends MyEntity
{
  protected $datamap = [
    'id' => 'usalId',
    'paymentType' => 'usalPaymentType',
    'status' => 'usalStatus',
    'time' => 'usalTime',
    'signatureKey' => 'usalSignatureKey',
    'orderId' => 'usalOrderId',
    'merchantId' => 'usalMerchantId',
    'grossAmount' => 'usalGrossAmount',
    'currency' => 'usalCurrency',
    'vaNumber' => 'usalVaNumber',
    'rekNumber' => 'usalRekNumber',
    'bank' => 'usalBank',
    'billerCode' => 'usalBillerCode',
    'billKey' => 'usalBillKey',
    'userEmail' => 'usalUserEmail',
    'statusSaldo' => 'usalStatusSaldo',
    'expiredDate' => 'usalExpiredDate',
    'paymentCode' => 'usalPaymentCode',
    'store' => 'usalStore',
    'poin' => 'usalPoin',
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
    'statusSaldo',
    'expiredDate',
    'paymentCode',
    'store',
    'poin',
  ];
}
