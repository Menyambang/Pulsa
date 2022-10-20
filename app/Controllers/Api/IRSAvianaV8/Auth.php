<?php

namespace App\Controllers\Api\IRSAvianaV8;

use App\Controllers\MyResourceController;

class Auth extends MyResourceController
{
    public function auth()
    {
        if ($this->validate([
            'phone' => 'required',
        ], $this->validationMessage)) {
            $phone = $this->request->getPost('phone');

            $response = $this->irs->auth($phone);

            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

}
