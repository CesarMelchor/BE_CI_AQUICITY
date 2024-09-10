<?php 
namespace App\Controllers\API;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use App\Models\AdModel;
use DateTime;
use Kint\Parser\ToStringPlugin;

date_default_timezone_set("America/Mazatlan");



class Ad extends ResourceController{

    public function __construct(){
        $this->model = new AdModel();
    }

    public function getAll()
    {
       $ads = $this->model->findAll();
         return $this->respond($ads);
    }

    
    public function getAnuncios()
    {
        $anuncioData = $this->model->anuncios();

        return $this->respond($anuncioData);
    }

    public function getAnunciosPortada()
    {
        $anuncioData = $this->model->anunciosPortada();

        return $this->respond($anuncioData);
    }

    public function getAnuncio($id = null)
    {
        $anuncioData = $this->model->anuncio($id);

        return $this->respond($anuncioData);
    }

    public function updateDataGeneral(){

        try {

            $id = $this->request->getPost('id');
            $nombre = $this->request->getPost('nombre');
            $correo = $this->request->getPost('correo');
            $tel = $this->request->getPost('telefono');

            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                
        $adModel = new AdModel;

        $adModel->dataUpdateGeneral($id,$nombre,$correo,$tel);

        return $this->respondUpdated();
            
                
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function create(){
        try {
            $ad = $this->request->getJSON();
            if ($this->model->insert($ad)) {
                $ad->id = $this->model->insertID();
                return $this->respondCreated($ad);
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
                $anuncio = new AdModel();
                $anuncioData = $anuncio->getAd($id);
                if ($anuncioData == null) {
                    return $this->failNotFound("No se ha encontrado un ad con el id : ".$id);
                }else{


                    /*
                    $dayActual = date("l");
                    $horaActual = new DateTime(date("H:i"));

                    switch ($dayActual) {
                        case 'Thursday':
                            

                $horaApertura1 = new DateTime('20:00');
                $horaCierre1 = new DateTime('20:00');
                $horaApertura2 = new DateTime('20:00');
                $horaCierre2 = new DateTime('20:00');
                $interval = $horaApertura1->diff($horaActual);
                

                $status = ['horas' => $interval->format('%H')];
                $horarios = $anuncioData[0];
                $nuevo = $anuncioData[0]->horarios;

                array_push($anuncioData, $status. ' menos' . strval($anuncioData[0]->horarios));

                
                return $this->respond($nuevo);
                            
                        
                        default:
                            # code...
                            break;
                    }


*/
                    


                    return $this->respond($anuncioData);
                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function detailFree($id = null){
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $anuncio = new AdModel();
                $anuncioData = $anuncio->anuncioGeo($id);
                if ($anuncioData == null) {
                    return $this->failNotFound("No se ha encontrado un ad con el id : ".$id);
                }else{
                    return $this->respond($anuncioData);
                }
            }
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
                $adModel = new AdModel;
                $adModel->dataUpdate($data, $id);

                return $this->respondUpdated(
                    ['id' => $id]
                );
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    public function updateFree(){

        $id = $this->request->getPost('id');
        $descripcion = $this->request->getPost('descripcion');
        $telefono = $this->request->getPost('telefono');
        $ubicacion = $this->request->getPost('ubicacion');
        try {
            if ($id == null) {
                return $this->failServerError("No se ha encontrado un ID válido");
            }else{
                $adModel = new AdModel;
                $adModel->dataUpdateFree($descripcion,$telefono,$ubicacion,$id);

                return $this->respond(
                    ['id' => $id], 200
                );
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
                $adVerificado = $this->model->find($id);
                if ($adVerificado == null) {
                    return $this->failNotFound("No se ha encontrado un ad con el id : ".$id);
                }else{
                    
            if ($this->model->delete($id)) {
                return $this->respondDeleted($adVerificado);
            } else{
                
            return $this->failServerError("No se ha podido eliminar el ad");
            }

                }
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    }

    
    
    public function uploadFile(){
        try {
    
            if ($file = $this->request->getFile('file')) {
    
                if (! $file->hasMoved()) {
                    
                    $locate = $this->request->getPost('locate');
                    $id = $this->request->getPost('id');
                    $campo = $this->request->getPost('campo');
    
                    $newName = $file->getRandomName(); 
    
                    $file->move(WRITEPATH.'/uploads'.$locate, $newName);

                    
                    $adModel = new AdModel;
                    $adModel->fileUpdate($id,'/uploads'.$locate.$newName,$campo);

    
                    return $this->respond(['mensaje' => '/uploads'.$locate.$newName], 200);
    
                }
                return $this->respond(['mensaje' => 'el archivo existe'], 203);
            }
            else{
                return $this->respond(['mensaje' => 'Imagen no recibida'], 203);
            }
    
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor");
        }
    
    
          
        }
    
        public function updateFile(){
            try {
                        
                        $last = $this->request->getPost('lastImage');
                        $locate = $this->request->getPost('locate');
                        $id = $this->request->getPost('id');
                        $campo = $this->request->getPost('campo');

                        $path_to_file = WRITEPATH.$last;
    
                        if(unlink($path_to_file)) {
    
                            if ($file = $this->request->getFile('file')) {
    
                                if (! $file->hasMoved()) {
                                    
                    
                                    $newName = $file->getRandomName(); 
                    
                                    $file->move(WRITEPATH.'/uploads'.$locate, $newName);

                                    
                                    $adModel = new AdModel;
                                    $adModel->fileUpdate($id,'/uploads'.$locate.$newName,$campo);
                    
                                    return $this->respond(['mensaje' => '/uploads'.$locate.$newName], 200);
                    
                                }
                                return $this->respond(['mensaje' => 'el archivo existe'], 203);
                            }
                            else{
                                return $this->respond(['mensaje' => 'Imagen no recibida'], 203);
                            }
    
                             
                        }
                        else {
                            
                            if ($file = $this->request->getFile('file')) {
    
                                if (! $file->hasMoved()) {
                                    
                    
                                    $newName = $file->getRandomName(); 
                    
                                    $file->move(WRITEPATH.'/uploads'.$locate, $newName);

                                    $adModel = new AdModel;
                                    $adModel->fileUpdate($this->request->getPost('id'),'/uploads'.$locate.$newName 
                                    ,$this->request->getPost('campo'));
                    
                                    return $this->respond(['mensaje' => 'carga exitosa'], 200);
                    
                                }
                                return $this->respond(['mensaje' => 'el archivo existe'], 203);
                            }
                            else{
                                return $this->respond(['mensaje' => 'Imagen no recibida', 
                                'error' => 'Error al borrar el archivo anterior'], 203);
                            }
    
                        }
                        
                
            } catch (\Exception $e) {
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }
        
        
              
            }

            public function search(){
                $busqueda = $this->request->getGet('buscar');
                
                $result = $this->model->searching($busqueda);

                if ($result == null) {
                    return $this->respond(['mensaje' => 'sin resultados', 203]);
                }else{
                    return $this->respond($result, 200);
                }
            }

         
    
}