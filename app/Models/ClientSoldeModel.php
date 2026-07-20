<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientSoldeModel extends Model
{
    protected $table = 'v_client_soldes';
    protected $primaryKey = 'id_client';

    protected $returnType = 'array';

    protected $allowedFields = [];
}