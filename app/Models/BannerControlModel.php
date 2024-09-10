<?php 
namespace App\Models;

use CodeIgniter\Model;

class BannerControlModel extends Model{
    protected $table      = 'banners_controls';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['image','title' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';
     public function bannerAleatorio(){

        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->orderBy('rand ()');
  
        $query = $builder->get(1);
        return $query->getResult();
  
     }
    
}