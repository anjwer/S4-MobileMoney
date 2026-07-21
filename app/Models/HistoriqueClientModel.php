<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueClientModel extends Model
{
    protected $table = 'v_historique_client';
    protected $primaryKey = 'id_transaction';

    protected $returnType = 'array';

    protected $allowedFields = [];

    public function getByClient($idClient) {
        return $this->where('id_client', $idClient)
                    ->orderBy('datet', 'DESC')
                    ->findAll();
    }
}