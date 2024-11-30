<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserManagement extends BaseController
{
    public function index()
    {

        $session = session();
        if ($session->get('userType') != 'ITSO_Personnel') {
            return redirect()->to('/');
        }
        
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        
        // Add user data to the view data
        $data['first_name'] = session()->get('first_name');
        $data['last_name'] = session()->get('last_name');
        $data['email'] = session()->get('email');

        return view('user_management', $data);
    }

    public function create()
    {
        return view('user_create');
    }

    public function store()
    {
        $userModel = new UserModel();

        $data = [
            'school_id' => $this->request->getPost('school_id'),
            'first_name' => ucwords(strtolower($this->request->getPost('first_name'))),
            'last_name' => ucwords(strtolower($this->request->getPost('last_name'))),
            'email' => $this->request->getPost('email'),
            'user_type' => $this->request->getPost('user_type'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => 1, // Default status to active
        ];

        $userModel->save($data);

        return redirect()->to('/user_management');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id);

        return view('user_edit', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();

        $data = [
            'school_id' => $this->request->getPost('school_id'),
            'first_name' => ucwords(strtolower($this->request->getPost('first_name'))),
            'last_name' => ucwords(strtolower($this->request->getPost('last_name'))),
            'email' => $this->request->getPost('email'),
            'user_type' => $this->request->getPost('user_type'),
            'status' => $this->request->getPost('status'),
        ];

        $userModel->update($id, $data);

        return redirect()->to('/user_management');
    }

    public function deactivate($id)
    {
        $userModel = new UserModel();
        $userModel->update($id, ['status' => 0]);

        return redirect()->to('/user_management');
    }
}
