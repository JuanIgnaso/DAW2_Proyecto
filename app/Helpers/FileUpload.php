<?php

namespace Com\Daw2\Helpers;


class FileUpload{
    
    private $directorio;
    
    public function __construct(string $directorio){
        $this->directorio = $directorio;
    }

    function uploadPhoto(): bool{
        $dir = $this->directorio;
        $src = $_FILES['imagen']['tmp_name'];
        $output_dir = $dir.basename($_FILES['imagen']['name']);
        
        if(!is_dir($dir)){
            mkdir($dir, 0775, true);
        }
        
        if(move_uploaded_file($src,$output_dir)){
            return true;
        }else{
            return false;
        }
        
    }
    
}