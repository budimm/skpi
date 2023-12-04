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
$routes->get('/', 'Home::index');

// Group User Management
$routes->group('user-management', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('/', 'UserManagement::index');
    $routes->get('get-all-users', 'UserManagement::data_user');
    $routes->post('add-user', 'UserManagement::add_user');
    $routes->post('get-user', 'UserManagement::get_user');
    $routes->post('update-user', 'UserManagement::update_user');
    $routes->post('delete-user', 'UserManagement::delete_user');
});

// Group Prodi Fakultas Management
$routes->group('prodi-fakultas-management', ['filter' => 'role:admin,bpm'], function ($routes) {
    $routes->get('/', 'ProdiFakultasManagement::index');
    $routes->get('get-all-fakultas', 'ProdiFakultasManagement::get_all_fakultas');
    $routes->get('get-all-prodi', 'ProdiFakultasManagement::get_all_prodi');
    $routes->post('get-fakultas', 'ProdiFakultasManagement::get_fakultas');
    $routes->post('get-prodi', 'ProdiFakultasManagement::get_prodi');
    $routes->post('add-prodi', 'ProdiFakultasManagement::add_prodi');
    $routes->post('add-fakultas', 'ProdiFakultasManagement::add_fakultas');
    $routes->post('edit-prodi', 'ProdiFakultasManagement::edit_prodi');
    $routes->post('edit-fakultas', 'ProdiFakultasManagement::edit_fakultas');
    $routes->post('delete-prodi', 'ProdiFakultasManagement::delete_prodi');
    $routes->post('delete-fakultas', 'ProdiFakultasManagement::delete_fakultas');
});

// Group Gelar Management
$routes->group('gelar-management', ['filter' => 'role:admin,bpm'], function ($routes) {
    $routes->get('/', 'GelarManagement::index');
    $routes->get('get-all-gelar', 'GelarManagement::get_all_gelar');
    $routes->post('add-gelar', 'GelarManagement::add_gelar');
    $routes->post('get-gelar', 'GelarManagement::get_gelar');
    $routes->post('edit-gelar', 'GelarManagement::edit_gelar');
    $routes->post('delete-gelar', 'GelarManagement::delete_gelar');
});

