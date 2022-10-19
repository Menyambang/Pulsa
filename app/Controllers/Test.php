<?php

namespace App\Controllers;

use Ramsey\Uuid\Uuid;
use ReCaptcha\ReCaptcha;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Models\Eloquent\UserM;
use App\Libraries\Notification;
use App\Libraries\MidTransPayment;
use App\Libraries\MyIpaymuPayment;
use App\Controllers\BaseController;
use App\Entities\User;
use App\Libraries\RajaOngkirShipping;
use App\Models\Eloquent\ProdukBerandaM;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Test extends BaseController
{
   
    public function testNotifFirebase(){
        $res = Notification::sendNotif();

		return $this->response->setJSON($res);
    }

    public function cekMidTrans(){
        $midTrans = new MidTransPayment();
        $data = [
            'transactionStatus' => $midTrans->transactionStatus('order-101q-1643016504'),
            // 'chargeBankBNIVA' => $midTrans->chargeBankBNIVA(),
            // 'chargeGopay' => $midTrans->chargeGopay(),
          
        ];
		return $this->response->setJSON($data);
    }

    public function cekRajaOngkir(){
        $rajaOngkir = new RajaOngkirShipping();
        $data = [
            // 'province' => $rajaOngkir->province(),
            // 'city' => $rajaOngkir->city(),
            'cost' => $rajaOngkir->cost(1,1,1,'jne'),
            // 'subdistrict' => $rajaOngkir->subdistrict(1),
            // 'currency' => $rajaOngkir->currency(),
            // 'waybill' => $rajaOngkir->waybill('002837509520', 'sicepat'),
          
        ];

		return $this->response->setJSON($data);
    }

    public function testWa(){
        $data = Notification::sendWa('081251554104', 'Test');

        return $this->response->setJSON($data);
    }

    public function testEmail()
    {
        $data = Notification::sendEmail('ahmadjuhdi007@gmail.com', 'Verifikasi', view('Template/email/verifikasi', [
            'nama' => 'Ahmad Juhdi',
            'key' => Uuid::uuid4(),
        ]));

        return $this->response->setJSON(json_encode($data));
    }

    // Eloquent
    public function test(){
        $Users = UserM::with(['alamat'])->get(['usrEmail as email']);
     
        return $this->response->setJSON(($Users));
    }

    private function mapData($data){
        $entity = new User();

        foreach ($entity->getDatamap() as $key => $value) {
            $data[$key] = $data->{$value};
            unset($data[$value]);
        }
        return $data;
       
    }

    public function testProduk(){
        $produk = ProdukBerandaM::with(['produk'])->get();

        return $this->response->setJSON($produk);
    }

    public function test1(){
        
        $Users = UserM::join('m_user_alamat', function ($join) {
            $join->on('usrEmail', '=', 'usralUsrEmail');
        })
        ->get();

        return $this->response->setJSON($Users);
    }


}
