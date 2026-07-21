<?php

namespace App\Models;

use CodeIgniter\Model;


class PromotionModel extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_type_operation', 'promotion'];
    protected $useTimestamps = false;

    // Validation rules
    protected $validationRules = [
        'id_type_operation' => 'required|is_natural_no_zero|is_not_unique[type_operations.id]',
        'frais'             => 'permit_empty|numeric|greater_than_equal_to[0]',


    ];

    protected $skipValidation = false;

    public function getFraisDeTransfert() {
        return $this->where('id_type_operation', 3)
                    ->first();
    }


}