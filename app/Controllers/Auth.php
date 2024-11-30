<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        } else {
            return view('login');
        }
    }

    public function processLogin()
    {
        $session = session();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
    
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
    
        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['status'] == 1) {
                    $session->set([
                        'user_id' => $user['id'],
                        'email' => $user['email'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'isLoggedIn' => true,
                        'userType' => $user['user_type']
                    ]);
    
                    // Delete all records in current_user table
                    $db = \Config\Database::connect();
                    $builder = $db->table('current');
                    $builder->truncate();
    
                    // Insert current user record
                    $builder->insert([
                        'user_id' => $user['id'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'email' => $user['email']
                    ]);
    
                    return redirect()->to('/dashboard');
                } else {
                    $session->setFlashdata('msg', 'Account not activated. Please check your email for verification instructions.');
                }
            } else {
                $session->setFlashdata('msg', 'Invalid login credentials!');
            }
        } else {
            $session->setFlashdata('msg', 'Account does not exist!');
        }
    
        return redirect()->to('/');
    }
    

    public function register()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        } else {
            return view('register');
        }
    }

    public function processRegister()
    {
        // Load form helper
        helper('form');
    
        if ($this->request->is('POST')) {
            // Load model
            $userModel = model('UserModel');
    
            // VALIDATION CODES
            // Get data from form
            $formData = $this->request->getPost([
                'school_id',
                'first_name',
                'last_name',
                'email',
                'password',
                'confirm_password',
                'user_type',
            ]);
    
            // Set validation rules
            $rules = [
                'school_id' => 'required|min_length[3]|max_length[20]|is_unique[users.school_id]',
                'first_name' => 'required|min_length[3]|max_length[50]',
                'last_name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]',
                'user_type' => 'required|in_list[ITSO_Personnel,Associate,Student]',
            ];
    
            // Set custom messages for validation errors
            $messages = [
                'school_id' => [
                    'required' => 'School ID is required.',
                    'min_length' => 'School ID must be at least 3 characters long.',
                    'max_length' => 'School ID cannot exceed 20 characters.',
                    'is_unique' => 'School ID already exists.'
                ],
                'first_name' => [
                    'required' => 'First Name is required.',
                    'min_length' => 'First Name must be at least 3 characters long.',
                    'max_length' => 'First Name cannot exceed 50 characters.'
                ],
                'last_name' => [
                    'required' => 'Last Name is required.',
                    'min_length' => 'Last Name must be at least 3 characters long.',
                    'max_length' => 'Last Name cannot exceed 50 characters.'
                ],
                'email' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Please provide a valid email address.',
                    'is_unique' => 'Email already exists.'
                ],
                'password' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters long.'
                ],
                'confirm_password' => [
                    'required' => 'Confirm Password is required.',
                    'matches' => 'Password and Confirm Password must match.'
                ],
                'user_type' => [
                    'required' => 'User Type is required.',
                    'in_list' => 'Please select a valid User Type.'
                ]
            ];
    
            // Run the validation
            if (! $this->validateData($formData, $rules, $messages)) {
                // Reload the form if validation fails
                return view('header')
                    . view('register', ['validation' => $this->validator]);
            }
    
            // Retrieve data from form
            $registerData = $this->request->getPost([
                'school_id',
                'first_name',
                'last_name',
                'email',
                'password',
                'user_type',
            ]);

            // Capitalize the first letter of each word in first and last names 
            $registerData['first_name'] = ucwords(strtolower($registerData['first_name'])); 
            $registerData['last_name'] = ucwords(strtolower($registerData['last_name'])); 
            $registerData['password'] = password_hash($registerData['password'], PASSWORD_DEFAULT);
            $registerData['activation_code'] = uniqid();
            $registerData['status'] = 0;
    
            // Insert data to the table
            $userModel->insert($registerData);
            session()->setFlashdata('success', 'Registration of user is successful');
    
            // SEND EMAIL TO ACTIVATE ACCOUNT
            // 1. Create email object
            $email = service('email');
    
            // 2. Set the contents of the email
            $email->setSubject('Email Verification');
            $email->setTo($registerData['email']);
            $message = "
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            margin: 0;
                            padding: 20px;
                            color: #333;
                        }
                        .container {
                            background-color: #ffffff;
                            border-radius: 8px;
                            padding: 20px;
                            max-width: 600px;
                            margin: 0 auto;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        }
                        .header {
                            text-align: center;
                            padding-bottom: 20px;
                            border-bottom: 1px solid #eaeaea;
                            color: #00796B;
                            border-radius: 8px 8px 0 0;
                        }
                        .header h1 {
                            margin: 0;
                        }
                       
                        .content {
                        margin-top: 20px;
                    }
                    .content p {
                        text-align: left; /* Ensure paragraphs are left-aligned */
                    }
                    .button-wrapper {
                        text-align: center; /* Center the button */
                        margin-top: 20px;
                    }
                    .button {
                        display: inline-block;
                        padding: 12px 20px;
                        font-size: 16px;
                        font-weight: bold;
                        background-color: #00796B;
                        border-radius: 5px;
                        text-align: center;
                        color: #ffffff; /* White text */
                        text-decoration: none;
                    }
                    .button:hover {
                        background-color: #005e50;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 12px;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Welcome to ITSO Management System!</h1>
                    </div>
                    <div class='content'>
                        <p>Hello, <strong>" . htmlspecialchars($registerData['first_name']) . "</strong>!</p>
                        <p>Thank you for registering an account with us. To get started, please verify your email address by clicking the button below:</p>
                        <div class='button-wrapper'>
                            <a href='" . base_url('auth/activate/' . $registerData['activation_code']) . "' 
                               class='button' style='color: #ffffff;'>Verify Now</a>
                        </div>
                        <p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
                        <p><a href='" . base_url('auth/activate/' . $registerData['activation_code']) . "'>" . base_url('auth/activate/' . $registerData['activation_code']) . "</a></p>
                    </div>
                    <div class='footer'>
                        <p>From ITSO Management System Team</p>
                        <p>&copy; " . date('Y') . " ITSO Management System. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        $email->setMessage($message);
        $email->setMailType('html'); // Ensure the email is sent as HTML
        // 3. Send the email
        if (! $email->send()) {
            print_r($email->printDebugger(['headers']));
        }
    }

    return view('header')
        . view('register');
}

    public function activate($activation_code)
    {
        // Load model
        $userModel = model('UserModel');
        $user = $userModel->where('activation_code', $activation_code)->first();

        if ($user) {
            $userModel->update($user['id'], ['status' => 1, 'activation_code' => null]);
            session()->setFlashdata('success', 'Account activated successfully!');
            session()->set('activated', true); // Set session variable for activation
            return redirect()->to('/welcome');
        } else {
            return redirect()->to('/not-found');
        }
    }

    public function welcome()
    {
        // Check if the activation session variable is set
        if (!session()->get('activated')) {
            return redirect()->to('not-found');
        }
    
        // Unset the session variable to prevent re-accessing the page
        session()->remove('activated');
    
        return view('header') . view('welcome');
    }
    

    public function not_found()
    {
        return view('header') . view('not_found');
    }
    

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
