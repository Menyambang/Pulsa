<?php namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Libraries\Notification;
use App\Models\PembayaranModel;
use App\Controllers\Api\Keranjang;
use App\Models\CheckoutKurirModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class TransaksiPembelianProduk extends BaseController
{
    protected $modelName = 'App\Models\CheckoutModel';
    protected $format    = 'json';

    protected $rules = [
        'noResi' => ['label' => 'Nomor Resi', 'rules' => 'required'],
    ];

    public function index()
    {
        return $this->template->setActiveUrl('TransaksiPembelianProduk')
            ->view("Transaksi/PembelianProduk/index");
    }

     /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori', 'pembayaran', 'kurir', 'alamat', 'detail']);

        return parent::grid();
    }

    public function keranjangDetail($idCheckout){
        $keranjangModel = new KeranjangModel();
        
        $response =  $this->response($keranjangModel->getKeranjangDetail($idCheckout), 200);
        return $this->response->setJSON($response);
    }

    public function simpan($primary = '')
	{
		if ($this->request->isAJAX()) {

			helper('form');
			if ($this->validate($this->rules)) {
				try {
					$primaryId = $this->request->getVar($primary);
					$noResi = $this->request->getVar('noResi');

					$checkoutKurirModel = new CheckoutKurirModel();
                    $checkoutKurirModel->where('ckurCheckoutId', $primaryId);
                    $checkoutKurirModel->update(null, [
                        'ckurNoResi' => $noResi,
                    ]);

                    $this->model->update($primaryId, [
                        'cktStatus' => 'dikirim',
                    ]);

					$response = $this->response(null, 200, 'No Resi berhasil diperbaharui');
					return $this->response->setJSON($response);
				} catch (DatabaseException $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\mysqli_sql_exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				} catch (\Exception $ex) {
					$response =  $this->response(null, 500, $ex->getMessage());
					return $this->response->setJSON($response);
				}
			} else {
				$response =  $this->response(null, 400, $this->validator->getErrors());
				return $this->response->setJSON($response);
			}
		}
	}

    public function verifikasiPembayaran($id)
    {
        $pembayaran = $this->_setPembayaranProduk('settlement', $id);
        return $this->response->setJSON($pembayaran);
    }

    public function invoice($id){
        $keranjangModel = new KeranjangModel();
        $detail =  $keranjangModel->getKeranjangDetail($id);

        if(empty($detail)){
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->model->with(['kategori', 'pembayaran', 'kurir', 'alamat', 'detail', 'user']);
        $data =  $this->model->find($id);

        return $this->template
            ->view("Transaksi/PembelianProduk/invoice",[
                'data' => $data,
                'detail' => $detail,
            ]);
    }

    private function _setPembayaranProduk($transaction_status, $transaction_id){
        $pembayaranModel = new PembayaranModel();
        $find = $pembayaranModel->find($transaction_id);

        if(!empty($find)){

            if($find->status != 'pending'){
                return $this->response(null, 500, 'Tidak bisa memverifikasi status pembayaran yang bukan pending');
            }else if($find->paymentType != 'manual_transfer' && $find->paymentType != 'cod'){
                return $this->response(null, 500, 'Tidak bisa memverifikasi status pembayaran yang bukan Transfer ke rekening');
            }

            $status = $pembayaranModel->update($transaction_id, [
                'pmbStatus' => $transaction_status,
            ]);
            
            if($status){
                Notification::sendNotif($find->userEmail, 'Pembayaran Produk', "Status pembayaran anda $transaction_status, dengan ID {$find->orderId}");
                if($transaction_status == 'settlement'){
                    $checkoutId = $pembayaranModel->find($transaction_id)->checkoutId;
                    $checkoutModel = new CheckoutModel();
                    $checkoutModel->update($checkoutId, [
                        'cktStatus' => 'dikemas'
                    ]);

                    return $this->response(null, 200, 'Verifikasi Berhasil');
                }
            }
        }

        return $this->response(null, 500, 'Verifikasi Gagal');
    }

}
