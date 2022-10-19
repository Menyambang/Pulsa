<?php


namespace App\Entities;


use CodeIgniter\Entity;

class MyEntity extends Entity
{
    protected $show = [];
    /**
     * General method that will return all public and protected
     * values of this entity as an array. All values are accessed
     * through the __get() magic method so will have any casts, etc
     * applied to them.
     *
     * @param boolean $onlyChanged If true, only return values that have changed since object creation
     * @param boolean $cast        If true, properties will be casted.
     *
     * @return array
     * @throws \Exception
     */
    public function toArray(bool $onlyChanged = false, bool $cast = true, bool $recursive = false): array
    {
        $array = parent::toArray($onlyChanged, $cast);
        $diff = array_diff_key($this->datamap, $array);
        if (count($diff) > 0) {
            foreach ($diff as $from => $to) {
                $array[$from] = $this->__get($to);
            }
        }
        if (count($this->show) > 0)
            return array_filter($array, function ($k) {
                return in_array($k, $this->show);
            }, ARRAY_FILTER_USE_KEY); 
        return $array;
    }

    public function getFieldNameOfMap($mapname)
    {
        return (isset($this->datamap[$mapname]) ? $this->datamap[$mapname] : null);
    }

    public function getDatamap()
    {
        return $this->datamap;
    }
}
