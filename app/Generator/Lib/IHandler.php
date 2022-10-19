<?php


namespace App\Generator\Lib;


interface IHandler
{
    public function generate($arguments,$tableDescription,$prefixCount);
}