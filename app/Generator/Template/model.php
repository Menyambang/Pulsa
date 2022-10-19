<?php

/**
 * @var $tablename
 * @var $filename
 * @var $primaryKey
 * @var $allowedFields
 * @var $createdAt
 * @var $updatedAt
 */
echo "<?php namespace App\Models;\n\n";
echo "use App\Models\MyModel;\n\n";

echo 'class ' . $filename . 'Model extends MyModel
{
    protected $table = "' . $tablename . '";
    protected $primaryKey = "' . $primaryKey . '";
    protected $createdField = "' . $createdAt . '";
    protected $updatedField = "' . $updatedAt . '";
    protected $returnType = "App\Entities\\' . $filename . '";
    protected $allowedFields = ["' . implode('","', $allowedFields) . '"];

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }
}';
