<?php 
namespace App\Controllers\API;

use App\Models\MapaModel;
use CodeIgniter\RESTful\ResourceController;

class Mapa extends ResourceController{

    public function __construct(){
        $this->model = new MapaModel();
    }

    public function getAll()
    {
       $mapas = $this->model->findAll();
         return $this->respond($mapas);
    }

    public function create(){
        try {
            $mapa = $this->request->getJSON();
            if ($this->model->insert($mapa)) {
                $mapa->id = $this->model->insertID();

                return $this->respondCreated($mapa);
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
                $mapa = new MapaModel();
                $mapaData = $mapa->getMapa($id);
                if ($mapaData == null) {
                    return $this->failNotFound("No se ha encontrado un ad con el id : ".$id);
                }else{
                    return $this->respond($mapaData);
                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function login($correo = null, $password = null){
        try {
            $mapaData = $this->request->getJSON();
            $mapa = $this->model->where('email' , $mapaData->email)->first();
            if ($mapa == null) {
                return $this->respond(['mensaje' => 'mapa no encontrado'], 203);
            }
            if (password_verify($mapaData->password, $mapa['password'])) {
              return $this->respond($mapa);
            } else
            return $this->respond(['mensaje' => 'Contraseña incorrecta'], 203);
            
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }



    public function update($id = null){

        $data = $this->request->getJSON();
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $mapaModel = new MapaModel;
                $mapaModel->dataUpdate($data, $id);

                return $this->respondUpdated(
                    ['id' => $id]
                );
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
                $mapaVerificado = $this->model->find($id);
                if ($mapaVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un mapa con el id : ".$id);
                }else{
                    
            if ($this->model->delete($id)) {
                return $this->respondDeleted($mapaVerificado);
            } else{
                
            return $this->failServerError("No se ha podido eliminar el mapa");
            }

                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }
    
}