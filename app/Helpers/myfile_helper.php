<?php
if (!function_exists('rename2')) {

    function rename2($origin,$destination){
        if ( copy($origin, $destination) ) {
            unlink($origin);
            return true;
        }
        return false;
    }

}