<?php

namespace App\Services;

use App\Models\ClientModel;
use App\Models\TransactionModel;

class TransactionService
{

    protected $transactionModel;
    protected $clientModel;


    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->clientModel = new ClientModel();
    }

    public function genererReference()
    {
        return 'TX-' . date('YmdHis') . '-' . rand(1000,9999);
    }


    public function getFrais(int $idTypeOperation, float $montant): float
    {
        $baremeModel = new \App\Models\BaremeFraisModel();

        $bareme = $baremeModel
            ->where('id_type_operation', $idTypeOperation)
            ->where('borne_min <=', $montant)
            ->where('borne_max >=', $montant)
            ->first();

        // Retourne le frais trouvé ou 0 s'il n'y a pas de frais défini pour cette tranche
        return $bareme ? (float)$bareme['frais'] : 0.0;
    }

    public function getSolde($idClient)
    {
        $db = \Config\Database::connect();

        $solde = $db->table('v_client_soldes')
                    ->where('id_client',$idClient)
                    ->get()
                    ->getRow();


        return $solde ? $solde->solde : 0;
    }


    public function depot($idClient, $montant)
    {
        return $this->transactionModel->insert([
            'reference' => $this->genererReference(),
            'id_client' => $idClient,
            'id_type_operation' => 1,
            'type_mvt' => 'CREDIT',
            'montant' => $montant,
            'frais' => 0
        ]);

    }


    public function retrait($idClient,$montant)
    {
        $solde = $this->getSolde($idClient);
        $idTypeOperation = 2;
        $frais = $this->getFrais($idTypeOperation, $montant);
        $solde = $this->getSolde($idClient);
        $totalADebiter = $montant + $frais;

        if ($solde < $totalADebiter) {
            return false;
        }

        return $this->transactionModel->insert([
            'reference'=>$this->genererReference(),
            'id_client'=>$idClient,
            'id_type_operation'=>2,
            'type_mvt'=>'DEBIT',
            'montant'=>$montant,
            'frais'=>$frais

        ]);
    }


    public function transfert(int $idExpediteur, string $telephone, float $montant): bool
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

        $idTypeOperation = 3;
        $frais = $this->getFrais($idTypeOperation, $montant);
        $solde = $this->getSolde($idExpediteur);
        $totalADebiter = $montant + $frais;

        if ($solde < $totalADebiter) {
            return false;
        }

        $reference = $this->genererReference();
        $db = \Config\Database::connect();
        $db->transStart();

        $this->transactionModel->insert([
            'reference'         => $reference,
            'id_client'         => $idExpediteur,
            'id_type_operation' => $idTypeOperation,
            'type_mvt'          => 'DEBIT',
            'montant'           => $montant,
            'frais'             => $frais
        ]);

        $this->transactionModel->insert([
            'reference'         => $reference,
            'id_client'         => $destinataire['id'],
            'id_type_operation' => $idTypeOperation,
            'type_mvt'          => 'CREDIT',
            'montant'           => $montant,
            'frais'             => 0
        ]);

        $db->transComplete();

        return $db->transStatus();
    }

}