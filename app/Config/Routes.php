<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->group('client', function($routes) { 
    $routes->get('login', 'Clients::login');
    $routes->post('login', 'Clients::verifierClient'); 

    $routes->post('verifierNumero', 'Clients::verifierNumero'); 
    $routes->post('calculerFrais', 'Clients::calculerFrais'); 


    $routes->get('dashboard', 'Clients::dashboard');


    $routes->get('depot', 'Clients::depot');
    $routes->post('depot', 'Clients::effectuerDepot');

    $routes->get('retrait', 'Clients::retrait');
    $routes->post('retrait', 'Clients::effectuerRetrait');

    $routes->get('transfert', 'Clients::transfert');
    $routes->post('transfert', 'Clients::effectuerTransfert');

    $routes->get('transfertMultiple', 'Clients::transfertMultiple');
    $routes->post('transfertMultiple', 'Clients::effectuerTransfertMultiple');



    $routes->get('logout', 'Clients::logout');

});

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
