<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Client\Auth::index');


$routes->group('client', function($routes) { 
    $routes->get('login', 'Client\Auth::index');
    $routes->post('login', 'Client\Auth::login'); 
    $routes->get('dashboard', 'Client\Account::index');
    $routes->post('depot', 'Client\Transaction::depot');
    $routes->post('retrait', 'Client\Transaction::retrait');
    $routes->post('transfert', 'Client\Transaction::transfert');
});


$routes->group('operator', function($routes) {
    $routes->get('dashboard', 'Operator\Dashboard::index'); 
    $routes->get('fees', 'Operator\Fees::index');
    $routes->post('fees/save', 'Operator\Fees::save'); 
    $routes->get('prefixes', 'Operator\Prefix::index');
    $routes->post('prefixes/add', 'Operator\Prefix::add');
});
