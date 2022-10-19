<?php

$route->resource("data", ['controller' => 'Api\User', 'only' => ['index', 'show', 'create', 'update']]);
$route->post("register", 'Api\User::register');
$route->put("firebase_token", 'Api\User::updateFirebaseToken');
$route->put("lokasi_user", 'Api\User::updateLokasi');

$route->group("alamat", function ($route) {
    $route->resource("/", ['controller' => 'Api\UserAlamat', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
    $route->put("/", 'Api\UserAlamat::update');
    $route->delete("/", 'Api\UserAlamat::delete');
    $route->post("active/(:segment)", 'Api\UserAlamat::setActive/$1');
    $route->post("pengaturan/(:segment)", 'Api\UserAlamat::pengaturanAlamat/$1');
});

$route->group("fingerprint_devices", function ($route) {
    $route->resource("/", ['controller' => 'Api\FingerprintDevices', 'only' => ['index', 'show', 'create', 'update', 'delete']]);
    $route->post("register", 'Api\FingerprintDevices::register');
    $route->post("unregister", 'Api\FingerprintDevices::unregister');
});

$route->group("pin", function ($route) {
    $route->get("checkPin/(:segment)", 'Api\User::checkPin/$1');
    $route->put("updatePin", 'Api\User::updatePin');
});

$route->post("top_up/top_up_saldo", 'Api\TopUp::topUpSaldo');

$route->group("keranjang", function ($route) {
    $route->get("/", 'Api\Keranjang::index');
    $route->get("order_ulang", 'Api\Keranjang::orderUlang');
    $route->post("/", 'Api\Keranjang::ubahKeranjang');
    $route->post("checkout", 'Api\Keranjang::checkout');
    $route->post("checked", 'Api\Keranjang::checkedKeranjang');
});

$route->group("checkout", function ($route) {
    $route->get("/", 'Api\Checkout::index');
    $route->post("/", 'Api\Checkout::checkout');
    $route->get("keranjang/(:segment)", 'Api\Checkout::detailKeranjang/$1');
    $route->post("terima/(:segment)", 'Api\Checkout::terimaPaket/$1');
    // $route->get("invoice/(:segment)", 'Api\Checkout::invoice/$1');
});

$route->group("checkout_pulsa", function ($route) {
    $route->get("/", 'Api\CheckoutPulsa::index');
    $route->post("/", 'Api\CheckoutPulsa::checkout');
});

$route->resource("notifikasi_to", ['controller' => 'Api\NotifikasiTo', 'only' => ['index', 'show', 'delete']]);
$route->put("notifikasi_to/mark_read/(:segment)", 'Api\NotifikasiTo::markRead/$1');
// $route->put("notifikasi_to", 'Api\User::updateProfile');

$route->group("notifikasi", function ($route) {
    $route->get("/", 'Api\Notifikasi::index');
    $route->get("my_notif", 'Api\Notifikasi::getNotif');
});

$route->group("profile", function ($route) {
    $route->get("/", 'Api\User::getMyProfile');
    $route->put("update", 'Api\User::updateProfile');
});

$route->get("saldo", 'Api\User::getMyProfile');
$route->get("saldo/riwayat", 'Api\UserSaldo::index');

$route->get("statistik", 'Api\Statistik::index');