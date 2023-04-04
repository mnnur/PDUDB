<?php

namespace App\Controllers;

class GetPage extends BaseController
{

    public function dashboardView()
    {
        return view('userdb');
    }

    public function landingView()
    {
        if(session('logged_in') === true){
            return redirect()->to('/dashboard');
        }
        
        return view('landing');
    }

    public function resetPasswordView(){
        return view('resetPassword');
    }
}
