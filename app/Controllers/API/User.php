<?php 
namespace App\Controllers\API;
use App\Models\AdModel;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class User extends ResourceController{

    public function __construct(){
        $this->model = new UserModel();
    }

    public function getAll()
    {
       $usuarios = $this->model->findAll();
         return $this->respond($usuarios);
    }

    public function create(){
        try {
            $usuario = $this->request->getJSON();
            $usuario->password = password_hash($usuario->password, PASSWORD_BCRYPT);
            if ($this->model->insert($usuario)) {
                $usuario->id = $this->model->insertID();

                return $this->respondCreated($usuario);
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
                $usuario = $this->model->find($id);
                if ($usuario == null) {
                    return $this->failNotFound("No se ha encontrado un usuario con el id : ".$id);
                }else{
                    return $this->respond($usuario);
                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function login($correo = null, $password = null){
        try {
            $usuarioData = $this->request->getJSON();
            $usuario = $this->model->where('email' , $usuarioData->email)->first();
            if ($usuario == null) {
                return $this->respond(['mensaje' => 'Usuario no encontrado'], 203);
            }
            if (password_verify($usuarioData->password, $usuario['password'])) {
              return $this->respond($usuario);
            } else
            return $this->respond(['mensaje' => 'Contraseña incorrecta'], 203);
            
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }


    public function restorePass(){
       

            $usuarioData = $this->request->getPost('correo');
            $telefono = $this->request->getPost('telefono');
            $password = $this->request->getPost('password');
            
            $newPass = password_hash(strval($password), PASSWORD_BCRYPT);

            $anuncio = new UserModel();
            $anuncioData = $anuncio->getUserPass($usuarioData,$telefono);

                if ($anuncioData == null) {
                    return $this->respond(['mensaje' => 'datos incorrectos'], 203);
                }else{

                   
        $restoreP = new UserModel;

        $restoreP->restorePass($usuarioData,$newPass);
        
        return $this->respond(['mensaje' => 'exito'], 200);

                }
           
            
    }



    public function update($id = null){
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $usuarioVerificado = $this->model->find($id);
                if ($usuarioVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un usuario con el id : ".$id);
                }else{
                    $usuario = $this->request->getJSON();
                    
            if ($this->model->update($id,$usuario)) {
                $usuario->id = $id;
                return $this->respondUpdated($usuario);
            } else{
                return $this->failValidationErrors($this->model->validation->listErrors());
            }

                }
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
                $usuarioVerificado = $this->model->find($id);
                if ($usuarioVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un usuario con el id : ".$id);
                }else{
                    
            if ($this->model->delete($id)) {
                return $this->respondDeleted($usuarioVerificado);
            } else{
                
            return $this->failServerError("No se ha podido eliminar el usuario");
            }

                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    
}