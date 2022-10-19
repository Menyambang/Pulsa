<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Welcome');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->cli('generator/run/(:any)', 'Generator::run/$1');
$routes->cli("background/pembayaran_to_expired", 'BackgroundProcess::pembayaranToExpired');

$routes->get('/', 'Welcome::index');

$routes->post("api/auth", 'Api\Auth::create', ['filter' => 'apiKeyFilter']);
$routes->post("api/auth_fingerprint", 'Api\Auth::authFingerprint', ['filter' => 'apiKeyFilter']);
$routes->put("api/auth/refresh", "Api\Auth::update", ['filter' => 'apiKeyFilter']);

$routes->get("verifikasi", 'Api\User::verifikasi');
$routes->get("user/reset_password", 'Api\User::reset_password');
$routes->post("user/reset_password", 'Api\User::reset_password');

$routes->get("api/user/checkout/invoice/(:segment)", 'Api\Checkout::invoice/$1');

$routes->group("api", ['filter' => 'apiKeyFilter'], function ($route) {
	require_once APPPATH . "Config/Routes/Api.php";

	$route->group("user", ['filter' => 'apiFilter'], function ($route) {
		require_once APPPATH . "Config/Routes/User.php";
	});
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}