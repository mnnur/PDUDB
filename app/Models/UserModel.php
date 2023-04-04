<?php 
namespace App\Models;
 
use CodeIgniter\Model;
 
class UserModel extends Model{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'alamat'];

    public function getAllUserData(){
        $query = $this->select('*')->get();

        return $query->getResultArray();
    }
}

