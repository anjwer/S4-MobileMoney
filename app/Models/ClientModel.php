<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['numero_telephone', 'code_secret'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'numero_telephone' => 'required|string|max_length[10]|is_unique[clients.numero_telephone]',
        'code_secret'      => 'permit_empty|string|max_length[255]',
    ];

    protected $validationMessages = [
        'numero_telephone' => [
            'required'  => 'Le numéro de téléphone est obligatoire.',
            'is_unique' => 'Ce numéro de téléphone existe déjà.',
        ],
    ];

    protected $skipValidation = false;

}