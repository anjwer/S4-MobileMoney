<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class Prefixe extends BaseController
{
    public function index()
    {
        $model = new PrefixeModel();
        $data['prefixes'] = $model->findAll();
        return view('operator/prefixes', $data);
    }

    public function save()
    {
        $model = new PrefixeModel();
        
        $rules = ['prefixe' => 'required|min_length[3]|max_length[3]|is_unique[prefixes.prefixe]'];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Préfixe invalide ou déjà existant.');
        }

        $model->save(['prefixe' => $this->request->getPost('prefixe')]);
        return redirect()->to('/operator/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function delete($id)
    {
        $model = new PrefixeModel();
        $model->delete($id);
        return redirect()->to('/operator/prefixes')->with('success', 'Préfixe supprimé.');
    }
}