<?php 
namespace App\Models;
date_default_timezone_set("America/Mazatlan");

use CodeIgniter\Model;

class AdModel extends Model{
    protected $table      = 'addatobasicos';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['nombre', 'link', 'estado', 'municipio', 'localidad', 'direccion'
    , 'referencia', 'colonia', 'cp', 'telefono', 'telefono2', 'email', 'sitioweb', 'facebook'
    , 'twitter', 'youtube', 'instagram', 'skype', 'keywordprimary', 'keywordsecondary', 'descripcion',
     'descripcion_adicional', 'logo', 'portada', 'horarios', 'comodidades', 'active', 'user_id', 'usuvoto',
      'voto', 'banner_lateral' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';

     
     public function dataUpdate($data , $id = null){
        
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $id);
        $builder->update($data);

     }

     public function dataUpdateFree($descripcion ,$telefono, $ubicacion, $id = null){
        
      $builder = $this->db->table($this->table);
      $builder->where('user_id', $id);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"), 
      'descripcion' => $descripcion, 'telefono' => $telefono, 'direccion' => $ubicacion]);
      

   }

     public function fileUpdate( $id, $fileName , $campo){

      $builder = $this->db->table($this->table);

      $builder->set($campo, $fileName);
      $builder->where('user_id', $id);
      $builder->update();
        

   }

     public function getAd($id = null){
        
      $builder = $this->db->table($this->table);
      $builder->select("*");
      $builder->where('user_id' , $id);
      $query = $builder->get();
      return $query->getResult();

   }

   
   public function anuncios(){
      $builder = $this->db->table($this->table);
      $builder->select('*');
      
      $where = "active = 0 OR active = 1";
      $builder->where($where);
      $builder->orderBy('rand ()');

      $query = $builder->get(4);
      return $query->getResult();

   }

   public function searching($buscar){
      $builder = $this->db->table($this->table);
      $builder->select('*');
      $where = "descripcion like '%$buscar%' or descripcion_adicional like '%$buscar%' or keywordprimary like '%$buscar%'
      or keywordsecondary like '%$buscar%' or nombre like '%$buscar%'";
      $builder->where($where);

      $query = $builder->get();
      return $query->getResult();

   }

   public function anunciosPortada(){
      
      
      $where = "active = 0 OR active = 1 or active = 2";
      $builder = $this->db->table($this->table);
      $builder->select('*');
      $builder->where($where);

      $query = $builder->get();
      return $query->getResult();

   }

   public function anuncio($id = null){

      $builder = $this->db->table($this->table);
      $builder->select('*');
      $builder->where('user_id', $id);

      $query = $builder->get();
      return $query->getResult();

   }


   public function dataUpdateGeneral($id = null, $nombre = null, $correo = null, $tel = null){
   
        
      $builder = $this->db->table($this->table);
      $builder->where('user_id', $id);
      $builder->update(['updated_at' => date("Y-m-d h:i:s"), 
      'nombre' => $nombre, 'email' => $correo
      ,'telefono' => $tel]);

   }

   public function anuncioGeo($id = null){

      $builder = $this->db->table($this->table);
      $builder->select('*');
      $builder->join('geo_maps', 'geo_maps.user_id = addatobasicos.user_id');
      
      $where = "addatobasicos.user_id = ".$id;
      $builder->where($where);

      $query = $builder->get();
      return $query->getResult();

   }

   public function horarios($id = null){

      $builder = $this->db->table($this->table);
      $builder->select('horarios');
      $where = "user_id = ".$id;
      $builder->where($where);

      $query = $builder->get();
      return $query->getResult();

   }
}