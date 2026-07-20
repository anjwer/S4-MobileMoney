<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Client\Auth::index');





$routes->group('operator', function($routes) {
    $routes->get('dashboard', 'Operator\Dashboard::index'); 
    $routes->get('frais', 'Operator\Frais::index');
    $routes->post('frais/save', 'Operator\Frais::save'); 
    $routes->get('prefixes', 'Operator\Prefix::index');
    $routes->post('prefixes/add', 'Operator\Prefix::add');
});
