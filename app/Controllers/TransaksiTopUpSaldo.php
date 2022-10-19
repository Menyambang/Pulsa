<?php namespace App\Controllers;

use App\Models\UserSaldoModel;
use CodeIgniter\Config\Config;
use App\Libraries\Notification;
use App\Controllers\MyResourceController;
use App\Entities\UserWeb as EntitiesUserWeb;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class TransaksiTopUpSaldo extends BaseController
{
    protected $modelName = 'App\Models\UserSaldoModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->template->setActiveUrl('TransaksiTopUpSaldo')
            ->view("Transaksi/topup_saldo");
    }

    public function verifikasiPembayaran($id)
    {
        $pembayaran = $this->_setIsiSaldo('settlement', $id);
        return $this->response->setJSON($pembayaran);
    }

    private function _setIsiSaldo($transaction_status, $transaction_id){
        $userSaldoModel = new UserSaldoModel();
        $find = $userSaldoModel->find($transaction_id);
        
        if(!empty($find)){
            Notification::sendNotif($find->userEmail, 'Pengisisan Saldo', "Status pembayaran anda $transaction_status, dengan ID {$find->orderId}");

            if($find->status != 'pending'){
                return $this->response(null, 500, 'Tidak bisa memverifikasi status pembayaran yang bukan pending');
            }else if($find->paymentType != 'manual_transfer'){
                return $this->response(null, 500, 'Tidak bisa memverifikasi status pembayaran yang bukan Transfer ke rekening');
            }

            $status = $userSaldoModel->update($transaction_id, [
                'usalStatus' => $transaction_status,
            ]);
    
            if($status){
                $data = $userSaldoModel->addSaldo($transaction_id);

                return $this->response(null, 200, 'Verifikasi Berhasil');
            }

        }

         return $this->response(null, 500, 'Verifikasi Gagal');
        ;
    }

}
