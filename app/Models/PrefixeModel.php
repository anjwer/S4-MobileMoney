<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $estNotre = 'notre';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['prefixe', 'notre'];
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

    public function extrairePrefixe($numero) {
        return substr($numero, 0, 3);
    }

    public function estNotre($numero){
        $prefixe = $this->extrairePrefixe($numero);

        // Cherche si ce préfixe existe ET appartient à notre réseau (notre = 1)
        $result = $this->where('prefixe', $prefixe)
                       ->where('notre', 1)
                       ->first();

        return !empty($result);
    }

    public function getNotre() {
        return $this->where('notre', 1)->first();
    }

}