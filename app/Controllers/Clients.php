<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ClientSoldeModel;
use App\Models\TransactionModel;


class Clients extends BaseController
{
    public function login(){
        return view('client/login');
    }


    public function verifierClient(){
        $model = new ClientModel();
        $numeroTelephone = $this->request->getPost('telephone');

        $client = $model->where('numero_telephone', $numeroTelephone)->first();
        if (!$client) {
            $codeSecret = password_hash('0000', PASSWORD_DEFAULT);
            $data = [
                'numero_telephone' => $numeroTelephone,
                'code_secret' => $codeSecret
            ];

             if (!$model->insert($data)) {
                dd($model->errors());
            }


            $client = [
                'id' => $model->getInsertID(),
                'numero_telephone' => $numeroTelephone,
                'code_secret' => $codeSecret
            ];

        }
        $this->creerSession($client);
        return redirect()->to('client/dashboard');
    }

    function creerSession($client){
        session()->set('client',[
            'id' => $client['id'],
            'numero' => $client['numero_telephone'],
            'code_secret' => $client['code_secret']
        ]);
    }

    public function dashboard(){
        $client = session()->get('client');
        $model = new ClientSoldeModel();
        $solde = $model->find($client['id']);

        $transaction = new TransactionModel();
        $historique = $transaction->getByClient($client['id']);
        return view('client/dashboard', [
            'solde' => $solde,
            'historique' => $historique,

        ]);
    }


}