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
                'title' => 'Menu Aplikasi',
                'url' => 'MenuAplikasi',
                'icon' => 'monitor',
            ],
            [
                'title' => 'Kategori',
                'url' => 'Kategori',
                'icon' => 'monitor',
            ],
            [
                'title' => 'Banner',
                'url' => 'Banner',
                'icon' => 'monitor',
            ],
            [
                'title' => 'Running Text',
                'url' => 'RunningText',
                'icon' => 'monitor',
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
                    'title' => 'Pengaturan',
                    'url' => '#',
                    'icon' => 'settings',
                    'children' => [
                        [
                            'title' => 'Aplikasi',
                            'url' => 'Pengaturan'
                        ],
                    ]
                ],
        ];
    }
}
