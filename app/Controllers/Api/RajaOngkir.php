<?php namespace App\Controllers\Api;

use App\Controllers\MyResourceController;
use App\Libraries\RajaOngkirShipping;
use App\Models\CheckoutModel;
use App\Models\KeranjangModel;
use App\Models\LokasiCodModel;
use App\Models\UserAlamatModel;

/**
 * Class Keranjang
 * @note Resource untuk mengelola data t_keranjang
 * @dataDescription t_keranjang
 * @package App\Controllers
 */
class RajaOngkir extends MyResourceController
{
    private $rajaOngkir;
    private $originId = '35'; // Kalimantan Selatan
    public $kurirSupport = ['jne', 'jnt'];

    function __construct()
    {
        $this->rajaOngkir = new RajaOngkirShipping();
    }

    function getKota(){
        $id = $this->request->getVar('id');
        $provinsi = $this->request->getVar('provinsi');
        
        return $this->response->setJSON($this->rajaOngkir->city($id, $provinsi));
    }

    function getProvinsi(){
        $id = $this->request->getVar('id');
        
        return $this->response->setJSON($this->rajaOngkir->province($id));
    }

    function getKecamatan(){
        $city = $this->request->getVar('city');
        
        return $this->response->setJSON($this->rajaOngkir->subdistrict($city));
    }

    /**
     * Get ongkir berdasarkan user
     *
     * @return void
     */
    function getOngkir(){
        $userAlamatModel = new UserAlamatModel();
        $keranjangModel = new KeranjangModel();

        $data = $userAlamatModel->where([
            'usralUsrEmail' => $this->user['email'],
            'usralIsActive' => '1',
        ])->first();
        // return $this->response->setJSON($data);
            
        $destination = $data->kotaId;
        $weight = $keranjangModel->getBeratKeranjangCheck($this->user['email']);
        
        $ongkir = [];
        $tujuan = [];
        $codData = [];

        $modelCod = new LokasiCodModel();
        $codData = $modelCod->filterByLocationUser($data->latitude, $data->longitude);

        foreach ($this->kurirSupport as $value) {
            $dataOngkir = $this->rajaOngkir->cost($this->originId, $destination, $weight, $value);

            if($dataOngkir['code'] == 200){
                $ongkir = array_merge($ongkir, $dataOngkir['data']);
                $tujuan = [
                    'asal' => $dataOngkir['extra']['origin_details'],
                    'tujuan' => $dataOngkir['extra']['destination_details'],
                ];
            }else{
                return $this->response->setJSON([
                    'code' => $dataOngkir['code'],
                    'message' => $dataOngkir['message'],
                    'data' => null
                ]);
            }
        }

        $data = [
            'code' => 200,
            'message' => null,
            'data' => [
                'ongkir' => $ongkir,
                'detail' => $tujuan,
                'cod' => $codData,
            ]
        ];
        
        return $this->response->setJSON($data);
    }

    /**
     * Undocumented function
     *
     * @param [type] $checkoutId
     * @return void
     */
    public function getStatusPerjalanan($checkoutId){
        $modelCheckout = new CheckoutModel();
        $modelCheckout->join('t_checkout_kurir', 'ckurCheckoutId = cktId');
        $data = $modelCheckout->where('cktId', $checkoutId)->get()->getRow();

        if(!empty($data)){
            $statusPerjalanan = $this->rajaOngkir->waybill($data->ckurNoResi, $data->ckurKurir);
            return $this->response->setJSON($statusPerjalanan);
        }

        return $this->response(null, 400, 'Checkout Id tidak ditemukan');
        
        
    }
}
