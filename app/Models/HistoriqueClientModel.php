<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\FilterableTrait;

class HistoriqueClientModel extends Model
{

    use FilterableTrait;

    protected $table = 'v_historique_client';
    protected $primaryKey = 'id_transaction';

    protected $returnType = 'array';

    protected $allowedFields = [];

    public function getByClient($idClient) {
        return $this->where('id_client', $idClient)
                    ->orderBy('datet', 'DESC')
                    ->findAll();
    }

    public array $searchableFields   = ['reference', 'operation', 'montant_total', 'datet'];
    public array $allowedSortColumns = ['reference', 'montant_total', 'datet'];
}