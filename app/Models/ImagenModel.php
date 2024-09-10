<?php 
namespace App\Models;
date_default_timezone_set("America/Mexico_City");

use CodeIgniter\Model;

class ImagenModel extends Model{
    protected $table      = 'imagen_galerias';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['url','galery_id','descripcion'];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';

     public function getImagesByGalery($galeria = null){
        
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('galery_id', $galeria);
        $query = $builder->get();
        return $query->getResult();
  
     }

     public function imageUpdate($galeria = null, $url = null, $newImage = null, $descripcion = null){
        
        $builder = $this->db->table($this->table);
        $builder->where('galery_id', $galeria);
        $builder->where('url', $url);
        $builder->update(['url' => $newImage, 'descripcion' => $descripcion]);

     }

     public function dataUpdate2($id = null){
        
      $builder = $this->db->table($this->table);
      $builder->where('user_id', $id);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"), 'auth' => 2]);

   }

    
}