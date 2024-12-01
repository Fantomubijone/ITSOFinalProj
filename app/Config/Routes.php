<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('processLogin', 'Auth::processLogin');
$routes->get('register', 'Auth::register');
$routes->post('processRegister', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/activate/(:any)', 'Auth::activate/$1');

$routes->get('dashboard', 'Dashboard::index');
$routes->get('welcome', 'Auth::welcome');
$routes->get('not-found', 'Auth::not_found');

$routes->get('itso_dashboard', 'Dashboard::itso_dashboard');
$routes->get('associate_dashboard', 'Dashboard::associate_dashboard');
$routes->get('student_dashboard', 'Dashboard::student_dashboard');

$routes->get('user_management', 'UserManagement::index');
$routes->get('create', 'UserManagement::create');
$routes->post('store', 'UserManagement::store');
$routes->get('edit/(:num)', 'UserManagement::edit/$1');
$routes->post('update/(:num)', 'UserManagement::update/$1');
$routes->get('deactivate/(:num)', 'UserManagement::deactivate/$1');
$routes->get('user_management/update_account', 'UserManagement::update_account');
$routes->get('user_management/updateCurrent', 'UserManagement::updateCurrent');
$routes->post('user_management/updateCurrent', 'UserManagement::updateCurrent');


$routes->get('equipment_management', 'EquipmentManagement::index');
$routes->get('equipment_management/create', 'EquipmentManagement::create');
$routes->post('equipment_management/store', 'EquipmentManagement::store');
$routes->get('equipment_management/edit/(:num)', 'EquipmentManagement::edit/$1');
$routes->post('equipment_management/update/(:num)', 'EquipmentManagement::update/$1');
$routes->get('equipment_management/deactivate/(:num)', 'EquipmentManagement::deactivate/$1');
$routes->get('equipment_management/activate/(:num)', 'EquipmentManagement::activate/$1');
$routes->get('equipment_management/getLastItemID/(:segment)', 'EquipmentManagement::getLastItemID/$1');


$routes->get('borrow', 'Borrow::index'); // Page to search and select items for borrowing
$routes->post('borrow_items', 'Borrow::borrow_items'); // API route to handle borrowing items
$routes->post('send_borrow_email', 'Borrow::send_borrow_email'); // API route to handle sending emails
