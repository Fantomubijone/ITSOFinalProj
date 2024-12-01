<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CurrentModel;


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

        // dd($data['users']);

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

    public function update_account() {
        $session = session();
        $email = $session->get('email');
    
        $userModel = new UserModel();
        $currentModel = new CurrentModel();
    
        $userData = $userModel->where('email', $email)->first();
        $currentData = $currentModel->where('email', $email)->first();
    
        if ($userData && $currentData) {
            $data = [
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'role' => $userData['user_type'],
                'password' => $userData['password']
            ];
            return view('update_account', $data);
        } else {
            return redirect()->to('/user_management');
        }
    }

    public function updateCurrent() {
        $session = session();
        $userModel = new UserModel();
        $email = $session->get('email');
    
        $userData = $userModel->where('email', $email)->first();
    
        if (!$userData) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Prepare data for update
        $updatedata = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email')
        ];
    
        // Check if password fields are provided
        $oldPasswordInput = $this->request->getPost('old_password');
        $newPassword = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
    
        if (!empty($oldPasswordInput) || !empty($newPassword) || !empty($confirmPassword)) {
            // Validate the old password
            if (!password_verify($oldPasswordInput, $userData['password'])) {
                return redirect()->back()->with('error', 'Old password is incorrect.');
            }
    
            // Ensure the new password and confirm password match
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'New password and confirm password do not match.');
            }
    
            // Ensure the new password meets the criteria
            if (strlen($newPassword) < 8) {
                return redirect()->back()->with('error', 'New password does not meet the required criteria.');
            }
    
            // Ensure the new password is not the same as the old password
            if (password_verify($newPassword, $userData['password'])) {
                return redirect()->back()->with('error', 'New password cannot be the same as the old password.');
            }
    
            // Add the new password to the update data
            $updatedata['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
    
        // Update the user data
        if ($userModel->update($userData['id'], $updatedata)) {
            // Update session data
            $session->set([
                'first_name' => $updatedata['first_name'],
                'last_name' => $updatedata['last_name'],
                'email' => $updatedata['email']
            ]);
    
            // Update the `current` table
            $db = \Config\Database::connect();
            $builder = $db->table('current');
            $builder->truncate(); // Clear all previous records
            $builder->insert([
                'user_id' => $userData['id'],
                'first_name' => $updatedata['first_name'],
                'last_name' => $updatedata['last_name'],
                'email' => $updatedata['email']
            ]);
    
            return redirect()->to('/user_management')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile.');
        }
    }
        
    
}
