<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class SillasModel extends \Com\Daw2\Core\BaseModel{
 
        
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT * FROM sillas WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
}

