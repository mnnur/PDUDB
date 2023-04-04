<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Userdb extends ResourceController
{
  use ResponseTrait;

  protected $model;
  protected $format = 'json';

  public function __construct()
  {
    $this->model = new UserModel();
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

  public function index()
  {
    $data = $this->model->findAll();

    return $this->respond($this->formatResponse(200, $data, null, 'Mendapatkan semua data berhasil'), 200);
  }

  public function show($id = null)
  {
    $data = $this->model->find($id);

    if ($data){
      return $this->respond($this->formatResponse(200, $data, null, 'Data ditemukan'), 200);
    }
    return $this->failNotFound('Data tidak ditemukan');
  }

  public function create()
  {
      // Get the request data
      $requestData = $this->request->getJSON(true);
  
      // Map the request data to the database columns
      $data = [
          'nama' => $requestData['nama'],
          'alamat' => $requestData['alamat']
      ];
  
      // Insert the data into the database using the model
      if ($this->model->insert($data)) {
          return $this->respondCreated($this->formatResponse(201, null, null, 'Data berhasil ditambahkan'));
      } else {
          return $this->failServerError();
      }
  }

  public function update($id = null)
  {
    $requestData = $this->request->getJSON(true);

    $data = [
        'nama' => $requestData['nama'],
        'alamat' => $requestData['alamat']
    ];

    if ($this->model->update($id, $data)){
      return $this->respondUpdated($this->formatResponse(200, null, null, 'Data berhasil diperbarui'));
    }
    return $this->failNotFound('Data tidak ditemukan');
  }

  public function delete($id = null)
  {
    if ($this->model->find($id)) {
      $this->model->delete($id);
      return $this->respondDeleted($this->formatResponse(200, null, null, 'Data berhasil dihapus'));
    }
    return $this->failNotFound('Data tidak ditemukan');
  }
}
