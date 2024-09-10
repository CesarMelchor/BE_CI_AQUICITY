<?php 
namespace App\Models;

use CodeIgniter\Model;

class MapaModel extends Model{
    protected $table      = 'geo_maps';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['linkframe', 'user_id' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';

     public function getMapa($id = null){
        
        $builder = $this->db->table($this->table);
        $builder->select("*");
        $builder->where('user_id' , $id);
        $query = $builder->get();
        return $query->getResult();
  
     }

     public function dataUpdate($data , $id = null){
        
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $id);
        $builder->update($data);

     }
    
}