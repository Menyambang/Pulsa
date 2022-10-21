<?php

$route->post("user/register", 'Api\User::register');
$route->post("user/reset_password", 'Api\User::resetPassword');
$route->post("user/resend_otp_code", 'Api\User::resendOtpCode');
$route->post("user/verifikasi_otp_code", 'Api\User::verifikasiOtpCode');

$route->resource("kategori", ['controller' => 'Api\Kategori', 'only' => ['index', 'show']]);
$route->resource("produk_beranda", ['controller' => 'Api\ProdukBeranda', 'only' => ['index', 'show']]);
$route->resource("produk_beranda_trans", ['controller' => 'Api\ProdukBerandaTrans', 'only' => ['index', 'show']]);
$route->resource("produk", ['controller' => 'Api\Produk', 'only' => ['index', 'show']]);
$route->group("produks", function ($route) {
    $route->get("rekomendasi", 'Api\Produk::rekomendasi');
});

$route->resource("banner", ['controller' => 'Api\Banner', 'only' => ['index', 'show']]);
$route->resource("service_center", ['controller' => 'Api\ServiceCenter', 'only' => ['index', 'show']]);
$route->resource("setting", ['controller' => 'Api\Setting', 'only' => ['index', 'show']]);
$route->resource("metode_pembayaran", ['controller' => 'Api\MetodePembayaran', 'only' => ['index', 'show']]);

$route->group("raja_ongkir", function ($route) {
    $route->get("kota", 'Api\RajaOngkir::getKota');
    $route->get("provinsi", 'Api\RajaOngkir::getProvinsi');
    $route->get("kecamatan", 'Api\RajaOngkir::getKecamatan');
    $route->get("ongkir", 'Api\RajaOngkir::getOngkir', ['filter' => 'apiFilter']);
    $route->get("status_perjalanan/(:segment)", 'Api\RajaOngkir::getStatusPerjalanan/$1', ['filter' => 'apiFilter']);
});

$route->group("background", function ($route) {
    $route->put("pembayaran_to_expired", 'BackgroundProcess::pembayaranToExpired');
});

$route->group("tokopedia", function ($route) {
    $route->group("auth", function ($route) {

        $route->post("/", 'Api\Tokopedia\Auth::auth');
        $route->post("sendOTP", 'Api\Tokopedia\Auth::sendOTP');
        $route->put("refresh", 'Api\Tokopedia\Auth::refresh');

        $route->group("isAuth", ['filter' => 'apiFilter'],  function ($route) {
            $route->get("/", 'Api\Tokopedia\Auth::isAuth');
        });
    });

    $route->group("user", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("cekVaNumber", 'Api\Tokopedia\User::cekVaNumber');
        $route->get("cekSaldoMitra", 'Api\Tokopedia\User::cekSaldoMitra');
        $route->get("cekAkun", 'Api\Tokopedia\User::cekAkun');
    });

    $route->group("payment", ['filter' => 'apiFilter'],  function ($route) {
        $route->post("beliPulsa", 'Api\Tokopedia\Payment::beliPulsa');
    });

    $route->group("transaksi", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("active", 'Api\Tokopedia\Transaksi::getTransactionList');
        $route->get("waiting", 'Api\Tokopedia\Transaksi::getTransactionWaitingList');
    });

    $route->group("product",  function ($route) {
        $route->post("/", 'Api\Tokopedia\Product::getProduct');
    });
});

$route->group("irs", function ($route) {
    $route->group("v8", function ($route) {
        $route->group("auth", ['filter' => 'apiFilter'], function ($route) {
            $route->post("/", 'Api\IRSAvianaV8\Auth::auth');
        });
        $route->group("user", ['filter' => 'apiFilter'], function ($route) {
            $route->get("/", 'Api\IRSAvianaV8\User::getProfile');
        });
    });
});

$route->group("pulsa_bridge", function ($route) {
    $route->get("/", 'Api\PulsaBridge::index');
    $route->post("xml", 'Api\PulsaBridge::xml');
});

// TEST EMAIL
$route->resource("user/test_email", ['controller' => 'Api\User::TestEmail']);

$route->group("pulsa", function ($route) {
    // $route->resource("kategori/kelompok", ['controller' => 'Api\Pulsa\KategoriPulsa::kelompok']);
    $route->resource("kategori", ['controller' => 'Api\Pulsa\KategoriPulsa']);
    $route->resource("produk", ['controller' => 'Api\Pulsa\ProdukPulsa']);

    $route->resource("menu_digital/kelompok", ['controller' => 'Api\Pulsa\MenuDigital::kelompok']);
    $route->resource("menu_digital", ['controller' => 'Api\Pulsa\MenuDigital']);
});
