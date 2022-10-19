<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;
use CodeIgniter\Config\Config;
use App\Models\ProdukGambarModel;
use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use App\Controllers\MyResourceController;
use App\Models\ProdukVariantModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Border;
use CodeIgniter\Database\Exceptions\DatabaseException;

/**
 * Class Produk
 * @note Resource untuk mengelola data m_produk
 * @dataDescription m_produk
 * @package App\Controllers
 */
class Produk extends BaseController
{
    protected $modelName = 'App\Models\ProdukModel';
    protected $format    = 'json';

    protected $rules = [
        'id' => ['label' => 'Kode Produk', 'rules' => 'required|min_length[4]|cek_kode_sudah_digunakan[idBefore]'],
        'nama' => ['label' => 'Nama', 'rules' => 'required'],
        'deskripsi' => ['label' => 'Deskripsi', 'rules' => 'required'],
        'harga' => ['label' => 'Harga', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
        'stok' => ['label' => 'Stok', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
        'diskon' => ['label' => 'Diskon', 'rules' => 'required|numeric|less_than_equal_to[100]|greater_than_equal_to[0]'],
        'berat' => ['label' => 'Berat', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
        'kategoriId' => ['label' => 'Kategori', 'rules' => 'required'],
        'gambar[]' => ['label' => 'Gambar', 'rules' => 'required|uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar, image/jpg,image/jpeg,image/png,image/x-png]'],
    ];

    protected $rulesVariant = [
        'namaVariant' => ['label' => 'Nama', 'rules' => 'required'],
        'hargaVariant' => ['label' => 'Harga', 'rules' => 'required|numeric|greater_than_equal_to[0]'],
        'stokVariant' => ['label' => 'Stok', 'rules' => 'required|numeric|greater_than_equal_to[0]|cek_stok_variasi[stokProdukVariant]'],
        'stokProdukVariant' => ['label' => 'Stok Produk', 'rules' => 'required|numeric|greater_than_equal_to[1]|cek_stok_produk[]'],
        // 'gambarVariasi' => ['label' => 'Gambar', 'rules' => 'required|uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar, image/jpg,image/jpeg,image/png,image/x-png]'],
    ];

    public function index()
    {
        return $this->template->setActiveUrl('Produk')
            ->view("Produk/index");
    }

    /**
     * Mengambil data kategori
     *
     * @return void
     */
    private function getKategori()
    {
        $kategoriModel = new KategoriModel();

        $kategoriData = $kategoriModel->asObject()->find();

        $res = [];
        foreach ($kategoriData as $key => $value) {
            $res[$value->ktgId] = $value->ktgNama;
        }
        return $res;
    }

    /**
     * Menambahkan data kategori
     *
     * @return void
     */
    public function tambah()
    {
        $data = [
            'kategori' => $this->getKategori(),
        ];

        return $this->template->setActiveUrl('Produk')
            ->view("Produk/tambah", $data);
    }

    /**
     * Mengubah data produk ke halaman baru
     *
     * @param [type] $produkId
     * @return void
     */
    public function ubah($produkId)
    {
        $data = [
            'kategori' => $this->getKategori(),
            'produk' => $this->model->select('*')->with(['gambar', 'variant'])->find($produkId),
            'id' => $produkId,
        ];

        return $this->template->setActiveUrl('Produk')
            ->view("Produk/tambah", $data);
    }

    public function setThumbnail($prdGbrId)
    {
        $produkGambar = new ProdukGambarModel();

        $find = $produkGambar->where(['prdgbrId' => $prdGbrId])->find();
        $find = current($find);

        if (!empty($find)) {
            $produkGambar->where('prdgbrProdukId', $find->produkId)->update(null, ['prdgbrIsThumbnail' => 0]);
            $produkGambar->update($prdGbrId, ['prdgbrIsThumbnail' => 1]);

            $response = $this->response(null, 200, 'Data berhasil diperbaharui');
        } else {
            $response = $this->response(null, 500, 'ID Tidak ditemukan');
        }

        return $this->response->setJSON($response);
    }

    /**
     * Menghapus gambar rpoduk
     *
     * @param [type] $id
     * @param [type] $produkId
     * @return void
     */
    public function hapusGambar($id, $produkId)
    {
        try {
            $produkGambar = new ProdukGambarModel();
            $length = $produkGambar->where(['prdgbrProdukId' => $produkId])->asObject()->find();

            if (count($length) <= 1) {
                $response = $this->response(null, '500', 'Tidak bisa dihapus, setidaknya minimal ada 1 gambar');
                return $this->response->setJSON($response);
            }

            $status = $produkGambar->delete($id);

            $response = $this->response(null, ($status ? 200 : 500));
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
    }

    /**
     * Mengupload photo produk
     *
     * @param [type] $id
     * @return void
     */
    protected function uploadFile($id)
    {
        $produkGambarModel = new ProdukGambarModel();
        foreach ($this->request->getFileMultiple('gambar') as $file) {
            if ($file->getClientName() == '') {
                continue;
            }

            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/produk_gambar', $newName);

            $data = [
                'prdgbrProdukId' =>  $id,
                'prdgbrFile' =>  $newName,
            ];

            $save = $produkGambarModel->insert($data);

            $post = $this->request->getVar();
            $post['gambar[]'] = 'filename';
            $this->request->setGlobal("request", $post);
        }
    }

    /**
     * Grid Produk
     *
     * @return void
     */
    public function grid()
    {
        $this->model->select('*');
        $this->model->with(['kategori', 'gambar']);

        return parent::grid();
    }



    /**
     * Menyimpan data produk
     *
     * @param string $primary
     * @return void
     */
    public function simpan($primary = '')
    {
        $post = $this->request->getVar();
        $post['harga'] = str_replace(['.', ','], '', $post['harga']);
        $this->request->setGlobal("request", $post);

        $file = current($this->request->getFileMultiple("gambar"));
        // echo '<pre>';
        // print_r($file);
        // echo '</pre>';exit;
        if ($file && $file->getError() == 0) {
            $post['gambar[]'] = '-';
            $this->request->setGlobal("request", $post);
        }

        $id = $this->request->getVar('idBefore');
        if ($id != '') {
            $checkData = $this->checkData($id);

            if (!empty($checkData)) {
                unset($this->rules['gambar[]']);
            }
        }

        if ($this->request->isAJAX()) {

            helper('form');
            if ($this->validate($this->rules)) {

                try {
                    $primaryId = $this->request->getVar('idBefore');
                    $entityClass = $this->model->getReturnType();
                    $entity = new $entityClass();
                    $entity->fill($this->request->getVar());

                    $this->model->transStart();
                    if ($primaryId == '') {
                        $this->model->insert($entity, false);
                        $primaryId = $entity->id;
                        if ($this->model->getInsertID() > 0) {
                            $entity->{$this->model->getPrimaryKeyName()} = $this->model->getInsertID();
                        }
                    } else {
                        $this->model->set($entity->toRawArray())
                            ->update($primaryId);
                    }

                    $this->model->transComplete();
                    $status = $this->model->transStatus();

                    try {
                        $this->uploadFile($primaryId);
                    } catch (\Exception $ex) {
                        $response =  $this->response(null, 500, $ex->getMessage());
                        return $this->response->setJSON($response);
                    }

                    $response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
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

    private $productStartIndexExcel = 3;
    /**
     * Download Template produk
     *
     * @param integer $minimumStock
     * @return void
     */
    public function downloadTemplate($minimumStock = 0)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load(ROOTPATH . 'public/file_templates/Template Produk.xlsx');
        $sheet = $spreadsheet->setActiveSheetIndexByName('Template');

        $styleArrayRef = [
            'font' => [
                'bold' => false,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $refRowStart = $this->productStartIndexExcel;

        $no = 'A';
        $produkId = 'B';
        $produkNama = 'C';
        $produkStok = 'D';
        $produkHarga = 'E';

        // Referensi Produk
        $produkModel = new ProdukModel();
        if ($minimumStock != null) {
            $produkModel->where(['produkStok <=' => $minimumStock]);
        }
        $produk = $produkModel->asObject()->find();
        $refRowProduk = $refRowStart;
        foreach ($produk as $key => $val) {
            $refRowProduk++;
            $sheet->setCellValue("{$no}{$refRowProduk}", $key + 1);
            $sheet->setCellValue("{$produkId}{$refRowProduk}", $val->produkId);
            $sheet->setCellValue("{$produkNama}{$refRowProduk}", $val->produkNama);
            $sheet->setCellValue("{$produkStok}{$refRowProduk}", $val->produkStok);
            $sheet->setCellValue("{$produkHarga}{$refRowProduk}", $val->produkHarga);
        }
        $sheet->getStyle("{$no}{$refRowStart}:{$produkHarga}{$refRowProduk}")->applyFromArray($styleArrayRef);


        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('filename:Template_Produk.xlsx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Template_Produk.xlsx"');
        ob_end_clean();
        $writer->save("php://output");
        exit;
    }

    public function bulkUpdate()
    {
        $file = $this->request->getFile('file');
        $extension = $file->getClientExtension();

        if ($extension == 'xls') {
            $reader = new Xls();
        } else if ($extension == 'xlsx') {
            $reader = new Xlsx();
        } else {
            $response = [
                'code' => 400,
                'message' => [
                    'file' => 'Hanya File Excel 2007 (.xlsx) atau File Excel 2003 (.xls) yang diperbolehkan'
                ],
            ];

            return $this->response->setJSON($response);
        }

        $spreadsheet = $reader->load($file);
        $dataImport = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $dataImport = array_slice($dataImport, $this->productStartIndexExcel);

        $produkModel = new ProdukModel();
        $countUpdate = 0;
        foreach ($dataImport as $key => $value) {
            $id = $value['B'];
            if (!empty($id)) {
                $countUpdate++;
                $produkModel->update($id, [
                    'produkNama' => $value['C'],
                    'produkStok' => $value['D'],
                    'produkHarga' => $value['E'],
                ]);
            }
        }

        $response = [
            'code' => 200,
            'message' => $countUpdate . ' Produk Berhasil di update',
        ];

        return $this->response->setJSON($response);
    }

    protected function uploadFileVariasi()
    {
        helper("myfile");

        $path = Config::get("App")->uploadPath . "produk_variasi";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file = $this->request->getFile("gambarVariasi");
        if ($file && $file->getError() == 0) {

            $filename = date("Ymdhis") . "." . $file->getExtension();

            rename2($file->getRealPath(), $path . DIRECTORY_SEPARATOR . $filename);
            $post = $this->request->getVar();
            $post['gambarVariasi'] = $filename;
            $this->request->setGlobal("request", $post);
        }

    }

    public function hapusVariasi($id = '')
    {
        $produkVariant = new ProdukVariantModel();
        $produkVariant->delete($id);
        $response =  $this->response(null, 200, 'Berhasil dihapus');
        return $this->response->setJSON($response);
    }

    public function simpanVariasi($primary = '')
    {
        if(empty($this->request->getVar('produkId'))){
            $response =  $this->response(null, 403, 'Harap simpan produk terlebih dahulu');
            return $this->response->setJSON($response);
        }

        $post = $this->request->getVar();
        $post['hargaVariant'] = str_replace(['.', ','], '', $post['hargaVariant']);
        $this->request->setGlobal("request", $post);

        try {
            $this->uploadFileVariasi();
            $post = $this->request->getVar();
        } catch (\Exception $ex) {
            $response =  $this->response(null, 500, $ex->getMessage());
            return $this->response->setJSON($response);
        }

        if ($this->request->isAJAX()) {

            helper('form');
            if ($this->validate($this->rulesVariant)) {

                $produkVariant = new ProdukVariantModel();

                try {
                    $primaryId = $this->request->getVar('id');
                    $entityClass = $produkVariant->getReturnType();
                    $entity = new $entityClass();
                    $entity->harga = $post['hargaVariant'];
                    $entity->produkId = $post['produkId'];
                    $entity->nama = $post['namaVariant'];
                    $entity->stokProduk = $post['stokProdukVariant'];

                    if(@$post['gambarVariasi']){
                        $entity->gambar = $post['gambarVariasi'];
                    }

                    $produkVariant->transStart();
                    if ($primaryId == '') {
                        $produkVariant->insert($entity, false);
                        $primaryId = $entity->id;
                        if ($produkVariant->getInsertID() > 0) {
                            $entity->{$produkVariant->getPrimaryKeyName()} = $produkVariant->getInsertID();
                        }
                    } else {
                        $produkVariant->set($entity->toRawArray())
                            ->update($primaryId);
                    }

                    $produkVariant->transComplete();
                    $status = $produkVariant->transStatus();

                    $response = $this->response(($status ? $entity->toArray() : null), ($status ? 200 : 500));
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
}
