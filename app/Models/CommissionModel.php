<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionModel extends Model {
    
    protected $table = 'commission';
    protected $primaryKey = 'id';
    protected $id_prefixe = 'id_prefixe';
    protected $pourcentage = 'pourcentage';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_prefixe', 'pourcentage'];

    // Validation rules
    protected $validationRules = [
        'id_prefixe' => 'required|integer',
        'pourcentage' => 'required|decimal|greater_than[0]|less_than_equal_to[100]',
    ];

    protected $validationMessages = [
        'id_prefixe' => [
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