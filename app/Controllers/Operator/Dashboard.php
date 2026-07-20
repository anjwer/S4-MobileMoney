<?php

namespace App\Controllers\Operator;
use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
      $db = \Config\Database::connect();
        $data['gains'] = $db->table('v_operateur_gains')->get()->getResultArray();
        $data['clients'] = $db->table('v_client_soldes')->get()->getResultArray();

        return view('operator/dashboard', $data);
    }
    
}