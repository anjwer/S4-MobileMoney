<?php

namespace App\Traits;

trait FilterableTrait
{
    /**
     * Applique automatiquement les filtres et le tri au Model
     * @return $this
     */
    public function applyFiltersAndSort(array $params = [], array $searchableFields = [], array $allowedSortColumns = [])
    {
        // 1. Filtrage dynamique (appliqué directement sur $this)
        foreach ($params as $key => $value) {
            if ($value === null || $value === '') continue;

            if (in_array($key, $searchableFields)) {
                if ($key === 'date_debut') {
                    $this->where("date({$this->table}.created_at) >=", $value);
                } elseif ($key === 'date_fin') {
                    $this->where("date({$this->table}.created_at) <=", $value);
                } elseif (is_numeric($value)) {
                    $this->where("{$this->table}.{$key}", $value);
                } else {
                    $this->like("{$this->table}.{$key}", $value);
                }
            }
        }

        // 2. Tri dynamique
        $sortBy    = $params['sort_by'] ?? $this->primaryKey;
        $sortOrder = strtoupper($params['sort_order'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';

        if (in_array($sortBy, $allowedSortColumns)) {
            $this->orderBy("{$this->table}.{$sortBy}", $sortOrder);
        }

        // Renvoie l'instance du Model (permet d'appeler ->paginate() ou ->findAll())
        return $this; 
    }
}