<?php 
namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model{
    protected $table      = 'sucursals';
    protected $primaryKey = 'id';
    protected $returnedType = 'array';
    protected $allowedFields = ['nombre_suscursal', 'email', 'telefono', 'cuidad', 
    'estado','direccion',
'user_id' ];
     protected $useTimestamps = true;
     protected $createdField = 'created_at';
     protected $updatedField = 'updated_at';


    
}