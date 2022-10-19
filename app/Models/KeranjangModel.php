<?php

namespace App\Models;

use App\Entities\Checkout;
use App\Models\MyModel;
use App\Entities\Produk;
use App\Entities\Kategori;
use App\Entities\ProdukGambar;
use App\Entities\ProdukVariant;
use App\Entities\User;

class KeranjangModel extends MyModel
{
    protected $table = "t_keranjang";
    protected $primaryKey = "krjId";
    protected $createdField = "krjCreatedAt";
    protected $updatedField = "krjUpdatedAt";
    protected $returnType = "App\Entities\Keranjang";
    protected $allowedFields = ["krjProdukId", "krjVariantId", "krjQuantity", "krjPesan", "krjCheckoutId", "krjDeletedAt", "krjUserEmail", "krjIsChecked"];

    public function getReturnType()
    {
        return $this->returnType;
    }

    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    protected function relationships()
    {
        // $variantQuery = "SELECT *,
        //     JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukVariant::class) . ")) AS variant
        //     FROM `t_produk_variant` 
        //     GROUP BY pvarProdukId";

        // $gambarQuery = "SELECT *,
        //     JSON_ARRAYAGG(JSON_OBJECT(" . $this->entityToMysqlObject(ProdukGambar::class) . ")) AS gambars
        //     FROM `t_produk_gambar` 
        //     GROUP BY prdgbrProdukId";

        // $kategoriQuery = "SELECT *,
        //     (JSON_OBJECT(" . $this->entityToMysqlObject(Kategori::class) . ")) AS kategori
        //     FROM `m_kategori` 
        //     GROUP BY ktgId";

        // $productsQuery = "SELECT *,
        //     (JSON_OBJECT(" . $this->entityToMysqlObject(Produk::class) . ", 
        //     'gambar', JSON_EXTRACT(gambar.gambars,'$'), 
        //     'kategori', JSON_EXTRACT(kategori.kategori,'$'),
        //     'variant', JSON_EXTRACT(variant.variant,'$')
        //     )) AS products
        //     FROM `m_produk` 
        //     LEFT JOIN (" . $gambarQuery . ") gambar ON gambar.prdgbrProdukId = produkId 
        //     LEFT JOIN (" . $kategoriQuery . ") kategori ON kategori.ktgId = produkKategoriId 
        //     LEFT JOIN (" . $variantQuery . ") variant ON variant.pvarProdukId = produkId 
        //     GROUP BY produkId";

        return [
            'user' =>  $this->belongsTo('m_user', User::class, 'usrEmail = krjUserEmail', 'user'),
            // 'products' => ['table' => "({$productsQuery})", 'condition' => 'krjProdukId = produkId', 'field_json' => 'products', 'type' => 'left'],
            'products' => $this->belongsTo('m_produk', Produk::class, 'krjProdukId = produkId', 'products', 'produkId', 'left', function ($relation) {
                return $relation->hasMany('t_produk_variant', ProdukVariant::class, 'pvarProdukId = produkId', 'variant', 'pvarProdukId');
            }, function ($relation) {
                return $relation->hasMany('t_produk_gambar', ProdukGambar::class, 'prdgbrProdukId = produkId', 'gambar', 'prdgbrProdukId');
            }, function ($relation) {
                return $relation->belongsTo('m_kategori', Kategori::class, 'ktgId = produkKategoriId', 'kategori', 'ktgId');
            }),
            'checkout' =>  $this->belongsTo('t_checkout', Checkout::class, 'cktId = krjCheckoutId', 'checkout'),
        ];
    }

