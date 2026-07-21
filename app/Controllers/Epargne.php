<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EpargneModel;


class Epargne extends BaseController
{
    public function index(){
        $client = session()->get('client');

        $data['client']= $client;
        return view('client/epargne', $data);

    }

    public function save(){
        $model = new EpargneModel();

        $id_client = $this->request->getPost('id_client');

        $model->save(['id_client' => $id_client,'pourcentage' => $this->request->getPost('pourcentage')]);
        return redirect()->to('/client/dashboard')->with('success', 'epargne ajouté.');
    }
}