<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ClientSoldeModel;
use App\Models\TransactionModel;
use App\Models\PrefixeModel;


use App\Services\TransactionService;


class Clients extends BaseController
{

    protected $transactionService;


    public function __construct()
    {
        $this->transactionService = new TransactionService();
    }

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

    public function depot()
    {
        return view('client/depot');
    }


    public function retrait()
    {
        return view('client/retrait');
    }


    public function transfert()
    {
        return view('client/transfert');
    }

    public function effectuerDepot()
    {
        // dd('fonction appelée');
        $client = session()->get('client');
        $montant = $this->request->getPost('montant');

        $this->transactionService->depot($client['id'],$montant);
        return redirect()->to('client/dashboard');
    }

   public function effectuerRetrait()
    {
        $client = session()->get('client');
        $montant = $this->request->getPost('montant');

        $result = $this->transactionService
                    ->retrait($client['id'],$montant);

        if(!$result) {
            return redirect()
                ->back()
                ->with('error','Solde insuffisant');
        }
        return redirect()->to('client/dashboard');

    }

    public function effectuerTransfert()
    {
        $client = session()->get('client');
        $telephone = $this->request->getPost('telephone');
        $montant = $this->request->getPost('montant');

        $result = $this->transactionService
                    ->transfert(
                        $client['id'],
                        $telephone,
                        $montant
                    );

        if(!$result){
            return redirect()
                ->back()
                ->with('error','Transfert impossible');
        }

        return redirect()
            ->to('client/dashboard');

    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('client/login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function verifierNumero()
    {
        $numero = $this->request->getPost('telephone');
        $prefixeModel = new PrefixeModel();
        return $this->response->setJSON([
            'notre_operateur' => $prefixeModel->estNotre($numero)
        ]);
    }

    public function calculerFrais($montant){
        // pour un transfert
        return $transactionService->getFrais(3, $montant);
    }
}