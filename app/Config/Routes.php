<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Client\Auth::index');



$routes->get('admin/login', 'AdminAuth::index');
$routes->post('admin/login', 'AdminAuth::login');
$routes->get('admin/logout', 'AdminAuth::logout');

$routes->group('operator', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('dashboard', 'Operator\Dashboard::index');

    $routes->get('frais', 'Operator\Frais::index');
    $routes->post('frais/save', 'Operator\Frais::save'); 
    
    $routes->get('prefixes', 'Operator\Prefixe::index');
    $routes->post('prefixes/save', 'Operator\Prefixe::save');
    $routes->get('prefixes/delete/(:num)', 'Operator\Prefixe::delete/$1');
});
