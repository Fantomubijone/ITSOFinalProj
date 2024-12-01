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
$routes->get('user_management/create', 'UserManagement::create');
$routes->post('user_management/store', 'UserManagement::store');

$routes->get('user_management/edit/(:segment)', 'UserManagement::edit/$1');
$routes->post('user_management/update/(:segment)', 'UserManagement::update/$1');

$routes->get('user_management/deactivate/(:num)', 'UserManagement::deactivate/$1');
$routes->get('user_management/activate/(:num)', 'UserManagement::activate/$1');

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
$routes->get('return', 'Borrow::return_index'); // Page to search and select items for returning
$routes->post('return_items', 'Borrow::return_items'); // API route to handle returning items

$routes->get('reports', 'Reports::index');
$routes->get('reports/active_equipment', 'Reports::active_equipment');
$routes->get('reports/unusable_equipment', 'Reports::unusable_equipment');
$routes->get('reports/user_borrowing_history', 'Reports::user_borrowing_history');

