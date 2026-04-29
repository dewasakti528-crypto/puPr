<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('usulan', 'Usulan::index');
$routes->post('usulan/save', 'Usulan::save');
$routes->post('usulan/savetest', 'Usulan::savetest');
$routes->get('usulan/sukses/(:segment)', 'Usulan::sukses/$1');

// Admin routes
$routes->get('admin', 'Dashboard::index', ['filter' => 'rolefilter']);
$routes->get('admin/dashboard', 'Dashboard::index', ['filter' => 'rolefilter']);

// Usulan management routes
$routes->get('admin/usulan', 'Usulan::manage', ['filter' => 'rolefilter']);
$routes->get('admin/usulan/detail/(:segment)', 'Usulan::detail/$1', ['filter' => 'rolefilter']);
$routes->post('admin/usulan/approve/(:segment)', 'Usulan::approve/$1', ['filter' => 'rolefilter']);
$routes->post('admin/usulan/reject/(:segment)', 'Usulan::reject/$1', ['filter' => 'rolefilter']);
$routes->get('admin/usulan/download/(:segment)', 'Usulan::download/$1', ['filter' => 'rolefilter']);
$routes->get('admin/usulan/getdata', 'Usulan::getdata', ['filter' => 'rolefilter']);

$routes->get('dokumen/generatortest/(:segment)', 'DokumenGenerator::generatortest/$1');
$routes->get('dokumen/generatortest', 'DokumenGenerator::generatortest');


$routes->get('tiket', 'Tracking::index');
$routes->post('tiket/lookup', 'Tracking::lookup');

$routes->get('login','AuthController::login');
$routes->post('login','AuthController::attemptLogin');
$routes->get('logout','AuthController::logout');


