<?php

namespace App\Models;

use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $id_client = 'id_client';
    protected $pourcentage = 'pourcentage';
    protected $allowedFields = ['id_client', 'pourcentage'];

    protected $validationRules = [
        'id_client' => 'required|integer',
        'pourcentage'      => 'required|decimal|greater_than[0]|less_than_equal_to[100]',
    ];

    protected $validationMessages = [
        'id_client' => [
            'required' => 'L\'ID du préfixe est obligatoire.',
            'integer'  => 'L\'ID du préfixe doit être un entier.',
        ],
        'pourcentage' => [
            'required' => 'Le pourcentage est obligatoire.',
            'decimal'  => 'Le pourcentage doit être un nombre décimal.',
            'greater_than' => 'Le pourcentage doit être supérieur à 0.',
            'less_than_equal_to' => 'Le pourcentage ne peut pas dépasser 100.',
        ],
    ];

    protected $skipValidation = false;


}