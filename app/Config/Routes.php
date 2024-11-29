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

