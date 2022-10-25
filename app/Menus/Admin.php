<?php

namespace App\Menus;


class Admin implements MenuInterface
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
                'icon' => 'menu',
            ],
            [
                'title' => 'Kategori',
                'url' => 'Kategori',
                'icon' => 'list',
            ],
            [
                'title' => 'Banner',
                'url' => 'Banner',
                'icon' => 'airplay',
            ],
            [
                'title' => 'Running Text',
                'url' => 'RunningText',
                'icon' => 'wind',
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