// Group Form Management Management
$routes->group('form-management', function ($routes) {
    // Group Penyelenggara Program Management
    $routes->group('penyelenggara-program-management', function ($routes) {
        $routes->get('/', 'FormManagement\PenyelenggaraProgram::index');
        $routes->get('get-all-penyelenggara-program', 'FormManagement\PenyelenggaraProgram::get_all_penyelenggara_program');
        $routes->post('add-penyelenggara-program', 'FormManagement\PenyelenggaraProgram::add_penyelenggara_program');
        $routes->post('get-penyelenggara-program', 'FormManagement\PenyelenggaraProgram::get_penyelenggara_program');
        $routes->post('update-penyelenggara-program', 'FormManagement\PenyelenggaraProgram::update_penyelenggara_program');
        $routes->post('delete-penyelenggara-program', 'FormManagement\PenyelenggaraProgram::delete_penyelenggara_program');
    });

    // Group Kemampuan Bidang Umum Management
    $routes->group('kemampuan-bidang-umum-management', function ($routes) {
        $routes->get('/', 'FormManagement\KemampuanBidangUmum::index');
        $routes->get('get-all-kemampuan-bidang-umum', 'FormManagement\KemampuanBidangUmum::get_all_kemampuan_bidang_umum');
        $routes->post('add-kemampuan-bidang-umum', 'FormManagement\KemampuanBidangUmum::add_kemampuan_bidang_umum');
        $routes->post('get-kemampuan-bidang-umum', 'FormManagement\KemampuanBidangUmum::get_kemampuan_bidang_umum');
        $routes->post('update-kemampuan-bidang-umum', 'FormManagement\KemampuanBidangUmum::update_kemampuan_bidang_umum');
        $routes->post('delete-kemampuan-bidang-umum', 'FormManagement\KemampuanBidangUmum::delete_kemampuan_bidang_umum');
    });

    // Group Kemampuan Bidang Khusus Management
    $routes->group('kemampuan-bidang-khusus-management', function ($routes) {
        $routes->get('/', 'FormManagement\KemampuanBidangKhusus::index');
        $routes->get('get-all-kemampuan-bidang-khusus', 'FormManagement\KemampuanBidangKhusus::get_all_kemampuan_bidang_khusus');
        $routes->post('add-kemampuan-bidang-khusus', 'FormManagement\KemampuanBidangKhusus::add_kemampuan_bidang_khusus');
        $routes->post('get-kemampuan-bidang-khusus', 'FormManagement\KemampuanBidangKhusus::get_kemampuan_bidang_khusus');
        $routes->post('update-kemampuan-bidang-khusus', 'FormManagement\KemampuanBidangKhusus::update_kemampuan_bidang_khusus');
        $routes->post('delete-kemampuan-bidang-khusus', 'FormManagement\KemampuanBidangKhusus::delete_kemampuan_bidang_khusus');
    });

    // Group Penguasaan Pengetahuan Management
    $routes->group('penguasaan-pengetahuan-management', function ($routes) {
        $routes->get('/', 'FormManagement\PenguasaanPengetahuan::index');
        $routes->get('get-all-penguasaan-pengetahuan', 'FormManagement\PenguasaanPengetahuan::get_all_penguasaan_pengetahuan');
        $routes->post('add-penguasaan-pengetahuan', 'FormManagement\PenguasaanPengetahuan::add_penguasaan_pengetahuan');
        $routes->post('get-penguasaan-pengetahuan', 'FormManagement\PenguasaanPengetahuan::get_penguasaan_pengetahuan');
        $routes->post('update-penguasaan-pengetahuan', 'FormManagement\PenguasaanPengetahuan::update_penguasaan_pengetahuan');
        $routes->post('delete-penguasaan-pengetahuan', 'FormManagement\PenguasaanPengetahuan::delete_penguasaan_pengetahuan');
    });

    // Group Penguasaan Sikap Management
    $routes->group('penguasaan-sikap-management', function ($routes) {
        $routes->get('/', 'FormManagement\PenguasaanSikap::index');
        $routes->get('get-all-penguasaan-sikap', 'FormManagement\PenguasaanSikap::get_all_penguasaan_sikap');
        $routes->post('add-penguasaan-sikap', 'FormManagement\PenguasaanSikap::add_penguasaan_sikap');
        $routes->post('get-penguasaan-sikap', 'FormManagement\PenguasaanSikap::get_penguasaan_sikap');
        $routes->post('update-penguasaan-sikap', 'FormManagement\PenguasaanSikap::update_penguasaan_sikap');
        $routes->post('delete-penguasaan-sikap', 'FormManagement\PenguasaanSikap::delete_penguasaan_sikap');
    });

    //  Group Ditjen Dikti Management
    $routes->group('ditjen-dikti-management', function ($routes) {
        $routes->get('/', 'FormManagement\DitjenDikti::index');
        $routes->get('get-all-ditjen-dikti', 'FormManagement\DitjenDikti::get_all_ditjen_dikti');
        $routes->post('add-ditjen-dikti', 'FormManagement\DitjenDikti::add_ditjen_dikti');
        $routes->post('get-ditjen-dikti', 'FormManagement\DitjenDikti::get_ditjen_dikti');
        $routes->post('update-ditjen-dikti', 'FormManagement\DitjenDikti::update_ditjen_dikti');
        $routes->post('delete-ditjen-dikti', 'FormManagement\DitjenDikti::delete_ditjen_dikti');
    });
});

$routes->group('form-skpi', function ($routes) {
    $routes->get('/', 'FormSkpi::index');
    $routes->get('get-all-form', 'FormSkpi::get_all_form_skpi');
    $routes->post('add-form', 'FormSkpi::add_form_skpi');
    $routes->post('get-form', 'FormSkpi::get_form_skpi');
    $routes->post('update-form', 'FormSkpi::update_form_skpi');
    $routes->post('delete-form', 'FormSkpi::delete_form_skpi');

    $routes->get('export-pdf', 'FormSkpi::export_pdf');
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
