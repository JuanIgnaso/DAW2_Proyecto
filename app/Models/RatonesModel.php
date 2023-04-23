<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class RatonesModel extends \Com\Daw2\Core\BaseModel{
    
    
       function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT ratones.nombre,ratones.dpi,ratones.clase,conexiones_raton.nombre_conectividad_raton FROM ratones LEFT JOIN conexiones_raton ON ratones.id_conexion = conexiones_raton.id_conexion WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
}
