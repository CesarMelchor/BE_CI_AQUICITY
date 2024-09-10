<?php



class Ejercicio{

  
    public function casas($c,$x){
        $c = 3;
        $x = 1;

        if (($x % 2) == 0) {
            
            echo 'Es un número par';
        } else {
            //Es un número impar
            echo 'Es un número impar';
        }

        $derecha = array();
        $izquierda = array();
        
        for ($i=1; $i <= $c; $i++) {
        
            $iz = $c * 2;
        
            if ($i == 1) {
            $derecha = array_push($derecha, $i);
            }else{
            $f = $i + 2;
            $derecha = array_push($derecha, $f);
            }
            if ($c == 1) {
                $izquierda = array_push($izquierda,2);
        
            }else{
                $izquierda = array_push($izquierda,$iz);
            }
        
        $c--;
        
        }
    }


}



