<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperationModel extends Model
{
    protected $table = 'type_operations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['code', 'label'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'code'  => 'required|string|max_length[20]|is_unique[type_operations.code,id,{id}]',
        'label' => 'required|string|max_length[50]',
    ];

    protected $validationMessages = [
        'code' => [
            'required'  => 'Le code d\'opération est obligatoire.',
            'is_unique' => 'Ce code d\'opération existe déjà.',
        ],
        'label' => [
            'required'  => 'Le libellé est obligatoire.',
        ],
    ];

    protected $skipValidation = false;
}