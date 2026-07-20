<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ClientSoldeModel;

class Clients extends BaseController
{
    public function index(){
        return view('index');
    }

    public function solde($id_client)
    {
        $model = new ClientSoldeModel();
        $solde = $model->find($id_client);
        return $solde;
    }
}