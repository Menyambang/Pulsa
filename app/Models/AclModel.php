<?php

namespace App\Models;

use Config\Services;
use CodeIgniter\Model;

class AclModel extends Model
{
    const CREATE = 0;
    const READ = 1;
    const UPDATE = 2;
    const DELETE = 3;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    /**
     * ACL C,R,U,D
     *
     * @return void
     */
    public function getAcl()
    {
        $acl = [
            'ADMIN' => [
                'Beranda' => [0, 1, 0, 0],
                'Produk' => [0, 1, 0, 0],
                'ProdukBeranda' => [0, 1, 0, 0],
                'Kategori' => [0, 1, 0, 0],
                'Banner' => [0, 1, 0, 0],
                'TransaksiTopUpSaldo' => [0, 1, 0, 0],
                'TransaksiPembelianProduk' => [0, 1, 0, 0],
                'User' => [0, 1, 0, 0],
                'Broadcast' => [0, 1, 0, 0],
                'LokasiCod' => [0, 1, 0, 0],
            ],
        ];

        return  $acl;
    }

    /**
     * 0 = CREATE
     * 1 = READ
     * 2 = UPDATE
     * 3 = DELETE
     *
     * @param int $number
     *
     * @return void
     */
    private function baseACL($number = self::CREATE)
    {
        $controllerName = Services::router()->controllerName();
        $controllerName = explode("\\", $controllerName);
        $currentFolder = end($controllerName);

        $list = $this->getAcl();
        $role = $this->session->get('role');

        // BREAK
        if($role == 'superadmin') return null;

        $acl = $list[strtoupper($role)];
        $acl = $acl[$currentFolder];

        $text = '';
        switch ($number) {
            case self::DELETE:
                $text = 'menghapus';
                break;

            case self::UPDATE:
                $text = 'mengubah';
                break;

            case self::READ:
                $text = 'melihat';
                break;

            default:
                $text = 'menambah';
                break;
        }

        if (!$acl[$number]) {
            return [
                'code' => 403,
                'message' => 'Anda tidak memiliki akses untuk ' . $text,
                'role' => $role,
            ];
        }

        return null;
    }

    public function isCreate()
    {
        return $this->baseACL(self::CREATE);
    }

    public function isRead()
    {
        return $this->baseACL(self::READ);
    }

    public function isUpdate()
    {
        return $this->baseACL(self::UPDATE);
    }

    public function isDelete()
    {
        return $this->baseACL(self::DELETE);
    }
}
