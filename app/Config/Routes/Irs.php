<?php

$route->group("irs", function ($route) {

    // V8
    $route->group("v8", function ($route) {
        $route->group("auth", ['filter' => 'apiFilter'], function ($route) {
            $route->post("/", 'Api\IRSAvianaV8\Auth::auth');
        });
        $route->group("global", ['filter' => 'apiFilter'], function ($route) {
            $route->get("(:segment)", 'Api\IRSAvianaV8\Global::get/$1');
            $route->post("(:segment)", 'Api\IRSAvianaV8\Global::post/$1');
        });
        $route->group("user", ['filter' => 'apiFilter'], function ($route) {
            $route->get("profile", 'Api\IRSAvianaV8\User::getProfile');
            $route->post("cekPin", 'Api\IRSAvianaV8\User::cekPin');
            $route->post("changePin", 'Api\IRSAvianaV8\User::changePin');
        });
        $route->group("lokasi", function ($route) {
            $route->get("provinsi", 'Api\IRSAvianaV8\Lokasi::getProvinsi');
            $route->get("cities/(:segment)", 'Api\IRSAvianaV8\Lokasi::getCities/$1');
            $route->get("districts/(:segment)", 'Api\IRSAvianaV8\Lokasi::getDistrict/$1');
        });
        $route->group("product", ['filter' => 'apiFilter'], function ($route) {
            $route->get("games", 'Api\IRSAvianaV8\Product::getGames');
            $route->post("byCategory", 'Api\IRSAvianaV8\Product::getByCategory');
            $route->get("pdam", 'Api\IRSAvianaV8\Product::getPDAM');
            $route->get("fisik", 'Api\IRSAvianaV8\Product::getFisik');
            $route->post("operator", 'Api\IRSAvianaV8\Product::getOperator');
            $route->post("operatorTujuan", 'Api\IRSAvianaV8\Product::getOperatorTujuan');
            $route->get("priceList", 'Api\IRSAvianaV8\Product::getPriceList');
            $route->post("byDenom", 'Api\IRSAvianaV8\Product::getByDenom');
            $route->post("reward", 'Api\IRSAvianaV8\Product::getReward');
        });
        $route->group("transaksi", ['filter' => 'apiFilter'], function ($route) {
            $route->post("pay", 'Api\IRSAvianaV8\Transaksi::pay');
            $route->post("reedem", 'Api\IRSAvianaV8\Transaksi::reedem');
            $route->post("cetakStruk", 'Api\IRSAvianaV8\Transaksi::cetakStruk');
        });
        $route->group("histori", ['filter' => 'apiFilter'], function ($route) {
            $route->post("deposit", 'Api\IRSAvianaV8\Histori::deposit');
            $route->post("mutasi", 'Api\IRSAvianaV8\Histori::mutasi');
            $route->post("transaksi", 'Api\IRSAvianaV8\Histori::transaksi');
            $route->post("transaksifisik", 'Api\IRSAvianaV8\Histori::transaksifisik');
            $route->post("rewards", 'Api\IRSAvianaV8\Histori::rewards');
            $route->post("transfer", 'Api\IRSAvianaV8\Histori::transfer');
        });
        $route->group("ticket", ['filter' => 'apiFilter'], function ($route) {
            $route->post("deposit", 'Api\IRSAvianaV8\Ticket::deposit');
            $route->post("transfer", 'Api\IRSAvianaV8\Ticket::transfer');
            $route->post("rekening", 'Api\IRSAvianaV8\Ticket::rekening');
        });
    });

    // V9
    $route->group("v9", function ($route) {
        $route->group("user", ['filter' => 'apiFilter'], function ($route) {
            $route->post("changePin", 'Api\IRSAvianaV9\User::changePin');
        });
        $route->group("histori", ['filter' => 'apiFilter'], function ($route) {
            $route->post("rekapTrx", 'Api\IRSAvianaV9\Histori::rekapTrx');
            $route->post("saldo", 'Api\IRSAvianaV9\Histori::saldo');
            $route->post("transaksi", 'Api\IRSAvianaV9\Histori::transaksi');
            $route->post("transfer", 'Api\IRSAvianaV9\Histori::transfer');
            $route->post("topup", 'Api\IRSAvianaV9\Histori::topup');
            $route->post("cetak", 'Api\IRSAvianaV9\Histori::cetak');
        });
    });
});
