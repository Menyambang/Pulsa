<?php namespace App\Controllers\Api;

use Ramsey\Uuid\Uuid;
use App\Models\UserModel;
use App\Models\UserSaldoModel;
use App\Libraries\MidTransPayment;
use App\Models\MetodePembayaranModel;
use App\Controllers\MyResourceController;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class User
 * @note Resource untuk mengelola data m_user
 * @dataDescription m_user
 * @package App\Controllers
 */
class TopUp extends MyResourceController
{
    const SALDO_PAYMENT_ID = 1;
    const MANUAL_TRANSFER_IDS = [2,3,4,5];
    const LIMIT_DAY_MANUAL_TRANSFER = 6;

    protected $modelName = 'App\Models\UserSaldoModel';
    protected $format = 'json';

    protected $rules = [
        'nominal' => ['label' => 'Nominal', 'rules' => 'required|numeric'],
        'id_metode_pembayaran' => ['label' => 'Metode Pembayaran', 'rules' => 'required|in_table[m_metode_pembayaran,mpbId]'],
    ];

    public function topUpSaldo()
    {
        if ($this->validate($this->rules, $this->validationMessage)) {
         
            $data = $this->request->getVar();
            try {
                $metodePembayaranModel = new MetodePembayaranModel();
                $metodePembayaranData = $metodePembayaranModel->find($data['id_metode_pembayaran']);
           
                $price = $data['nominal'];
                $bank = $metodePembayaranData->bank;

                // Topup Menggunakan Saldo ?
                if ($data['id_metode_pembayaran'] == self::SALDO_PAYMENT_ID) {
                    return $this->response(null, 400, 'Tidak bisa topup menggunakan saldo');

                // Topup menggunakan pembayaran manual ke rekening
                } else if (in_array($data['id_metode_pembayaran'], self::MANUAL_TRANSFER_IDS)) {
                    $dateTime = date('Y-m-d H:i:s');
                    $uuid = Uuid::uuid4().'-manual';
                    $orderId = 'TOPUP-'.strtotime("now");

                    $userSaldoModel = new UserSaldoModel();
                    $userSaldoModel->insert([
                        'usalId' => $uuid,
                        'usalPaymentType' => 'manual_transfer',
                        'usalStatus' => 'pending',
                        'usalTime' => $dateTime,
                        'usalOrderId' => $orderId,
                        'usalGrossAmount' => $price,
                        'usalCurrency' => 'IDR',
                        'usalRekNumber' => $metodePembayaranData->rekNumber,
                        'usalBank' => $bank,
                        'usalUserEmail' => $this->user['email'],
                        'usalStatusSaldo' => 'top_up',
                        'usalExpiredDate' => date('Y-m-d H:i:s', strtotime($dateTime." +".self::LIMIT_DAY_MANUAL_TRANSFER." days")),
                    ]);

                    $userSaldoModel = new UserSaldoModel();
                    return $this->response($userSaldoModel->find($uuid), 200);

                // Topup menggunakan MID Trans
                }else{
                    $midTransPayment = new MidTransPayment();
                    $data  = $midTransPayment->charge($metodePembayaranData,array(
                        'email' => $this->user['email'],
                        'first_name' => $this->user['nama'],
                        'last_name' => '',
                        'phone' => $this->user['noHp'],
                    ),array(
                        0 => array(
                            'id' => 'TopUp',
                            'price' => $price,
                            'quantity' => 1,
                            'name' => 'TopUp Saldo Menyambang',
                        )
                    ), $bank, $price);
    
                    if($data['status_code'] == 201){
                        $userSaldoModel = new UserSaldoModel();
                        $userSaldoModel->insert([
                            'usalId' => $data['transaction_id'],
                            'usalPaymentType' => $data['payment_type'],
                            'usalStatus' => $data['transaction_status'],
                            'usalTime' => $data['transaction_time'],
                            'usalSignatureKey' => '',
                            'usalOrderId' => $data['order_id'],
                            'usalMerchantId' => $data['merchant_id'],
                            'usalGrossAmount' => $data['gross_amount'],
                            'usalCurrency' => $data['currency'],
                            'usalVaNumber' => $data['permata_va_number'] ?? $data['va_numbers'][0]['va_number'] ?? '',
                            'usalBank' => isset($data['permata_va_number']) ? 'permata' :$data['va_numbers'][0]['bank'] ?? 'mandiri',
                            'usalBillerCode' => $data['biller_code'] ?? '',
                            'usalBillKey' => $data['bill_key'] ?? '',
                            'usalUserEmail' => $this->user['email'],
                            'usalPaymentCode' => $data['payment_code'] ?? '',
                            'usalStore' => $data['store'] ?? '',
                            'usalStatusSaldo' => 'top_up',
                            'usalExpiredDate' => date('Y-m-d H:i:s', strtotime($data['transaction_time']." +1 days")),
                        ]);
    
                        return $this->response($userSaldoModel->find($data['transaction_id']), 200);
                    }
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
