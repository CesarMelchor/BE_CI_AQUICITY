<?php 
namespace App\Models;
date_default_timezone_set("America/Mexico_City");

use CodeIgniter\Model;

class GaleriaModel extends Model{
    protected $table      = 'galerias';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['nombre_galeria','url','user_id'];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';

     public function getGaleryByUserAndId($user = null, $galeria = null){
        
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('user_id', $user);
        $builder->where('url', $galeria);
        $query = $builder->get();
        return $query->getResult();
  
     }

     public function dataUpdate($id = null){
        
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $id);
        $builder->update(['updated_at' => date("Y-m-d h:i:s"), 'auth' => 1]);

     }

     public function dataUpdate2($id = null){
        
      $builder = $this->db->table($this->table);
      $builder->where('user_id', $id);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"), 'auth' => 2]);

   }

    
}