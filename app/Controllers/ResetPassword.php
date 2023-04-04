<?php

namespace App\Controllers;

use App\Models\TokenModel;
use App\Models\AdminModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class ResetPassword extends ResourceController
{
  use ResponseTrait;

  protected $model;
  protected $format = 'json';

  public function __construct()
  {
    $this->model = new TokenModel();
  }

  protected function formatResponse(int $status, $data = null, $error = null, string $message = null)
  {
    return [
      'status' => $status,
      'data' => $data,
      'error' => $error,
      'message' => $message
    ];
  }

  public function createToken()
  {
      try {
          $requestData = $this->request->getJSON(true);
  
          $email = $requestData['email'];
          // Assuming the email field is sent via POST request
  
          if($email !== null) {
              $model = new TokenModel();
              
              $model->where('email', $email)->delete();

              $token = bin2hex(random_bytes(32));
  
              while($model->isDuplicated($token)){
                $token = bin2hex(random_bytes(32));
              }
  
              $now = strtotime($model->query('SELECT now() as now')->getRow()->now);
              $current_time = date('Y-m-d H:i:s', strtotime('+1 second', $now));
              $expiration_time = date('Y-m-d H:i:s', strtotime('+1 hour', $now));
  
              // Insert the email and token into the database
              $data = [
                  'email' => $email,
                  'token' => $token,
                  'created' => $current_time,
                  'expired' => $expiration_time
              ];
              
              $model->insert($data);
  
              $this->sendToken($email, $token);
  
              return $this->respond($this->formatResponse(200, null, null, 'Kode Verifikasi Sukses dibuat'), 200);
          } else {
              return $this->failNotFound('Kode Verifikasi Gagal dibuat');
          }
      } catch (\Exception $e) {
          // Log the error and return an error response
          log_message('error', $e->getMessage());
          return $this->respond($this->formatResponse(500, null, ['error' => 'Internal Server Error'], 'Terjadi kesalahan pada server'), 500);
      }
  }
  

  public function sendToken(string $emailTo, string $token){
    $email = \Config\Services::email();

    $email->setFrom('admin@pdudb.com', 'Admin');
    $email->setTo($emailTo);

    $email->setSubject('PDUDB Password Reset Verification Code');
    $email->setMessage('Kode verifikasi : ' . $token);

    $email->send();
  }

  public function reset(){
    $rules = [
        'resetPasswordCode'          => [
            'rules' => 'required',
            'errors' => [
                'required' => 'kode tidak boleh kosong',
            ],
        ],
        'resetPasswordEmail'         => [
           'rules' => 'required|min_length[6]|max_length[64]|valid_email',
           'errors' => [
                'required' => 'Email tidak boleh kosong',
                'min_length' => 'Email minimal {param} karakter',
                'max_length' => 'Email maksimal {param} karakter',
                'valid_email' => 'Email tidak valid',
           ]
        ],
        'newPassword'      => 'required|min_length[6]|max_length[200]',
        'newPasswordConfirm'  => 'matches[newPassword]'
    ];

    $email = $this->request->getPost('resetPasswordEmail');
    $token = $this->request->getPost('resetPasswordCode');
    $newPassword = $this->request->getPost('newPassword');

    $model = new TokenModel();
    if($this->validate($rules)){
        if($model->verifyToken($email, $token) === true){
            $data = [
                'password' => password_hash($newPassword[0], PASSWORD_DEFAULT),
            ];
            
            $adminModel = new AdminModel();
            $query = $adminModel->select('id')->where('email', $email)->first();
            $uid = $query['id'];
            $adminModel->update($uid, $data);
            $flashData = [
                'forgotPassword_notice' => "Password berhasil diubah",
            ];
            session()->setFlashdata($flashData);
            return redirect()->to('/');
        }else{
            $flashData = [
                'forgotPassword_notice' => "Kode verifikasi atau email salah",
            ];
            session()->setFlashdata($flashData);
            return redirect()->to('/resetpassword');
        }
    }
    else{
        $flashData = [
            'forgotPassword_notice' => \Config\Services::validation()->listErrors(),
        ];
        session()->setFlashdata($flashData);
        return redirect()->to('/resetpassword');
    }
} 

}
