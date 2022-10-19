<?php


namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class MyModel extends Model
{
    protected $hasAddedInJoin = [];

    public function update($id = null, $data = null): bool
    {
        $builder = $this->builder();
        if (empty($builder->getCompiledQBWhere()) && $id === null) {
            if (CI_DEBUG) {
                throw new DatabaseException('Update are not allowed unless they contain a "where" or "like" clause.');
            }
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        return parent::update($id, $data);
    }
    /**
     * @note Menangani request dari datatable dan mengembalikan response sesuai struktur data yang diperlukan datatable
     * @param $datatableParams
     * @return array
     */
    public function dataTableHandler($datatableParams)
    {
        $draw = (int) $datatableParams['draw'];
        $columns = $datatableParams['columns'];
        $search = $datatableParams['search'];
        $entityClass = $this->getReturnType();
        $entity = new $entityClass();
        $order = [];
        $debut = [];
        $entitiyList = [];

        // $this->select($this->table . ".*");

        if (isset($datatableParams['with'])) {
            $this->with($datatableParams['with']);
        }

        foreach ($datatableParams['order'] as $colOrder) {
            if ($columns[$colOrder['column']]['orderable'] == 'true') {
                $columnExplode = explode(".", $columns[$colOrder['column']]['data']);
                if (count($columnExplode) > 1) {
                    if (!isset($entitiyList[$columnExplode[0]])) {
                        $entityClass = $this->getReturnTypeOfRelation($columnExplode[0]);
                        $entitiyList[$columnExplode[0]] = new $entityClass();
                    }
                    $datamap = $entitiyList[$columnExplode[0]]->getDatamap();
                    $field = isset($datamap[$columnExplode[1]]) ? $columnExplode[0] . "." . $datamap[$columnExplode[1]] :
                        $columns[$colOrder['column']]['data'];
                } else {
                    $field = $entity->getFieldNameOfMap($columns[$colOrder['column']]['data']);
                }
                $order[$field] = $colOrder['dir'];
            }
        }
        if ($search['value'] != "") {
            $this->groupStart();
        }
        foreach ($columns as $col) {
            $columnExplode = explode(".", $col['data']);
            if (count($columnExplode) > 1) {
                if (!isset($entitiyList[$columnExplode[0]])) {
                    $entityClass = $this->getReturnTypeOfRelation($columnExplode[0]);
                    $entitiyList[$columnExplode[0]] = new $entityClass();
                }
                $datamap = $entitiyList[$columnExplode[0]]->getDatamap();
                $field = isset($datamap[$columnExplode[1]]) ? $columnExplode[0] . "." . $datamap[$columnExplode[1]] :
                    $col['data'];
            } else {
                $field = $entity->getFieldNameOfMap($col['data']);
            }
            $debug[] = $field;
            if ($col['searchable'] && $search['value'] != "" && $field != null) {
                $this->orLike($field, $search['value']);
            }
            if (isset($order[$field]) && $field != '' && $field != null) {
                $this->orderBy($field, $order[$field]);
            }
        }
        if ($search['value'] != "") {
            $this->groupEnd();
        }


        $recordsTotal = $this->countAllResults(false);
        $recordsFiltered = $recordsTotal;
        $this->limit($datatableParams['length']);
        $this->offset($datatableParams['start']);

        $data = $this->find();
        return [
            'code' => 200,
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'debug' => $debug,
            'query' => $this->getLastQuery()->getQuery(),
        ];
    }

    protected function relationships()
    {
        return [];
    }

    public function with($relationName)
    {
        $relations = $this->relationships();
        if(count($this->hasAddedInJoin) == 0){
            $this->select($this->table.".*");
        }
        foreach ($relationName as $rel) {
            if (isset($relations[$rel]) && !in_array($rel,$this->hasAddedInJoin)) {
                $relation = $relations[$rel];
                $type = isset($relation['type']) ? $relation['type'] : "";
                $this->join($relation['table'] . " " . $rel, $relation['condition'], $type);
                if(isset($relation['field_alias'])){
                    $this->select("$relation[field_alias] as $rel");
                } else if (isset($relation['entity'])) {
                    $entity = new $relation['entity']();
                    $select = [];
                    $fieldMap = $entity->getDatamap();
                    if(isset($relation['only']) && count($relation['only']) > 0){
                        $fieldMap = array_intersect($fieldMap,$relation['only']);
                    }
                    foreach($fieldMap as $alias=>$field){
                        $select[] =  "'$alias',{$rel}.{$field}";
                    }
                    $this->select("JSON_OBJECT(".implode(",",$select).") as $rel");
                }
            }
            $this->hasAddedInJoin[] = $rel;
        }
        return $this;
    }

    public function getReturnTypeOfRelation($rel)
    {
        $relations = $this->relationships();
        return (isset($relations[$rel]['entity'])) ? $relations[$rel]['entity'] : null;
    }

    /**
     * @note mengambil nama table
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * @note mengambil jenis entity kembalian
     * @return string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @note Mengambil nama primary key table
     * @return string
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKey;
    }

    
    public function setEntity($newEntity){
        $this->tempReturnType = $newEntity;
        return $this;
    }
    
    // protected function hasMany($tableName,$relations,$entity,$alias,$key,$type ="left"){
    //     $entityInstance = new $entity;
    //     $jsonEntity = [];
    //     $primaryId = '';
    //     $i = 0;
    //     foreach($entityInstance->getDatamap(true) as $name=>$field){

    //         if(empty($field)) continue;
    //         if($i == 0) $primaryId = $field;
    //         $jsonEntity[] = "'$name',$field";
    //         $i++;
    //     }
    //     if(count($this->hasAddedInJoin) == 0){
    //         // $this->select($this->getTableName().".*");
    //     }else{
    //         $this->hasAddedInJoin[] = $tableName;
    //     }
    //     $this->select("IF($primaryId IS NOT NULL, CONCAT('[', GROUP_CONCAT(JSON_OBJECT(".implode(",",$jsonEntity).")), ']'), '[]') as $alias")
    //     ->join($tableName,$relations,$type);
    //     $this->groupBy($this->table.".".$this->primaryKey);

    //     return $this;
    // }

    /**
     * Mysql JSON_OBJECT value
     *
     * @param [type] $entity
     * @return void
     */
    protected function entityToMysqlObject($entity){
        $entityInstance = new $entity;
        $jsonEntity = [];
        foreach($entityInstance->getDatamap(true) as $name=>$field){
            $jsonEntity[] = "'$name',$field";
        }

        return implode(",",$jsonEntity);
    }
    
    /**
     * Many Array of object Relation
     *
     * @param string $table
     * @param class $entity
     * @param string $condition
     * @param string $alias
     * @param string $group
     * @param string $type
     * @param function ...$callable
     * @return array
     */
    protected function hasMany($table, $entity, $condition, $alias, $group = null, $type = 'LEFT', ...$callable){
        return $this->_templateRelationships(false, $table, $entity, $condition, $alias, $group, $type, ...$callable);
    }

    /**
     * One Object Relation
     *
     * @param string $table
     * @param class $entity
     * @param string $condition
     * @param string $alias
     * @param string $group
     * @param string $type
     * @param function ...$callable
     * @return array
     */
    protected function belongsTo($table, $entity, $condition, $alias, $group = null, $type = 'LEFT', ...$callable){
        return $this->_templateRelationships(true, $table, $entity, $condition, $alias, $group, $type, ...$callable);
    }

    private function _templateRelationships($asObject = true, $table, $entity, $condition, $alias, $group = null, $type = 'LEFT', ...$callable){
        $callJoin = [];
        $callEntity = [];
        $callSeparator = '';
        $asObject = $asObject ? '' : 'JSON_ARRAYAGG';

        foreach ($callable as  $callbacks) {
            if (is_callable($callbacks))
            {
                $callbacksData = $callbacks($this);

                // Not Return callback
                if(empty($callbacksData)) continue;
             
                $callAlias = $callbacksData['field_alias'];
                $callCondition = $callbacksData['condition'];
                $callType = $callbacksData['type'];
                $callJoin[] = "$callType JOIN ($callbacksData[table]) $callAlias ON $callCondition";
                $callEntity[] = "'$callAlias', JSON_EXTRACT($callAlias.$callAlias,'$')";
                $callSeparator = ', ';
            }
        }

        // Group Data
        $hasGroup = !empty($group) ? "GROUP BY $group" : '';

        // Insided Query Table
        $query = "SELECT *,
            $asObject(JSON_OBJECT(" . $this->entityToMysqlObject($entity) . $callSeparator . implode(', ', $callEntity) . ")) AS ".$alias."
            FROM ".$table." 
            ".implode(' ', $callJoin)." 
            ".$hasGroup;

        // Relationships format
        return ['table' => "({$query})", 'condition' => $condition, 'field_alias' => $alias, 'entity' => $entity, 'type' => $type];
    }
}
