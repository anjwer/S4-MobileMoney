<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['prefixe'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'prefixe' => 'required|string|max_length[15]|is_unique[prefixes.prefixe]',
    ];

    protected $validationMessages = [
        'prefixe' => [
            'required'  => 'Le préfixe est obligatoire.',
            'is_unique' => 'Ce préfixe existe déjà.',
        ],
    ];

    protected $skipValidation = false;
}