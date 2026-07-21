<?php
namespace App\Controllers;

use App\Models\HistoriqueClientModel;

class Historiques extends BaseController
{
    public function index()
    {
        helper('table'); // Charge le helper généré
        $model = new TransactionModel();

        // Récupère tout depuis l'URL ($_GET)
        $queryParams = $this->request->getGet();

        // Applique les filtres + tri + pagination CI4 native
        $data['historique'] = $model->applyFiltersAndSort($queryParams, $model->searchableFields, $model->allowedSortColumns)
                                      ->paginate(10); // Ex: 10 résultats par page
        $data['pager']        = $model->pager;

        return view('client/dashboard', $data);
    }
}