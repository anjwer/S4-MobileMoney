<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AdminAuth extends BaseController
{
    public function index()
    {
        return view('admin/login');
    }

    public function login()
{
    $model = new UtilisateurModel();
    $email = $this->request->getPost('email');
    $mdp = $this->request->getPost('mdp');

    $user = $model->where('email', $email)->first();

    if ($user) {
        session()->set(['is_admin' => true]); 
        return redirect()->to('/operator/dashboard'); 
    }

    return redirect()->back()->with('error', 'Utilisateur non trouvé');
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}