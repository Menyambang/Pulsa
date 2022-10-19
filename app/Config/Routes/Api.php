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

$route->group("rita", function ($route) {
    $route->group("auth", function ($route) {

        $route->post("/", 'Api\Rita\Auth::auth');
        $route->post("sendOTP", 'Api\Rita\Auth::sendOTP');
        $route->put("refresh", 'Api\Rita\Auth::refresh');
    });

    $route->group("user", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("profile", 'Api\Rita\User::getProfile');
        $route->get("balance", 'Api\Rita\User::getBalance');
        $route->get("home", 'Api\Rita\User::getHome');
    });

    $route->group("transaksi", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("/", 'Api\Rita\Transaksi::getTransactionList');
    });

    $route->group("product", ['filter' => 'apiFilter'],  function ($route) {
        $route->post("/", 'Api\Rita\Product::getProduct');
        $route->post("recharge", 'Api\Rita\Product::rechargeProduct');
    });
});

$route->group("digipos", function ($route) {
    $route->group("auth", function ($route) {

        $route->post("/", 'Api\Digipos\Auth::auth');
        $route->post("sendOTP", 'Api\Digipos\Auth::sendOTP');
        $route->put("refresh", 'Api\Digipos\Auth::refresh');
        $route->get("bypass", 'Api\Digipos\Auth::bypass');
        $route->get("cryptographyPlayground", 'Api\Digipos\Auth::cryptographyPlayground');
    });

    $route->group("user", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("kategori", 'Api\Digipos\User::getKategori');
        $route->get("profile", 'Api\Digipos\User::getProfile');
        $route->get("cekSaldo/(:segment)", 'Api\Digipos\User::cekSaldo/$1');
    });

    $route->group("pulsa", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("detail/(:segment)/(:segment)", 'Api\Digipos\Pulsa::getPulsa/$1/$2');
        $route->post("recharge", 'Api\Digipos\Pulsa::recharge');
        $route->post("confirm", 'Api\Digipos\Pulsa::confirm');
    });

    $route->group("paket_data", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("detail/(:segment)/(:segment)", 'Api\Digipos\PaketData::getPaketData/$1/$2');
        $route->post("recharge", 'Api\Digipos\PaketData::recharge');
        $route->post("confirm", 'Api\Digipos\PaketData::confirm');
    });

    $route->group("digital", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("detail/(:segment)/(:segment)", 'Api\Digipos\Digital::getDigital/$1/$2');
        $route->post("check", 'Api\Digipos\Digital::check');
        $route->post("recharge", 'Api\Digipos\Digital::recharge');
        $route->post("confirm", 'Api\Digipos\Digital::confirm');
    });

    $route->group("perdana_internet", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("detail/(:segment)/(:segment)", 'Api\Digipos\PerdanaInternet::getPerdanaInternet/$1/$2');
        $route->post("check", 'Api\Digipos\PerdanaInternet::check');
        $route->post("recharge", 'Api\Digipos\PerdanaInternet::recharge');
        $route->post("confirm", 'Api\Digipos\PerdanaInternet::confirm');
    });

    $route->group("roaming", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("detail/(:segment)/(:segment)", 'Api\Digipos\Roaming::getRoaming/$1/$2');
        $route->post("recharge", 'Api\Digipos\Roaming::recharge');
        $route->post("confirm", 'Api\Digipos\Roaming::confirm');
    });

    $route->group("ppob", ['filter' => 'apiFilter'],  function ($route) {
        $route->get("list", 'Api\Digipos\Ppob::getList');
        $route->get("detail/(:segment)", 'Api\Digipos\Ppob::getDetail/$1');
        $route->get("price/(:segment)", 'Api\Digipos\Ppob::getPrice/$1');
        $route->post("preInquiry", 'Api\Digipos\Ppob::preInquiry');
        $route->post("confirm", 'Api\Digipos\Ppob::confirm');
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
