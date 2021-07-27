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
$routes->get('/', 'Load_view::index');

//pengaturan
$routes->get('/pengaturan', 'User_permission::pengaturan');

//user permission
$routes->get('/pengaturan/userPermission', 'User_permission::index');
$routes->get('/pengaturan/userPermission/edit', 'User_permission::edit');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/load/view', 'Load_view::index');
$routes->get('/load/view/pendapatan', 'Load_view::load_page/view/tpendapatan/null/-1');
$routes->get('/load/view/mutasi_kas', 'Load_view::load_page/view/mutasi_kas/null/-1');
$routes->get('/load/view/biaya', 'Load_view::load_page/view/biaya/null/-1');
$routes->get('/load/laporan/(:any)', 'Load_view::load_laporan/$1');
$routes->add('/ajax_load_laporan/', 'Load_view::ajax_load_laporan/$1');
// $routes->get('/load/view/biaya_kirim/master', 'Load_view::biaya_kirim');

$routes->get('login', 'Auth::index', ['as' => 'login']);
$routes->add('api', 'Api_all');
$routes->get('load/(:any)', 'Load_view::load_page/$1');
$routes->add('ajax_load/(:any)', 'Load_view::ajax_load/$1');
$routes->add('ajax_edit_load/(:any)', 'Load_view::ajax_load_edit_master_detail/$1');
$routes->add('api/insert', 'Api_all::do_insert');
$routes->add('api/add_user', 'Api_all::save_user_pegawai');
$routes->add('api/update_md', 'Api_all::save_update_master_detail');
$routes->add('api/get_ongkir', 'Api_all::get_ongkir');
$routes->add('api/lokasi', 'Api_all::get_lokasi_auto_complete');
$routes->add('api/kabupaten_ac', 'Api_all::get_kabupaten_auto_complete');
$routes->add('api/get_jenis_kirim', 'Api_all::get_jenis_kirim');
$routes->add('api/get_layanan', 'Api_all::get_layanan');
$routes->add('api/get_manifest_in', 'Api_all::get_data_manifest');
$routes->add('api/cek_pengiriman/(:any)', 'Api_all::cek_no_pengiriman/$1');
$routes->add('api/get_min/(:any)', 'Api_all::get_minimal_wv/$1');
$routes->add('api/manifest_in/insert', 'Api_all::save_manifest_in');
$routes->add('api/insert2', 'Api_all::do_insert2');
$routes->add('api/save_pembayaran_invoice', 'Api_all::save_pembayaran_invoice');
$routes->add('api/get_cicilan/(:any)', 'Api_all::get_cicilan_piutang/$1');
$routes->add('api/detail_piutang/(:any)', 'Api_all::get_detail_piutang_aktif/$1');
$routes->add('api/bayar_tagihan_dt', 'Api_all::get_tagihan_pembayaran');
$routes->add('api/get_invoice_pending', 'Api_all::get_invoice_belum_dibayar');
$routes->add('api/get_pengiriman_kredit', 'Api_all::get_pengiriman_belum_lunas');
$routes->add('api/get_pengiriman_manifest', 'Api_all::load_pengiriman_manifest');
$routes->add('api/get_manifest_out_to_in', 'Api_all::load_manifest_out_for_in');
$routes->add('api/get_manifest_out_dt', 'Api_all::load_manifest_out_dt');
$routes->add('api/get_invoice_dt', 'Api_all::load_invoice_dt');
$routes->add('load', 'Load_view');
$routes->add('/login', 'Auth::index');
$routes->add('api/login', 'Auth::do_login');
$routes->add('api/logout', 'Auth::do_logout');
$routes->add('api/multi_insert', 'Api_all::do_multi_insert');
// $routes->add('api/load/(:any)', 'Load_view/load_page/$1');
$routes->add('api/update/(:any)', 'Api_all::do_update/$1');
$routes->add('api/delete/(:any)', 'Api_all::do_delete/$1');
// $routes->add('api/get_customer/(:any)', 'Api_all::get_customer/$1');
$routes->add('api/get_customer', 'Api_all::get_customer');
$routes->add('api/load_invoice_customer', 'Api_all::load_invoice_by_customer');
$routes->add('api/ajax_load_customer/(:any)', 'Api_all::ajax_load_customer/$1');

// $routes->add('api/', 'Api_all');
// $routes->get('/api', 'Api_all::index');
// $routes->get('/api', 'Api_all::do_insert');

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