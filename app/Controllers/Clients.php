<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\ClientSoldeModel;
use App\Models\TransactionModel;
use App\Models\PrefixeModel;
use App\Models\HistoriqueClientModel;
use App\Models\PromotionModel;
use App\Models\EpargneModel;



use App\Services\TransactionService;


class Clients extends BaseController
{

    protected $transactionService;
    protected $promotionModel;


    public function __construct()
    {
        $this->transactionService = new TransactionService();
        $this->promotionModel = new PromotionModel();

    }


    public function login(){
        return view('client/login');
    }


    public function verifierClient(){
        $model = new ClientModel();
        $pref = new PrefixeModel();
        $notrePrefixe = $pref->getNotre();

        $numeroTelephone = $notrePrefixe['prefixe'] . $this->request->getPost('telephone');

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
        helper('table'); // Charge le helper généré

        $client = session()->get('client');
        $model = new ClientSoldeModel();
        $solde = $model->find($client['id']);

        $histo = new HistoriqueClientModel();
        $queryParams = $this->request->getGet();

        // $historique = $histo->getByClient($client['id']);

        $historique = $histo->applyFiltersAndSort($queryParams, $histo->searchableFields, $histo->allowedSortColumns)
                                      ->paginate(10);
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

    // public function effectuerTransfert()
    // {
    //     $client = session()->get('client');
    //     $telephone = $this->request->getPost('telephone');
    //     $montant = $this->request->getPost('montant');

    //     $result = $this->transactionService
    //                 ->transfert(
    //                     $client['id'],
    //                     $telephone,
    //                     $montant
    //                 );

    //     if(!$result){
    //         return redirect()
    //             ->back()
    //             ->with('error','Transfert impossible');
    //     }

    //     return redirect()
    //         ->to('client/dashboard');

    // }

    public function effectuerTransfert()
    {
        $epargne = new EpargneModel();
        $listeEpargne = $epargne->findAll();
        $client = session()->get('client');
        $telephone = $this->request->getPost('telephone');
        $montant = (float) $this->request->getPost('montant');
        $inclureFraisRetrait = $this->request->getPost('inclure_frais_retrait') === '1';


        // verifier si c meme operateur 
        $prefixeModel = new PrefixeModel();
        

        $memeOperateur = $prefixeModel->estNotre($telephone);

        $result = $this->transactionService->transfert(
            $client['id'],
            $telephone,
            $montant,
            $memeOperateur,
            $inclureFraisRetrait
        );

        if (! $result) {
            return redirect()
                ->back()
                ->with('error', 'Transfert impossible (Solde insuffisant)');
        }

        return redirect()->to('client/dashboard')->with('success', 'Transfert effectué avec succès');
    }

    public function transfertMultiple()
    {
        return view('client/transfert_multiple');
    }

    public function effectuerTransfertMultiple()
    {
        $client = session()->get('client');
        $telephonesPost = $this->request->getPost('telephones');
        $montantTotal = (float) $this->request->getPost('montant');
        $inclureFraisRetrait = $this->request->getPost('inclure_frais_retrait') === '1';

        $telephones = explode(',', $telephonesPost);
        $telephones = array_filter(array_map('trim', $telephones));

        if(count($telephones) == 0) {
            return redirect()->back()->with('error', 'Aucun destinataire');
        }

        $montantParPersonne = $montantTotal / count($telephones);

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($telephones as $tel) {
            $result = $this->transactionService->transfert(
                $client['id'],
                $tel,
                $montantParPersonne,
                $inclureFraisRetrait
            );

            if (!$result) {
                // Should we abort all or just skip? We abort all to be consistent.
                $db->transRollback();
                return redirect()->back()->with('error', 'Transfert impossible pour le numéro '.$tel.'. Solde insuffisant.');
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
             return redirect()->back()->with('error', 'Erreur lors du transfert multiple');
        }

        return redirect()->to('client/dashboard')->with('success', 'Transfert multiple effectué avec succès vers '.count($telephones).' numéros');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('client/login')->with('success', 'Vous avez été déconnecté avec succès.');
    }

    public function verifierNumero()
    {
        $numero = $this->request->getPost('telephone');

        // Vérification de base : si le numéro fait moins de 3 caractères
        if (empty($numero) || strlen($numero) < 3) {
            return $this->response->setJSON([
                'notre_operateur' => false
            ]);
        }

        $prefixeModel = new PrefixeModel();
        return $this->response->setJSON([
            'notre_operateur' => $prefixeModel->estNotre($numero)
        ]);
    }

    // public function calculerFrais($montant){
    //     // pour un transfert
    //     $frais = $this->$transactionService->getFrais(3, $montant);
    //     return $this->response->setJSON([
    //         'frais' => $frais
    //     ]);
    // }

    public function calculerFrais()
    {
        
        $montant = (float) $this->request->getPost('montant');
        $inclureRetrait = $this->request->getPost('inclure_retrait') === 'true';

        // $fraisTransfert = $this->transactionService->getFrais(3, $montant);

        $telephone = $this->request->getPost('telephone');
        $prefixeModel = new PrefixeModel();
        $memeOperateur = $prefixeModel->estNotre($telephone);

        $fraisRetrait = 0;
        if ($inclureRetrait) {
            $fraisRetrait = $this->transactionService->getFrais(2, $montant);
        }

        $promotion = 0;
        if ($memeOperateur ){
            $promotion = $this->promotionModel->getFraisDeTransfert();
        }
        $fraisTransfert = $this->transactionService->getFrais(3, $montant)* (1- $promotion["promotion"]);

        return $this->response->setJSON([
            'frais_transfert' => $fraisTransfert,
            'frais_retrait'   => $fraisRetrait,
            'total_frais'     => $fraisTransfert + $fraisRetrait
        ]);
    }
}