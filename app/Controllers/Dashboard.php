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
}
