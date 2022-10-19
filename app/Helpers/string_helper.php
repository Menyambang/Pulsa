<?php

if (!function_exists('generate_string')) {

    function generate_string($strength = 6)
    {
        $input = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}


if (!function_exists('phone_number_sensor')) {

    function phone_number_sensor($phone = '083466667777')
    {
        $jumlah_sensor = 4;
        $setelah_angka_ke = 4;

        //ambil 4 angka di tengah yan akan disensor
        $censored = mb_substr($phone, $setelah_angka_ke, $jumlah_sensor);

        //pecah kelompok angka pertama dan terakhir
        $phone2 = explode($censored, $phone);

        //gabung angka perama dan terakhir dengan angka tengah yang telah di sensor
        $phone_new = $phone2[0] . "xxxx" . $phone2[1];

        //tampilkan
        return $phone_new;
    }
}
