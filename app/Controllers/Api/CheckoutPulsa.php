<?php

namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\UserSaldoModel;
use App\Models\PembayaranModel;
use App\Models\UserAlamatModel;
use App\Libraries\PulsaBridgeApi;
use App\Libraries\MidTransPayment;
use App\Models\CheckoutPulsaModel;
use App\Models\CheckoutDetailModel;
use App\Models\MetodePembayaranModel;
use App\Models\Pulsa\ProdukPulsaModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class CheckoutPulsa
 * @note Resource untuk mengelola data t_checkout_pulsa
 * @dataDescription t_checkout_pulsa
 * @package App\Controllers
 */
class CheckoutPulsa extends MyResourceController
{
    const SALDO_PAYMENT_ID = 1;
    const COD_PAYMENT_ID = 99;
    const MANUAL_TRANSFER_IDS = [2, 3, 4, 5];

    /**
     * Limit day payment
     */
    const LIMIT_DAY_MANUAL_TRANSFER = 1;
    const LIMIT_DAY_COD = 1;
    const LIMIT_DAY_MIDTRANS = 1;

    protected $modelName = 'App\Models\CheckoutPulsaModel';
    protected $format    = 'json';

    protected $checkout = [
        'idProduk' => [
            'label' => 'idProduk', 'rules' => 'required|in_table[m_produk_pulsa,ppId]',
            'errors' => ['in_table' => '{field} wajib diisi.']
        ],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required|numeric'],
        // 'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    protected $rulesCreate = [
        'email' => ['label' => 'email', 'rules' => 'required'],
        'pmbId' => ['label' => 'pmbId', 'rules' => 'required'],
        'idProduk' => ['label' => 'idProduk', 'rules' => 'required'],
        'status' => ['label' => 'status', 'rules' => 'required'],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    protected $rulesUpdate = [
        'email' => ['label' => 'email', 'rules' => 'required'],
        'pmbId' => ['label' => 'pmbId', 'rules' => 'required'],
        'idProduk' => ['label' => 'idProduk', 'rules' => 'required'],
        'status' => ['label' => 'status', 'rules' => 'required'],
        'tujuan' => ['label' => 'tujuan', 'rules' => 'required'],
        'deletedAt' => ['label' => 'deletedAt', 'rules' => 'required'],
    ];

    public function index()
    {
        $post = $this->request->getGet();
        $post['pembayaran_userEmail']['eq'] = $this->user['email'];
        $this->request->setGlobal("get", $post);
        return parent::index();
    }

    /**
     * Checkout Produk
     *
     * @return void
     */
    public function checkout()
    {
        $post = $this->request->getVar();

        if ($this->validate($this->checkout, $this->validationMessage)) {
            try {

                // Tambahkan data checkout
                // $checkoutModel = new CheckoutPulsaModel();
                $this->model->transStart();
                $checkoutId = $this->model->insert([
                    'cktpTujuan' => $post['tujuan'],
                    'cktpIdProduk' => $post['idProduk'],
                    'cktpEmail' => $this->user['email'],
                ]);
                $checkoutModelStatus = $this->model->transStatus();

                if ($checkoutModelStatus) {
                    $produkPulsaModel = new ProdukPulsaModel();
                    $produkPulsa = $produkPulsaModel->find($post['idProduk']);
                    $price = $produkPulsa->harga;
                  
                    // Pembayaran Menggunakan Saldo
                    $modelUser = new UserModel();
                    $dataUser = $modelUser->find($this->user['email']);

                    // Jika saldo memenuhi
                    if ($dataUser->saldo >= $price) {

                        $pulsaBridge = new PulsaBridgeApi();
                        $res = $pulsaBridge->get([
                            'kodeproduk' => $produkPulsa->kode,
                            'tujuan' => $post['tujuan'],
                            'idtrx' => $checkoutId,
                        ]);

                        if($res['success']){
                            $modelUser->update($this->user['email'], [
                                'usrSaldo' => $dataUser->saldo - $price,
                                'usrPoin' => $dataUser->poin + $produkPulsa->poin,
                            ]);
                        }else{
                            return $this->response(null, 403, $res['msg']);
                        }
                    } else {
                        return $this->response(null, 403, 'Saldo anda tidak memenuhi, topup untuk menambahkan saldo anda');
                    }

                    $uuid = Uuid::uuid4();
                    $orderId = 'ORDER-' . strtotime("now");
                    // Tambah Riwayat saldo
                    $userSaldoModel = new UserSaldoModel();
                    $userSaldoModel->insert([
                        'usalId' => $uuid,
                        'usalPaymentType' => 'saldo',
                        'usalStatus' => 'settlement',
                        'usalTime' => date('Y-m-d H:i:s'),
                        'usalOrderId' => $orderId,
                        'usalUserEmail' => $this->user['email'],
                        'usalStatusSaldo' => 'pembelian_pulsa',
                        'usalGrossAmount' => -$price,
                        'usalPoin' => $produkPulsa->poin,
                    ]);

                    // Update Checkout
                    // $checkoutModel = new CheckoutPulsaModel();
                    $this->model->update($checkoutId, [
                        'cktpUsalId' => $uuid,
                    ]);

                    $this->model->transComplete();

                    $response = current($userSaldoModel->where('usalId', $uuid)->find());
                    return $this->response($response, 200, $uuid);
                }

                return $this->response(null, 400, 'Gagal Melakukan Pembayaran');
            } catch (DatabaseException $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\mysqli_sql_exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            } catch (\Exception $ex) {
                return $this->response(null, 500, $ex->getMessage());
            }
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }
}
