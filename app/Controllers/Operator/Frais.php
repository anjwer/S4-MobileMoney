<?php

namespace App\Controllers\Operator;
use App\Controllers\BaseController;
use App\Models\BaremeFraisModel;
use App\Models\TypeOperationModel;

class Frais extends BaseController
{
    public function index(): string
    {
        $model = new \App\Models\BaremeFraisModel();
        $data['baremes'] = $model->findAll();
        return view('operator/frais', $data);
    }

    public function save() {
        $model = new BaremeFraisModel();

        $rules = [
            'id_type_operation' => 'required|is_natural_no_zero',
            'borne_min'         => 'required|numeric',
            'borne_max'         => 'required|numeric',
            'frais'             => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_type_operation' => $this->request->getPost('id_type_operation'),
            'borne_min'         => $this->request->getPost('borne_min'),
            'borne_max'         => $this->request->getPost('borne_max'),
            'frais'             => $this->request->getPost('frais'),
        ];

        $id = $this->request->getPost('id');
        if (!empty($id)) {
            $data['id'] = $id;
        }

        if ($model->save($data)) {
            return redirect()->to('/operator/frais')->with('success', 'Barème enregistré avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement.');
        }
    }
    
}