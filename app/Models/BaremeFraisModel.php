<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeFraisModel extends Model
{
    protected $table = 'bareme_frais';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_type_operation', 'borne_min', 'borne_max', 'frais'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'id_type_operation' => 'required|is_natural_no_zero|is_not_unique[type_operations.id]',
        'borne_min'         => 'required|numeric|greater_than_equal_to[0]',
        'borne_max'         => 'required|numeric|greater_than[borne_min]',
        'frais'             => 'required|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'id_type_operation' => [
            'required'      => 'Le type d\'opération est obligatoire.',
            'is_not_unique' => 'Le type d\'opération sélectionné n\'existe pas.',
        ],
        'borne_max' => [
            'greater_than'  => 'La borne maximale doit être supérieure à la borne minimale.',
        ],
    ];

    protected $skipValidation = false;
}