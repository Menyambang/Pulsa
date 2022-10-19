<?php namespace App\Controllers;

use App\Models\Pulsa\KategoriPulsaModel;
use CodeIgniter\Config\Config;

/**
 * Class Kategori
 * @note Resource untuk mengelola data m_kategori
 * @dataDescription m_kategori
 * @package App\Controllers
 */
class ProdukPulsa extends BaseController
{
    protected $modelName = 'App\Models\Pulsa\ProdukPulsaModel';
    protected $format    = 'json';

    protected $rules = [
        'kode' => ['label' => 'Kode', 'rules' => 'required'],
        'kategoriId' => ['label' => 'Kategori', 'rules' => 'required'],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required'],
        // 'urutan' => ['label' => 'urutan', 'rules' => 'required'],
        'kodeSuplier' => ['label' => 'Kode Suplier', 'rules' => 'required'],
        'jenis' => ['label' => 'Jenis', 'rules' => 'required'],
        'poin' => ['label' => 'Poin', 'rules' => 'required'],
        'jamOperasionalStart' => ['label' => 'Jam Mulai Operasional', 'rules' => 'required'],
        'jamOperasionalEnd' => ['label' => 'Jam Akhir Operasional', 'rules' => 'required'],
        'harga' => ['label' => 'Harga', 'rules' => 'required'],
        'saranHarga' => ['label' => 'Saran Harga', 'rules' => 'required'],
    ];
 
   public function index()
   {
       $kategoriModel = new KategoriPulsaModel();
       
       $data = [
           'selectJenis' => [
               'elektrik' => 'Elektrik',
               'ppob' => 'PPOB',
           ],
           'selectKategori' => $kategoriModel->selectKategori(),
       ];

       return $this->template->setActiveUrl('ProdukPulsa')
           ->view("ProdukPulsa/index", $data);
   }

   public function simpan($primary = '')
    {
        $post = $this->request->getVar();
        if(empty($primary)){
            $this->model->where('ppKpId', $post['kategoriId']);
            $data = $this->model->find();
            $post['urutan'] = count($data) + 1;
            $this->request->setGlobal("request", $post);
        }

        return parent::simpan($primary);
    }

   public function findAll()
   {
       $data = $this->request->getVar();
      
       $this->model->where('ppKpId', $data['kategori']);
       $this->model->orderBy('ppUrutan', 'ASC');
       return parent::findAll();
   }

   public function simpanUrutan()
    {
        $post = $this->request->getVar('data');
        $sortedData = [];
        foreach ($post as $key => $value) {
            $urutanNumber = ($key + 1);
            if ($value['urutan'] != $urutanNumber) {
                $sortedData[] = [
                    'ppId' => $value['id'],
                    'ppUrutan' => $urutanNumber,
                ];
            }
        }

        if (!empty($sortedData)) {
            $this->model->updateBatch($sortedData, 'ppId');
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil diurutkan'
        ]);
    }
}
