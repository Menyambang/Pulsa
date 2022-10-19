<?php

namespace App\Filters;

use Config\Services;
use App\Models\AclModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
    {
        $session = \Config\Services::session();

        $controllerName = Services::router()->controllerName();
        $controllerName = explode("\\", $controllerName);
        $currentFolder = $controllerName[count($controllerName) - 1];

        $role = $session->get('role');
        $role = strtoupper($role);

        $aclModel = new AclModel();
        $list = $aclModel->getAcl();
   
        if(!empty($role)){
            if($role != 'SUPERADMIN'){
                $accessRole = array_keys($list[$role]);
        
                if (!in_array($currentFolder, $accessRole)) {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}
