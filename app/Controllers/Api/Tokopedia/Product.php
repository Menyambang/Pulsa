<?php namespace App\Controllers\Api\Tokopedia;

use App\Controllers\Api\Tokopedia\MyResourceTokopedia;

class Product extends MyResourceTokopedia
{
    public function getProduct()
    {
        if ($this->validate([
            'categoryId' => 'required',
        ])) {
            $categoryId = $this->request->getPost('categoryId');
    
            $response = $this->tokpedApi->getProduct($categoryId);
    
            return $this->response($response);
        } else {
            return $this->response(null, 400, $this->validator->getErrors());
        }
    }

}
