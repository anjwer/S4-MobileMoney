<?php

namespace App\Controllers\Operator;
use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class Dashboard extends BaseController
{
    public function index(): string
{
    $db = \Config\Database::connect();
    $prefixeModel = new PrefixeModel();

    $data['prefixesListe'] = $prefixeModel->findAll();


    $gainsData = $db->table('v_operateur_gains2')->get()->getResultArray();

    $data['mon_operateur'] = array_filter($gainsData, function($item) {
        return $item['prefixe'] == '032'; 
    });

    $data['autres_operateurs'] = array_filter($gainsData, function($item) {
        return $item['prefixe'] != '032';
    });

    $data['clients'] = $db->table('v_client_soldes')->get()->getResultArray();

    return view('operator/dashboard', $data);
}
    
}