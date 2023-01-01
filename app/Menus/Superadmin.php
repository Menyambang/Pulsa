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
            // [
            //     'title' => 'Menu Aplikasi',
            //     'url' => 'MenuAplikasi',
            //     'icon' => 'menu',
            // ],
            // [
            //     'title' => 'Kategori',
            //     'url' => 'Kategori',
            //     'icon' => 'list',
            // ],
            // [
            //     'title' => 'Banner',
            //     'url' => 'Banner',
            //     'icon' => 'airplay',
            // ],
            // [
            //     'title' => 'Running Text',
            //     'url' => 'RunningText',
            //     'icon' => 'wind',
            // ],
            [
                    'title' => 'User',
                    'url' => 'UserWeb',
                    'icon' => 'user',
                    
                ],
                // [
                //     'title' => 'Pengaturan',
                //     'url' => '#',
                //     'icon' => 'settings',
                //     'children' => [
                //         [
                //             'title' => 'Aplikasi',
                //             'url' => 'Pengaturan'
                //         ],
                //     ]
                // ],
        ];
    }
}
