<?php namespace App\Controllers;

use CodeIgniter\Config\Config;
use App\Controllers\MyResourceController;
use App\Entities\UserWeb as EntitiesUserWeb;

/**
 * Class UserWeb
 * @note Resource untuk mengelola data m_user_web
 * @dataDescription m_user_web
 * @package App\Controllers
 */
class UserWeb extends BaseController
{
    protected $modelName = 'App\Models\UserWebModel';
    protected $format    = 'json';

    protected $rules = [
       'username' => ['label' => 'Username', 'rules' => 'required'],
       'nama' => ['label' => 'Nama', 'rules' => 'required'],
       'role' => ['label' => 'Role', 'rules' => 'required'],
       'password' => ['label' => 'Password', 'rules' => 'required'],
   ];

    public function index()
    {
        $data = [
            'role' => [
                'admin' => 'Admin',
                'superadmin' => 'Superadmin',
            ]
        ];
        return $this->template->setActiveUrl('UserWeb')
            ->view("UserWeb/index", $data);
    }

   public function simpan($primary = '')
   {    
        $entiti  = new EntitiesUserWeb();
        $post = $this->request->getVar();
        if($post['password']) $post['password'] = $entiti->hashPassword($post['password']);
        $this->request->setGlobal("request", $post);
       return parent::simpan($primary);
   }
}
