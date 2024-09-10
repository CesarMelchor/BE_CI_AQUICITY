<?php 
namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CodigoModel;

class Codigo extends ResourceController{

    public function __construct(){
        $this->model = new CodigoModel();
    }

    public function getAll()
    {
       $codigos = $this->model->findAll();
         return $this->respond($codigos);
    }

    public function create(){
        try {
            $codigo = $this->request->getJSON();
            if ($this->model->insert($codigo)) {
                $codigo->id = $this->model->insertID();
                return $this->respondCreated($codigo);
            } else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    
    public function detail($id = null){
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                
                $codigo = new codigoModel();
                $codigoData = $codigo->getcodigo($id);
                if ($codigoData == null) {
                    return $this->failNotFound("No se ha encontrado un codigo con el id : ".$id);
                }else{
                    return $this->respond($codigoData);
                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }


  
    public function activateCode($id = null){

        $adModel = new CodigoModel;
        

        $adModel->dataUpdate($id);
        return $this->respondUpdated();

    }

    public function desactivateCode($id = null){

        $adModel = new CodigoModel;
        $adModel->dataUpdate2($id);
        return $this->respondUpdated();

    }

    public function updateCode(){
        $codigo = $this->request->getPost('code');
        $id = $this->request->getPost('id');

       
           
             $codidoUpdate = new CodigoModel();
             $validateCode = new CodigoModel();
             if ($validateCode->getCode($codigo) == null) {
                
                return $this->respond(['mensaje' => 'codigo inválido'], 203);

             }else{
                $codidoUpdate->updateCodeNegocio($id,$codigo);
                return $this->respond(['mensaje' => 'actualizado'], 200); 
             }
        
        

    }


    

    
}