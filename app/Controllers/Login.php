<?php

namespace App\Controllers;

use App\Models\AdminModel;

class Login extends BaseController {

    public function login()
    {
        $model = new AdminModel();
        $email = $this->request->getPost('loginEmail');
        $password = $this->request->getPost('loginPassword');
        $data = $model->where('email', $email)->first();

        $errorData = [
            'error_login' => "Password atau Email Salah"
        ];
        if($data === null){
            session()->setFlashdata($errorData);
            return redirect()->to('landing');
        }
        
        $password_hash = $model->select('password')->where('email', $email)->first();
        $verify_pass = password_verify($password[0], $password_hash['password']);

        if($verify_pass){
            $ses_data = [
                'user_id'       => $data['id'],
                'user_name'     => $data['username'],
                'user_email'    => $data['email'],
                'logged_in'     => TRUE
            ];
            session()->set($ses_data);
            return redirect()->to('dashboard');

        }
        else{
            session()->setFlashdata($errorData);
            return redirect()->to('/');
        }
    }

}