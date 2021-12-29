<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
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
// $routes->get('/', 'Home::index');

$routes->get('/', 'User::index');

$routes->group('', ['filter' => 'role:admin'], function ($routes) {
    // bagian admin
    $routes->get('/admin/data-user', 'User::datauser', ['as' => 'datauser']);
    $routes->get('/admin/data-user/(:num)', 'User::hapus_akun/$1');
    // tutup bagian admin
});

//route profil
$routes->get('/profile', 'User::profile');
$routes->post('/profile/update', 'User::update_profile');
$routes->post('/profile/update/password', 'User::update_password');

//route data
$routes->get('/data', 'Data::index');
$routes->post('/data/upload', 'Data::upload_data');
$routes->get("/ajax-load-data", "Data::ajaxLoadData");
$routes->get("/ajax-load-data-processing", "Data::ajaxLoadDataProcessing");
$routes->get("/data/transaksi", "Data::tampil_data_transaksi");
$routes->get("/data/produk", "Data::tampil_produk");
//hapus data
$routes->post('/data/hapus', 'Data::hapus_data');
$routes->post('/data/produk/ubah_jenis','Data::ubah_jenis_produk');

//route analisis
$routes->get('/analisis', 'Klaster::index');
$routes->get('/analisis/data-transaksi', 'Data::lihat_data_transaksi');

//route analisis klaster k-medoids
$routes->post('/analisis/klaster', 'Klaster::hasilprocessing');
$routes->post('/analisis/iterasi_klaster', 'Klaster::iterasi_klaster');

//route analisis asosiasi fp-growth
$routes->get('/analisis/asosiasi', 'Asosiasi::asosiasi');
$routes->get('/analisis/asosiasi/fptree', 'Asosiasi::display_fptree');
$routes->post('/analisis/asosiasi/ubah_sup_conf', 'Asosiasi::ubah_sup_conf');

//hasil analisis
$routes->get('/hasil', 'Hasil::index');
$routes->get('/hasil/download', 'Hasil::download');
$routes->get('/hasil/download_fptree', 'Asosiasi::display_fptree2');


//info sistem
$routes->get('/info', 'Info::index');



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
