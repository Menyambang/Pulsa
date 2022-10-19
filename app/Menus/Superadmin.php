<?php

namespace App\Menus;


class Superadmin implements MenuInterface
{

    public function getMenu()
    {
        return [
            [
                'title' => 'Menu',
                'class' => 'sidebar-main-title',
            ],
            [
                'title' => 'Beranda',
                'url' => 'Beranda',
                'icon' => 'home',
            ],
            [
                'title' => 'Banner',
                'url' => 'Banner',
                'icon' => 'monitor',
            ],
            [
                'title' => 'Produk Belanja',
                'url' => '#',
                'icon' => 'shopping-bag',
                'children' => [
                    [
                        'title' => 'Kategori',
                        'url' => 'Kategori'
                    ],
                    [
                        'title' => 'Produk',
                        'url' => 'Produk'
                    ],
                    [
                        'title' => 'Produk Beranda',
                        'url' => 'ProdukBeranda'
                    ],
                ]
            ],
            [
                'title' => 'Produk Digital',
                'url' => '#',
                'icon' => 'box',
                'children' => [
                    [
                        'title' => 'Menu',
                        'url' => 'MenuDigital'
                    ],
                    [
                        'title' => 'Kategori',
                        'url' => 'KategoriPulsa'
                    ],
                    [
                        'title' => 'Produk',
                        'url' => 'ProdukPulsa'
                    ],
                ]
            ],
            [
                    'title' => 'User',
                    'url' => '#',
                    'icon' => 'user',
                    'children' => [
                        [
                            'title' => 'User Aplikasi Web',
                            'url' => 'UserWeb'
                        ],
                        [
                            'title' => 'User Terdaftar',
                            'url' => 'User'
                        ],
                    ]
                ],
                [
                    'title' => 'Transaksi',
                    'url' => '#',
                    'icon' => 'credit-card',
                    'children' => [
                        [
                            'title' => 'Top Up Saldo',
                            'url' => 'TransaksiTopUpSaldo'
                        ],
                        [
                            'title' => 'Pembelian Produk',
                            'url' => 'TransaksiPembelianProduk'
                        ],
                    ]
                ],
                [
                    'title' => 'Broadcast',
                    'url' => 'Broadcast',
                    'icon' => 'volume-2',
                ],
                [
                    'title' => 'Service Center',
                    'url' => 'ServiceCenter',
                    'icon' => 'phone',
                ],
                [
                    'title' => 'Lokasi COD',
                    'url' => 'LokasiCod',
                    'icon' => 'shopping-bag',
                ],
                [
                    'title' => 'Pengaturan',
                    'url' => '#',
                    'icon' => 'settings',
                    'children' => [
                        [
                            'title' => 'No Rekening',
                            'url' => 'NoRekening'
                        ],
                        [
                            'title' => 'Lainnya',
                            'url' => 'Pengaturan'
                        ],
                    ]
                ],
        ];
    }
}
