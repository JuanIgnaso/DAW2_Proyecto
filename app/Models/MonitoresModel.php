<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class MonitoresModel extends \Com\Daw2\Core\BaseModel{
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT monitores.*,tecnologia.nombre_tecnología FROM monitores LEFT JOIN tecnologia ON monitores.tecnologia = tecnologia.id_tecnologia WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
}