<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Client\Auth::index');


$routes->group('client', function($routes) { 
    $routes->get('login', 'Clients::login');
    $routes->post('login', 'Clients::verifierClient'); 
    $routes->get('dashboard', 'Clients::dashboard');
    $routes->post('depot', 'Clients\Transaction::depot');
    $routes->post('retrait', 'Clients\Transaction::retrait');
    $routes->post('transfert', 'Clients\Transaction::transfert');
});


$routes->group('operator', function($routes) {
    $routes->get('dashboard', 'Operator\Dashboard::index'); 
    $routes->get('fees', 'Operator\Fees::index');
    $routes->post('fees/save', 'Operator\Fees::save'); 
    $routes->get('prefixes', 'Operator\Prefix::index');
    $routes->post('prefixes/add', 'Operator\Prefix::add');
});
