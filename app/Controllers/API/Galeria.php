<?php 
namespace App\Controllers\API;
use App\Models\GaleriaModel;
use CodeIgniter\RESTful\ResourceController;


class Galeria extends ResourceController{

    public function __construct(){
        $this->model = new GaleriaModel;
    }

    public function getAll()
    {
       $ads = $this->model->findAll();
         return $this->respond($ads);
    }

    
    public function getDataGaleria()
    {
       $id =  $this->request->getGet('id');
       $galeriaId = $this->request->getGet('galeria');

        $galeria = $this->model->getGaleryByUserAndId($id,$galeriaId);

        if ($galeria == null) {
          
            $data1 = [
            'nombre_galeria' => 'gallery',
            'url' => '1',
            'user_id' => $id,
            ''
        ];
        $data2 = [
            'nombre_galeria' => 'gallery',
            'url' => '2',
            'user_id' => $id,
            ''
        ];
        $data3 = [
            'nombre_galeria' => 'gallery',
            'url' => '3',
            'user_id' => $id,
            ''
        ];

            $this->model->insert($data1);
            $this->model->insert($data2);
            $this->model->insert($data3);

                return $this->respond(['id' => $id]);
            
            
        } else {
            return $this->respond($galeria);
        }

    }

}