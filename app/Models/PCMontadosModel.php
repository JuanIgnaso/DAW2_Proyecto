<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class PCMontadosModel extends \Com\Daw2\Core\BaseModel{
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT * FROM PC_montados WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
}