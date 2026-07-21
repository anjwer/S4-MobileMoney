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


    public function transfert(int $idExpediteur, string $telephone, float $montant, bool $inclureFraisRetrait = false): bool
    {
        $destinataire = $this->clientModel->where('numero_telephone', $telephone)->first();
        if (! $destinataire || $destinataire['id'] == $idExpediteur) {
            return false;
        }

        // Calcul des frais
        $fraisTransfert = $this->getFrais(3, $montant);
        $fraisRetrait = $inclureFraisRetrait ? $this->getFrais(2, $montant) : 0;

        $totalFraisExpediteur = $fraisTransfert + $fraisRetrait;
        $montantCreditDestinataire = $montant + $fraisRetrait; // Reçoit le montant + le bonus de retrait

        $soldeExpediteur = $this->getSolde($idExpediteur);
        if ($soldeExpediteur < ($montant + $totalFraisExpediteur)) {
            return false; // Solde insuffisant
        }

        $reference = $this->transactionModel->genererReference();
        $db = \Config\Database::connect();
        $db->transStart();

        // Débit Expéditeur
        $this->transactionModel->insert([
            'reference'         => $reference,
            'id_client'         => $idExpediteur,
            'id_type_operation' => 3,
            'type_mvt'          => 'DEBIT',
            'montant'           => $montant + $fraisRetrait,
            'frais'             => $fraisTransfert
        ]);

        // Crédit Destinataire
        $this->transactionModel->insert([
            'reference'         => $reference,
            'id_client'         => $destinataire['id'],
            'id_type_operation' => 3,
            'type_mvt'          => 'CREDIT',
            'montant'           => $montantCreditDestinataire,
            'frais'             => 0
        ]);

        $db->transComplete();

        return $db->transStatus();
    }
}