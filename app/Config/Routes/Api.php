<?php

$route->post("user/register", 'Api\User::register');
$route->post("user/reset_password", 'Api\User::resetPassword');
$route->post("user/resend_otp_code", 'Api\User::resendOtpCode');
$route->post("user/verifikasi_otp_code", 'Api\User::verifikasiOtpCode');

// $route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
// $route->resource("produk_beranda_trans", ['controller' => 'Api\ProdukBerandaTrans', 'only' => ['index', 'show']]);
// $route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
// $route->group("produks", function ($route) {
    //     $route->get("rekomendasi", 'Api\Produk::rekomendasi');
    // });
    
$route->resource("kategori", ['controller' => 'Api\Kategori', 'only' => ['index', 'show']]);
$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Setting', 'only' => ['index', 'show']]);
// $route->resource("service_center", ['controller' => 'Api\ServiceCenter', 'only' => ['index', 'show']]);
// $route->resource("metode_pembayaran", ['controller' => 'Api\MetodePembayaran', 'only' => ['index', 'show']]);

$route->group("background", function ($route) {
    $route->put("pembayaran_to_expired", 'BackgroundProcess::pembayaranToExpired');
});

$route->group("irs", function ($route) {
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
});

// TEST EMAIL
$route->resource("user/test_email", ['controller' => 'Api\User::TestEmail']);