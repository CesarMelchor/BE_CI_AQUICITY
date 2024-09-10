<?php 
namespace App\Models;
date_default_timezone_set("America/Mazatlan");

use CodeIgniter\Model;

class CodigoModel extends Model{
    protected $table      = 'codes';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['code','auth','type_code', 'user_id' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';

     public function getCode($code = null){
        
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $where = "code = '".$code."' and user_id = 0 OR user_id = NULL";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
  
     }

     public function updateCodeNegocio($id = null, $code = null){

    
         $builder2 = $this->db->table($this->table);
         $builder2->where('code', $code);
         $builder2->update(['updated_at' => date("Y-m-d h:i:s"), 'user_id' => $id]);

         
         $builder3 = $this->db->table('addatobasicos');
         $builder3->where('user_id', $id);
         $builder3->update(['updated_at' => date("Y-m-d h:i:s"), 'active' => 1]);

   }

     public function dataUpdate($id = null){

        $builder2 = $this->db->table('addatobasicos');
        $builder2->where('user_id', $id);
        $builder2->update(['updated_at' => date("Y-m-d h:i:s"), 'active' => 1]);
        
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $id);
        $builder->update(['updated_at' => date("Y-m-d h:i:s"), 'auth' => 1]);

     }

     public function dataUpdate2($id = null){

      
      $builder2 = $this->db->table('addatobasicos');
      $builder2->where('user_id', $id);
      $builder2->update(['updated_at' => date("Y-m-d h:i:s"), 'active' => 2]);
        
      $builder = $this->db->table($this->table);
      $builder->where('user_id', $id);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"), 'auth' => 2]);

   }

  

    
}