<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $allowedFields = [
        'email',
        'mdp'
    ];

    protected $useTimestamps = false;


    /**
     * Validation rules
     */
    protected $validationRules = [
        'email' => [
            'rules'  => 'required|valid_email|max_length[100]|is_unique[utilisateurs.email]',
            'errors' => [
                'required'   => 'L\'adresse email est obligatoire.',
                'valid_email'=> 'L\'adresse email n\'est pas valide.',
                'max_length' => 'L\'email ne doit pas dépasser 100 caractères.',
                'is_unique'  => 'Cette adresse email existe déjà.'
            ]
        ],

        'mdp' => [
            'rules'  => 'required|min_length[6]|max_length[255]',
            'errors' => [
                'required'   => 'Le mot de passe est obligatoire.',
                'min_length' => 'Le mot de passe doit contenir au moins 6 caractères.',
                'max_length' => 'Le mot de passe est trop long.'
            ]
        ]
    ];


    protected $skipValidation = false;
}