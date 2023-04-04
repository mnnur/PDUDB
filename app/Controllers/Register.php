<?php namespace App\Controllers;

use App\Models\AdminModel;

class Register extends BaseController
{   
    public function register()
    {
        $rules = [
            'registerUsername'          => [
                'rules' => 'required|min_length[3]|max_length[32]',
                'errors' => [
                    'required' => 'Username tidak boleh kosong',
                    'min_length' => 'Username minimal {param} karakter',
                    'max_length' => 'Username maksimal {param} karakter',
                ],
            ],
            'registerEmail'         => [
               'rules' => 'required|min_length[6]|max_length[64]|valid_email|is_unique[admins.email]',
               'errors' => [
                    'required' => 'Email tidak boleh kosong',
                    'min_length' => 'Email minimal {param} karakter',
                    'max_length' => 'Email maksimal {param} karakter',
                    'valid_email' => 'Email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
               ]
            ],
            'registerPassword'      => 'required|min_length[6]|max_length[200]',
            'registerPasswordConfirm'  => 'matches[registerPassword]'
        ];
         
        if($this->validate($rules)){
            $newAdmin = new AdminModel();

            $dataRegister = [
                'username'     => $this->request->getPost('registerUsername'),
                'email'    => $this->request->getPost('registerEmail'),
                'password' => password_hash($this->request->getPost('registerPassword')[0], PASSWORD_DEFAULT),
            ];
            $newAdmin->save($dataRegister);

            $flashData = [
                'register_notice' => "Akun sukses dibuat, silahkan login"
            ];
            session()->setFlashdata($flashData);
            return redirect()->to('/');
        }
        else{
            $flashData = [
                'register_notice' => \Config\Services::validation()->listErrors(),
            ];
            session()->setFlashdata($flashData);
            return redirect()->to('/');
        }
    }
}