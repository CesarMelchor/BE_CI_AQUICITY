<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['name', 'email', 'telefono', 'password', 'remember_token' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';
     protected $emailField = 'email_verified_at';

     public function idLogin($email = null , $pass = null){
        
        $builder = $this->db->table($this->table);
        $builder->select("id");
        $builder->where('email' , $email);
        $builder->where('password' , $pass);
        $query = $builder->get();
        return $query->getResult();

     }

     public function restorePass($correo, $pass){
   
        
      $where = "email = '".$correo."'";
      $builder = $this->db->table($this->table);
      $builder->where($where);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"),'password' => $pass]);

   }

   public function getUserPass($correo = null,$telefono){
   
        
       
      $where = "email = '".$correo."' and telefono='".$telefono."'";
      $builder = $this->db->table($this->table);
      $builder->select('*');
      $builder->where($where);

      $query = $builder->get();
      return $query->getResult();

   }

 
    
}