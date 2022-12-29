<?php

// $route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
// $route->resource("produk_beranda_trans", ['controller' => 'Api\ProdukBerandaTrans', 'only' => ['index', 'show']]);
// $route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
// $route->group("produks", function ($route) {
    //     $route->get("rekomendasi", 'Api\Produk::rekomendasi');
    // });
    
$route->resource("kategori", ['controller' => 'Api\Kategori', 'only' => ['index', 'show']]);
$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Setting', 'only' => ['index', 'show']]);
$route->resource("menu", ['controller' => 'Api\Menu', 'only' => ['index', 'show']]);
$route->resource("runningText", ['controller' => 'Api\Menu', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Menu', 'only' => ['index', 'show']]);
// $route->resource("service_center", ['controller' => 'Api\ServiceCenter', 'only' => ['index', 'show']]);
// $route->resource("metode_pembayaran", ['controller' => 'Api\MetodePembayaran', 'only' => ['index', 'show']]);

$route->group("background", function ($route) {
    $route->put("pembayaran_to_expired", 'BackgroundProcess::pembayaranToExpired');
});

require 'Irs.php';

// TEST EMAIL
$route->resource("user/test_email", ['controller' => 'Api\User::TestEmail']);