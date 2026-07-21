<?php

if (!function_exists('sort_link')) {
    /**
     * Génère un lien de tri d'en-tête de tableau conservant les filtres actuels
     */
    function sort_link(string $column, string $label): string
    {
        $params = $_GET;
        $currentSort = $params['sort_by'] ?? '';
        $currentOrder = strtoupper($params['sort_order'] ?? 'DESC');

        // Alternance ASC / DESC
        $nextOrder = ($currentSort === $column && $currentOrder === 'ASC') ? 'DESC' : 'ASC';
        $params['sort_by'] = $column;
        $params['sort_order'] = $nextOrder;

        // Flèche indicative
        $icon = '';
        if ($currentSort === $column) {
            $icon = ($currentOrder === 'ASC') ? ' ▲' : ' ▼';
        }

        $url = current_url() . '?' . http_build_query($params);
        return '<a href="' . esc($url) . '">' . esc($label) . $icon . '</a>';
    }
}