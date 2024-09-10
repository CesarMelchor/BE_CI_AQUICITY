<?php 
namespace App\Controllers\API;

use App\Models\BannerControlModel;
use CodeIgniter\RESTful\ResourceController;


class BannerControl extends ResourceController{

    public function __construct(){
        $this->model = new BannerControlModel();
    }

    public function getAll()
    {
       $banners = $this->model->findAll();
         return $this->respond($banners);
    }

    public function getAleatorio()
    {
        $aleatorio = new BannerControlModel;
        $banner = $aleatorio->bannerAleatorio();

         return $this->respond($banner);
    }


    public function uploadFile(){
        try {


            if ($file = $this->request->getFile('file')) {
    
                $title = $this->request->getPost('title');
                $locate = $this->request->getPost('locate');
                if (! $file->hasMoved()) {
                    
                    $newName = $file->getRandomName(); 
    
                    $file->move(WRITEPATH.'/uploads'.$locate, $newName);
                    
                    if ($this->model->insert(['image' => '/uploads/banners/'.$newName, 'title'=>'Banner control'])) {

                        return $this->respond(['mensaje'=>'Imagen cargada',200]);
        
                    } else{
        
                        return $this->failValidationErrors($this->model->validation->listErrors());
        
                    }
    
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

    




    public function deleteFile(){
        try {

            $last = $this->request->getPost('image');
            $id = $this->request->getPost('id');

            if ($id == null) {

                return $this->failServerError("No se ha encontrado un ID válido");
            }
            else
            {
                    
            if ($this->model->delete($id)) {


                        $path_to_file = WRITEPATH.$last;
    
                        if(unlink($path_to_file)) {
    
                            return $this->respond(['mensaje' => 'Archivo eliminado'], 200);
                             
                        }

                        return $this->respond(['mensaje' => $id], 200);

            } else{
                
            return $this->failServerError("No se ha podido eliminar el ad");

            }

                
            }
        } catch (\Exception $e) {
            return $this->failServerError("Ha ocurrido un error en el servidor".$last);
        }
    }

    
}