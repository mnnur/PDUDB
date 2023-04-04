<?php 
namespace App\Models;
 
use CodeIgniter\Model;
 
class TokenModel extends Model{
    protected $table = 'tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'token', 'created', 'expired'];

    public function isDuplicated(string $token){
        $query = $this->select('token')->where('token', $token)->first();
        if($query === null){
            return false;
        }
        return true;
    }

    public function verifyToken(string $email, string $token){
        $query = $this->select('*')->where('email', $email)->first();
    
        if($query === null){
            return false;
        }
    
        $now = strtotime($this->query('SELECT now() as now')->getRow()->now); // Get the current timestamp in Unix format from database
        $current_time = strtotime('+1 second', $now);
    
        $created = strtotime($query['created']); // Convert the 'created' timestamp to Unix format
        $expired = strtotime($query['expired']); // Convert the 'expired' timestamp to Unix format
    
        if(($query['token'] === $token) && ($current_time >= $created) && ($current_time <= $expired)){
            return true;
        }
    
        return false;
    }
    
}

