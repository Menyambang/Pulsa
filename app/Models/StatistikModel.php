<?php

namespace App\Models;

use App\Models\MyModel;

class StatistikModel extends MyModel
{
    public function getBulanIni($username)
    {
        $query = "SELECT 
        MONTHNAME(NOW()) AS bulan,
        COUNT(DISTINCT ckt.`cktId`) AS jumlahPesanan, 
        COUNT( DISTINCT krj.`krjProdukId`) AS jumlahProduk, 
        SUM(DISTINCT krj.`krjQuantity`) AS jumlahProdukPcs,
        COALESCE(SUM(DISTINCT IF(cktdt.`cktdtKeterangan` = 'Subtotal produk', cktdt.`cktdtBiaya`,0)),0) jumlahPesananRp
        
        FROM `t_checkout` ckt
        JOIN `t_keranjang` krj ON krj.`krjCheckoutId` = ckt.`cktId`
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        JOIN `t_checkout_detail` cktdt ON cktdt.`cktdtCheckoutId` = ckt.`cktId`
        JOIN `m_user_alamat` ual ON ual.`usralId` = ckt.`cktAlamatId`
        
        
        WHERE ckt.`cktStatus` = 'selesai'
        AND ual.`usralUsrEmail` = ".$this->db->escape($username)."
        AND MONTH(ckt.`cktCreatedAt`) = MONTH(NOW())
        GROUP BY ckt.`cktId`, cktdt.`cktdtCheckoutId`
        
        ";
        
        $data = $this->db->query($query)->getRow();

        if(empty($data)){
            return [
                'bulan' => '0',
                'jumlahPesanan' => '0',
                'jumlahProduk' => '0',
                'jumlahProdukPcs' => '0',
                'jumlahPesananRp' => '0',
            ];
        }

        return $data;
    }

    public function getTahunIni($username)
    {
        $query = "SELECT 
            YEAR(NOW()) AS tahun,
            SUM(total.jumlahProduk) AS jumlahProduk,
            SUM(total.jumlahProdukPcs) AS jumlahProdukPcs,
            COUNT(DISTINCT ckt.`cktId`) AS jumlahPesanan, 
            SUM(cktdt.`cktdtBiaya`) jumlahPesananRp
            
            FROM `t_checkout` ckt
            JOIN `t_checkout_detail` cktdt ON cktdt.`cktdtCheckoutId` = ckt.`cktId`
            JOIN (
                SELECT  krj.krjCheckoutId,
                COUNT(krj.`krjProdukId`) AS jumlahProduk,
                SUM(krj.`krjQuantity`) AS jumlahProdukPcs
                FROM `t_keranjang`  krj
                JOIN `m_produk` prd ON krj.`krjProdukId` = prd.`produkId`
                AND krj.`krjUserEmail` = ".$this->db->escape($username)."

                GROUP BY krjCheckoutId
            ) AS total ON total.krjCheckoutId = ckt.`cktId`
        
            WHERE ckt.`cktStatus` = 'selesai'
            AND YEAR(ckt.`cktCreatedAt`) = YEAR(NOW())
            GROUP BY  tahun
        ";
        
        $data = $this->db->query($query)->getRow();

        if(empty($data)){
            return [
                'tahun' => '0',
                'jumlahPesanan' => '0',
                'jumlahProduk' => '0',
                'jumlahProdukPcs' => '0',
                'jumlahPesananRp' => '0',
            ];
        }

        return $data;
    }


    public function getPesananPerBulan($username)
    {
        $query = "SELECT 
        CONCAT(MONTHNAME(ckt.`cktCreatedAt`), ' ', YEAR(ckt.`cktCreatedAt`)) judul,
        SUM(krj.`krjQuantity`) AS jumlahProdukPcs,
        SUM(DISTINCT cktdt.`cktdtBiaya`) jumlahPesananRp
        
        FROM `t_checkout` ckt
        JOIN `t_keranjang` krj ON krj.`krjCheckoutId` = ckt.`cktId`
        JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
        JOIN `t_checkout_detail` cktdt ON cktdt.`cktdtCheckoutId` = ckt.`cktId`
        
        
        WHERE ckt.`cktStatus` = 'selesai'
        AND cktdt.`cktdtKeterangan` = 'Subtotal produk'
        AND krj.`krjUserEmail` = ".$this->db->escape($username)."
        
        GROUP BY judul, cktId
        ORDER BY ckt.`cktCreatedAt` DESC
        ";
        
        return $this->db->query($query)->getResult() ;
    }

    public function getPesananTopProduk($username)
    {
        $query = 
            "SELECT
                prd.`produkId` AS id,
                prd.`produkNama` AS nama,
                SUM(krj.`krjQuantity`) AS jumlahProdukPcs,
                SUM(krj.`krjQuantity` * prd.`produkHarga`) jumlahPesananRp,
                'gambar',
                JSON_EXTRACT(gambar.gambar, '$') gambar
            FROM
                `t_checkout` ckt
                JOIN `t_keranjang` krj ON krj.`krjCheckoutId` = ckt.`cktId`
                JOIN `m_produk` prd ON prd.`produkId` = krj.`krjProdukId`
                LEFT JOIN (
                    (
                        SELECT
                            *,
                            JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'id',
                                    prdgbrId,
                                    'produkId',
                                    prdgbrProdukId,
                                    'isThumbnail',
                                    prdgbrIsThumbnail,
                                    'file',
                                    prdgbrFile,
                                    'createdAt',
                                    prdgbrCreatedAt,
                                    'updatedAt',
                                    prdgbrUpdatedAt,
                                    'deletedAt',
                                    prdgbrDeletedAt
                                )
                            ) AS gambar
                        FROM
                            t_produk_gambar
                        GROUP BY
                            prdgbrProdukId
                    )
                ) gambar ON prdgbrProdukId = produkId
            WHERE
                ckt.`cktStatus` = 'selesai'
                AND krj.`krjUserEmail` = ".$this->db->escape($username)."
            GROUP BY
                krj.`krjProdukId`
        ";
        
        $data = $this->db->query($query)->getResult();

        foreach ($data as $key => $value) {
            $data[$key]->gambar = json_decode($value->gambar);
            $gambarThumbnail = '';
            foreach ($data[$key]->gambar as $gambar) {
                if($gambar->isThumbnail == 1){
                    $gambarThumbnail = $gambar;
                    break;
                }

                $gambarThumbnail = $gambar;
            }

            $data[$key]->gambar = $gambarThumbnail;
        }

        return $data;
    }
}
