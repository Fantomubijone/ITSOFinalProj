<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        $userType = $session->get('userType');
        return view('dashboard', ['userType' => $userType]);
    }

    public function itso_dashboard()
    {
        $session = session();
        if ($session->get('userType') != 'ITSO_Personnel') {
            return redirect()->to('/');
        }

        $data = [
            'first_name' => $session->get('first_name'),
            'last_name' => $session->get('last_name'),
            'email' => $session->get('email')
        ];

        return view('itso_dashboard', $data);
    }
    
    public function associate_dashboard()
    {
        if (session()->get('userType') != 'Associate') {
            return redirect()->to('/');
        }

        return view('associate_dashboard');
    }

    public function student_dashboard()
    {
        if (session()->get('userType') != 'Student') {
            return redirect()->to('/');
        }

        return view('student_dashboard');
    }
}
