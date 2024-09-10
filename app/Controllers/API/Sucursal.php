<?php 
namespace App\Controllers\API;
use App\Models\SucursalModel;
use CodeIgniter\RESTful\ResourceController;

class Sucursal extends ResourceController{

    public function __construct(){
        $this->model = new SucursalModel();
    }

    public function getAll()
    {
       $sucursales = $this->model->findAll();
         return $this->respond($sucursales);
    }

    public function create(){
        try {
            $sucursal = $this->request->getJSON();
            if ($this->model->insert($sucursal)) {
                $sucursal->id = $this->model->insertID();

                return $this->respondCreated($sucursal);
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
                $sucursal = $this->model->find($id);
                if ($sucursal == null) {
                    return $this->failNotFound("No se ha encontrado un sucursal con el id : ".$id);
                }else{
                    return $this->respond($sucursal);
                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function login($correo = null, $password = null){
        try {
            $sucursalData = $this->request->getJSON();
            $sucursal = $this->model->where('email' , $sucursalData->email)->first();
            if ($sucursal == null) {
                return $this->respond(['mensaje' => 'sucursal no encontrado'], 203);
            }
            if (password_verify($sucursalData->password, $sucursal['password'])) {
              return $this->respond($sucursal);
            } else
            return $this->respond(['mensaje' => 'Contraseña incorrecta'], 203);
            
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }



    public function update($id = null){
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $sucursalVerificado = $this->model->find($id);
                if ($sucursalVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un sucursal con el id : ".$id);
                }else{
                    $sucursal = $this->request->getJSON();
                    
            if ($this->model->update($id,$sucursal)) {
                $sucursal->id = $id;
                return $this->respondUpdated($sucursal);
            } else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }

                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }


    
    public function uploadFile(){
        try {

            if ($file = $this->request->getFile('image')) {
                $newName = $file->getRandomName();
                $img = $this->request->getFile('image');
                $img->move(WRITEPATH . 'uploads', $newName);
            }


        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }


    public function delete($id = null){
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $sucursalVerificado = $this->model->find($id);
                if ($sucursalVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un sucursal con el id : ".$id);
                }else{
                    
            if ($this->model->delete($id)) {
                return $this->respondDeleted($sucursalVerificado);
            } else{
                
            return $this->failServerError("No se ha podido eliminar el sucursal");
            }

                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
    
}