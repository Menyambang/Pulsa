<?php
namespace App\Menus;

interface MenuInterface
{
    /**
     * Menu dalam array dengan format
     * [['title'=>'','url'=>'','icon'=>'',isHide=>'',children=>[]]]
     * @return array
     */
    public function getMenu();
}