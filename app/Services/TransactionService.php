<?php

namespace App\Services;

use App\Models\ClientModel;
use App\Models\TransactionModel;
use App\Models\BaremeFraisModel;
use App\Models\ClientSoldeModel;



class TransactionService
{
    protected $transactionModel;
    protected $clientModel;
    protected $baremeModel;


    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->clientModel = new ClientModel();
        $this->baremeModel = new BaremeFraisModel();
    }

    public function getFrais(int $idTypeOperation, float $montant): float
    {
        $bareme = $this->baremeModel
            ->where('id_type_operation',$idTypeOperation)
            ->where('borne_min <=',$montant)
            ->where('borne_max >=',$montant)
            ->first();
        return $bareme ? (float)$bareme['frais'] : 0;
    }

    public function getSolde($idClient){
        $model = new ClientSoldeModel();
        return (float) ($model->find($idClient)['solde'] ?? 0);
    }


    public function depot($idClient, $montant)
    {
        return $this->transactionModel
            ->creerTransaction(
                $idClient,
                1,
                'CREDIT',
                $montant,
                0
            );

    }


    public function retrait($idClient,$montant)
    {
        $frais = $this->getFrais(2,$montant);
        $solde = $this->getSolde($idClient);


        if($solde < ($montant + $frais)){
            return false;
        }
        return $this->transactionModel
            ->creerTransaction(
                $idClient,
                2,
                'DEBIT',
                $montant,
                $frais
            );
    }


    public function transfert(int $idExpediteur, string $telephone, float $montant)
    {
        $destinataire = $this->clientModel
            ->where('numero_telephone', $telephone)
            ->first();

        if (! $destinataire) {
            return false;
        }
        if ($destinataire['id'] == $idExpediteur) {
            return false;
        }

         $frais = $this->getFrais(3,$montant);
        $solde = $this->getSolde($idExpediteur);

        if($solde < ($montant + $frais)){
            return false;
        }

        $reference = $this->transactionModel->genererReference();
        $db = \Config\Database::connect();
        $db->transStart();

        // Débit expéditeur

        $this->transactionModel->insert([
            'reference'=>$reference,
            'id_client'=>$idExpediteur,
            'id_type_operation'=>3,
            'type_mvt'=>'DEBIT',
            'montant'=>$montant,
            'frais'=>$frais
        ]);



        // Crédit destinataire
        $this->transactionModel->insert([
            'reference'=>$reference,
            'id_client'=>$destinataire['id'],
            'id_type_operation'=>3,
            'type_mvt'=>'CREDIT',
            'montant'=>$montant,
            'frais'=>0
        ]);


        $db->transComplete();
        return $db->transStatus();
    }

}