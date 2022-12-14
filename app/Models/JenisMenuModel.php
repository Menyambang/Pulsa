<?php namespace App\Models;

use App\Models\MyModel;

class JenisMenuModel extends MyModel
{
    protected $table = "r_jenis_menu";
    protected $primaryKey = "jnmId";
    protected $createdField = "jnmCreatedAt";
    protected $updatedField = "jnmUpdatedAt";
    protected $returnType = "App\Entities\JenisMenu";
    protected $allowedFields = ["jnmLabel","jnsDeletedAt"];

	protected $deletedField = 'jnsDeletedAt';
    protected $useSoftDeletes = true;

    public function getReturnType()
    {
        return $this->returnType;
    }
    
    public function getPrimaryKeyName(){
        return $this->primaryKey;
    }

    public function selectMenu(){
        $data = $this->findAll();

        $select= [];
        foreach ($data as $key => $value) {
            $select[$value->jnmId] = $value->jnmLabel;
        }

        return $select;
    }
}