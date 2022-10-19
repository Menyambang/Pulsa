<?php


namespace App\Libraries;

use Config\Services;

class Template
{
    private $menuFile = "Starter";
    private $renderer = null;
    private $activeUrl = "";

    public function __construct()
    {
        $this->renderer = Services::renderer();
        $this->session = \Config\Services::session();
        helper('form');
    }

    /**
     * Mengambil file menu sesuai dengan kondisi session, silakan tambahkan if dan else nya untuk mengatur file menu sesuai session
     * @return string
     */
    public function getMenuFile()
    {
        $session = Services::session();
        if ($session->has('role')) {
            $role = strtolower($session->get('role'));
            if ($role == 'superadmin') {
                $this->menuFile = "Superadmin";
            }else if($role == "admin"){
                $this->menuFile = "Admin";
            }
        }
        return $this->menuFile;
    }

    /**
     * Set URL yang sedang aktif, sehingga di tampilan menu sidebar akan ditambahkan class active
     * @param $url
     * @return $this
     */
    public function setActiveUrl($url)
    {
        $this->activeUrl = $url;
        return $this;
    }

    /**
     * Render view ke layout tampilan
     * @param string $view
     * @param array $datas
     * @param array $options
     * @return string
     */
    public function view(string $view, array $datas = [], array $options = [])
    {
        $menuClass = 'App\Menus\\' . $this->getMenuFile();
        $menu = new $menuClass();
        $datas['MENUS'] = $menu->getMenu();
        $datas['ACTIVE_URL'] = $this->activeUrl;
        $datas['session'] = $this->session->get();

        $img = base_url('assets/images/menyambang/logo_fix.png');
        $imgData = base64_encode(file_get_contents($img));

        $datas['logo'] = 'data:image/png;base64,' . $imgData;

        return view($view, $datas, $options);
    }
}
