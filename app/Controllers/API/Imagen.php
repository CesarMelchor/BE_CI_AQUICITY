<?php 
namespace App\Controllers\API;

use App\Models\ImagenModel;
use CodeIgniter\RESTful\ResourceController;


class Imagen extends ResourceController{

    public function __construct(){
        $this->model = new ImagenModel();
    }

    public function getAll()
    {
       $ads = $this->model->findAll();
         return $this->respond($ads);
    }

        public function uploadFile(){
            try {
                
                $tipo = $this->request->getPost('tipo');
                $galeria = $this->request->getPost('galeria_id');
                $descripcion = $this->request->getPost('descripcion');
                $lastImage = $this->request->getPost('image_last');
                $locate = $this->request->getPost('locate');


                if ($tipo == "subir") {
                    
                if ($file = $this->request->getFile('file')) {
        
                    if (! $file->hasMoved()) {
        
                        $newName = $file->getRandomName(); 
                    
                        $file->move(WRITEPATH.'/uploads'.$locate, $newName);
    
                        
                        $imageModel = new ImagenModel;
                        $imageModel->imageUpdate($galeria,$lastImage,'/uploads/galerias/'.$newName, $descripcion);
    
        
                        return $this->respond(['mensaje' => '/uploads/galerias/'.$newName], 200);
        
                    }
                    return $this->respond(['mensaje' => 'el archivo existe'], 203);
                }
                else{
                    return $this->respond(['mensaje' => 'Imagen no recibida'], 203);
                }



                }
                // Eliminar y modificar imagen anterior
                else{

                    
                    $path_to_file = WRITEPATH.$lastImage;
    
                    if(unlink($path_to_file)) {
                        if ($file = $this->request->getFile('file')) {
        
                            if (! $file->hasMoved()) {
                                
                
                                $newName = $file->getRandomName(); 
                
                                $file->move(WRITEPATH.'/uploads/galerias/', $newName);
            
                                
                                $imageModel = new ImagenModel;
                                $imageModel->imageUpdate($galeria,$lastImage,'/uploads/galerias/'.$newName, $descripcion);
            
                
                                return $this->respond(['mensaje' => '/uploads/galerias/'.$newName], 200);
                
                            }
                            return $this->respond(['mensaje' => 'el archivo existe'], 203);
                        }
                        else{
                            return $this->respond(['mensaje' => 'Imagen no recibida'], 203);
                        }

                    }
                    else{
                        
                        return $this->respond(['mensaje' => 'Error al borrar la imagen previa'], 203);
                    }

                  



                }
        
        
            } catch (\Exception $e) {
                return $this->failServerError("Ha ocurrido un error en el servidor");
            }
        
        
              
            }
    

    
    public function getImagenes()
    {
       $id =  $this->request->getGet('galeria');

        $imagenes = $this->model->getImagesByGalery($id);

        if ($imagenes == null) {

            $data = [
                'url' => '1',
                'galery_id' => $id,
                'descripcion' => 'no',
            ];

            $this->model->insert($data);

            $data = [
                'url' => '2',
                'galery_id' => $id,
                'descripcion' => 'no',
            ];

            $this->model->insert($data);

            $data = [
                'url' => '3',
                'galery_id' => $id,
                'descripcion' => 'no',
            ];

            $this->model->insert($data);

            $data = [
                'url' => '4',
                'galery_id' => $id,
                'descripcion' => 'no',
            ];

            $this->model->insert($data);

            $data = [
                'url' => '5',
                'galery_id' => $id,
                'descripcion' => 'no',
            ];

            $this->model->insert($data);

          
        $imagenes = $this->model->getImagesByGalery($id);
        return $this->respond($imagenes);
            
            
        } else {
            return $this->respond($imagenes);
        }

    }

}