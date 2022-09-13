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
$routes->setDefaultController('Dashboard');
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
$routes->get('/', 'Dashboard::index', ["filter" => "auth"]);

// Auth
$routes->add('auth', 'Auth::index', ["filter" => "noauth"]);
$routes->post('auth/login', 'Auth::login');
$routes->add('auth/logout', 'Auth::logout');
$routes->add('auth/blocked', 'Auth::blocked');

// Grup Routes Profil
$routes->group('profil', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Profile::index');
    $routes->post('edit_profil', 'Profile::edit_profil');
    $routes->post('ganti_foto', 'Profile::change_photo');
    $routes->delete('hapus_foto', 'Profile::delete_photo');
    $routes->post('ganti_password', 'Profile::change_password');
});

// Grup Routes User
$routes->group('user', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Users::index');
    $routes->add('tambah', 'Users::add');
    $routes->post('save', 'Users::insert');
    $routes->add('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->delete('hapus/(:num)', 'Users::delete/$1');
    $routes->add('detail/(:num)', 'Users::detail/$1');
    $routes->add('terhapus', 'Users::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'Users::restore_one/$1');
    $routes->put('pulihkanSemua/', 'Users::restore_all');
    $routes->delete('hapusPermanenSemua', 'Users::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'Users::permanent_delete_one/$1');
});

// Grup Routes Posisi
$routes->group('jabatan', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Positions::index');
    $routes->add('tambah', 'Positions::add');
    $routes->add('edit/(:num)', 'Positions::edit/$1');
    $routes->post('save', 'Positions::insert');
    $routes->post('update/(:num)', 'Positions::update/$1');
    $routes->get('akses/(:num)', 'PositionMenu::index');
    $routes->post('akses/grant', 'PositionMenu::post_access');
    $routes->delete('hapus/(:num)', 'Positions::delete/$1');
    $routes->add('terhapus', 'Positions::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'Positions::restore_one/$1');
    $routes->put('pulihkanSemua', 'Positions::restore_all');
    $routes->delete('hapusPermanen/(:num)', 'Positions::permanent_delete_one/$1');
    $routes->delete('hapusPermanenSemua', 'Positions::permanent_delete_all');
});

// Grup Routes Menu
$routes->group('menu', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Menus::index');
    $routes->add('tambah', 'Menus::add');
    $routes->post('save', 'Menus::insert');
    $routes->add('edit/(:num)', 'Menus::edit/$1');
    $routes->post('update/(:num)', 'Menus::update/$1');
    $routes->delete('hapus/(:num)', 'Menus::delete/$1');
    $routes->add('terhapus', 'Menus::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'Menus::restore_one/$1');
    $routes->put('pulihkanSemua/', 'Menus::restore_all');
    $routes->delete('hapusPermanenSemua', 'Menus::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'Menus::permanent_delete_one/$1');
});

// Grup Routes Kategori
$routes->group('kategori', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Categories::index');
    $routes->add('tambah', 'Categories::add');
    $routes->post('save', 'Categories::insert');
    $routes->add('edit/(:num)', 'Categories::edit/$1');
    $routes->post('update/(:num)', 'Categories::update/$1');
    $routes->delete('hapus/(:num)', 'Categories::delete/$1');
    $routes->add('terhapus', 'Categories::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'Categories::restore_one/$1');
    $routes->put('pulihkanSemua/', 'Categories::restore_all');
    $routes->delete('hapusPermanenSemua', 'Categories::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'Categories::permanent_delete_one/$1');
});

// Grup Routes Arsip
$routes->group('arsip', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Archives::index');
    $routes->add('tambah', 'Archives::add');
    $routes->post('save', 'Archives::insert');
    $routes->add('edit/(:num)', 'Archives::edit/$1');
    $routes->post('update/(:num)', 'Archives::update/$1');
    $routes->delete('hapus/(:num)', 'Archives::delete/$1');
    $routes->add('detail/(:any)', 'Archives::detail/$1');
    $routes->add('terhapus', 'Archives::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'Archives::restore_one/$1');
    $routes->put('pulihkanSemua/', 'Archives::restore_all');
    $routes->delete('hapusPermanenSemua', 'Archives::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'Archives::permanent_delete_one/$1');
});

// Grup Routes Jenis Surat
$routes->group('jenis-surat', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'MailType::index');
    $routes->add('tambah', 'MailType::add');
    $routes->post('save', 'MailType::insert');
    $routes->add('edit/(:num)', 'MailType::edit/$1');
    $routes->post('update/(:num)', 'MailType::update/$1');
    $routes->delete('hapus/(:num)', 'MailType::delete/$1');
    $routes->add('detail/(:any)', 'MailType::detail/$1');
    $routes->add('terhapus', 'MailType::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'MailType::restore_one/$1');
    $routes->put('pulihkanSemua/', 'MailType::restore_all');
    $routes->delete('hapusPermanenSemua', 'MailType::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'MailType::permanent_delete_one/$1');
});

// Grup Routes Surat Keluar
$routes->group('surat-keluar', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'OutgoingMail::index');
    $routes->add('buat', 'OutgoingMail::add');
    $routes->post('create', 'OutgoingMail::insert');
    $routes->add('edit/(:num)', 'OutgoingMail::edit/$1');
    $routes->post('update/(:num)', 'OutgoingMail::update/$1');
    $routes->put('unduh/(:num)', 'OutgoingMail::download/$1');
    $routes->delete('hapus/(:num)', 'OutgoingMail::delete/$1');
    $routes->add('terhapus', 'OutgoingMail::show_all_deleted');
    $routes->put('pulihkan/(:num)', 'OutgoingMail::restore_one/$1');
    $routes->put('pulihkanSemua/', 'OutgoingMail::restore_all');
    $routes->delete('hapusPermanenSemua', 'OutgoingMail::permanent_delete_all');
    $routes->delete('hapusPermanen/(:num)', 'OutgoingMail::permanent_delete_one/$1');
});

// Grup Routes Koleksi Arsip
$routes->group('koleksi', ["filter" => "auth"], function ($routes) {
    $routes->add('', 'Collection::index');
    $routes->add('detail/(:any)', 'Collection::detail/$1');
    $routes->add('download/(:any)', 'Collection::download/$1');
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
