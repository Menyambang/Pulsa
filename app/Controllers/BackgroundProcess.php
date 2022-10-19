<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Libraries\Notification;
use App\Models\PembayaranModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class BackgroundProcess extends BaseController
{
    public function __construct()
    {
        helper('filesystem');
    }

    /**
     * Mengupdate pembayaran yang sudah expired
     * 
     * Cron JOB : php public/index.php background pembayaran_to_expired
     * Cron JOB Cpanel : /usr/local/bin/php /home/u1068353/public_html/public/index.php background pembayaran_to_expired
     * @return void
     */
    public function pembayaranToExpired()
    {
        Notification::sendTelegramBot('Cron JOB RUN `'.base_url().'`');

        $modelPembayaran = new PembayaranModel();
        $modelPembayaran->whereIn('pmbPaymentType', ['cod', 'manual_transfer']);
        $modelPembayaran->where('pmbStatus', 'pending');
        $modelPembayaran->where('pmbExpiredDate <', date('Y-m-d H:i:s'));
        $data = $modelPembayaran->find();

        foreach ($data as $value) {
            $message = "Status pembayaran anda expired, dengan ID {$value->orderId}";
            Notification::sendNotif($value->userEmail, 'Pembayaran Produk', $message);

            $modelPembayaran->update($value->id, ['pmbStatus' => 'expire']);

             // FIXED: RESTORE STOCK
             $keranjangModel = new KeranjangModel();
             $keranjangModel->restoreProdukStok($value->checkoutId);
        }

        return $this->response->setJSON($data);
    }
}
