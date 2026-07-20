<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'reference', 
        'id_client', 
        'id_type_operation', 
        'type_mvt', 
        'montant', 
        'frais'
    ];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'reference'         => 'required|string|max_length[50]',
        'id_client'         => 'required|is_natural_no_zero|is_not_unique[clients.id]',
        'id_type_operation' => 'required|is_natural_no_zero|is_not_unique[type_operations.id]',
        'type_mvt'          => 'required|in_list[CREDIT,DEBIT]',
        'montant'           => 'required|numeric|greater_than[0]',
        'frais'             => 'permit_empty|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'id_client' => [
            'is_not_unique' => 'Le client spécifié n\'existe pas.',
        ],
        'type_mvt' => [
            'in_list'       => 'Le type de mouvement doit être CREDIT ou DEBIT.',
        ],
        'montant' => [
            'greater_than'  => 'Le montant doit être supérieur à zéro.',
        ],
    ];

    protected $skipValidation = false;

    public function getByClient($idClient) {
        return $this->where('id_client', $idClient)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}