    /**
     * Undocumented function
     *
     * @return double
     */
    public function getBeratKeranjangCheck($email)
    {
        $data = $this->query("SELECT SUM(prd.`produkBerat`) berat FROM `t_keranjang` krj
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        WHERE 
        krj.`krjCheckoutId` IS NULL AND 
        krj.`krjIsChecked` = '1' AND
        krj.`krjUserEmail` = " . $this->db->escape($email))->getRow();

        return $data->berat ?? 0;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getProdukKeranjang($email)
    {
        $keranjangModel = new KeranjangModel();
        $keranjangModel->select('*');
        $keranjangModel->with(['products']);
        $data = $keranjangModel->where([
            'krjUserEmail' => $email,
            'krjIsChecked' => 1,
            'krjCheckoutId' => null,
        ])->find();

        $harga = 0;
        foreach ($data as $key => $value) {
            $variant = $value->products->variant;

            if (!empty($variant)) {
                $variantId = $value->variantId;
                $variantSearch = current(array_filter($variant, function ($e) use ($variantId) {
                    return $e->id == $variantId;
                }));

                if (!empty($variantSearch)) {
                    $harga += $variantSearch->harga;
                } else {
                    $harga += $value->products->harga;
                }
            } else {
                $harga += $value->products->harga;
            }
        }
        // return $data;

        // $data = $this->query("SELECT SUM(produkHarga - (produkHarga*produkDiskon/100)) * krjQuantity AS harga, COUNT(krjId) as jlhProdukCheckout FROM `t_keranjang` krj
        // JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        // WHERE 
        // krj.`krjCheckoutId` IS NULL AND 
        // krj.`krjIsChecked` = '1' AND
        // krj.`krjUserEmail` = " . $this->db->escape($email))->getRow();

        return [
            'harga' => intval($harga) ?? 0,
            'jumlah' => intval(count($data)) ?? 0,
        ];
    }

    public function updateKeranjangToCheckout($checkoutId, $email)
    {
        $this->where('krjIsChecked', 1);
        $this->where('krjCheckoutId', null);
        $this->where('krjUserEmail', $email);

        $this->update(null, [
            'krjCheckoutId' => $checkoutId,
        ]);
    }

    public function updateProdukStok($checkoutId)
    {
        $data = $this->where('krjCheckoutId', $checkoutId)->find();

        $produkModel = new ProdukModel();
        $variantModel = new ProdukVariantModel();
        foreach ($data as $keranjang) {
            $variantFromStok = 1;
            if (!empty($keranjang->variantId)) {
                $variantData = $variantModel->find($keranjang->variantId);
                $variantData->stok = $variantData->stok - $keranjang->krjQuantity;
                $variantFromStok = $variantData->produkStok;
                $variantModel->save($variantData);
            }

            $produkData = $produkModel->find($keranjang->produkId);
            $produkData->stok = $produkData->stok - ($keranjang->krjQuantity * $variantFromStok);
            $produkModel->save($produkData);
        }
    }

    public function restoreProdukStok($checkoutId)
    {
        $data = $this->where('krjCheckoutId', $checkoutId)->find();

        $produkModel = new ProdukModel();
        $variantModel = new ProdukVariantModel();
        foreach ($data as $keranjang) {
            $variantFromStok = 1;
            if (!empty($keranjang->variantId)) {
                $variantData = $variantModel->find($keranjang->variantId);
                $variantData->stok = $variantData->stok + $keranjang->krjQuantity;
                $variantFromStok = $variantData->produkStok;
                $variantModel->save($variantData);
            }

            $produkData = $produkModel->find($keranjang->produkId);
            $produkData->stok = $produkData->stok + ($keranjang->krjQuantity * $variantFromStok);
            $produkModel->save($produkData);
        }
    }

    public function getKeranjangDetail($checkoutId = null, $userEmail = null)
    {
        $this->select('*');
        if (!empty($checkoutId)) {
            $this->where(['krjCheckoutId' => $checkoutId]);
        }
        if (!empty($userEmail)) {
            $this->where(['krjUserEmail' => $userEmail]);
        }
        $this->with(['products', 'checkout', 'alamat']);

        $data = $this->find();

        $data = array_map(function ($e) {
            $e = $e;
            $produkGambarModel = new ProdukGambarModel();
            $kategoriModel = new KategoriModel();
            $combine['kategori'] = $kategoriModel->find($e->products->kategoriId);
            $combine['gambar'] = $produkGambarModel->where(['prdgbrProdukId' => $e->products->id])->find();
            $e->products = array_merge((array)$e->products, $combine);
            return $e;
        }, $data);

        return $data;
    }
}
