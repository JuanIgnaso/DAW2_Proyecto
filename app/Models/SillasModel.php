<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class SillasModel extends \Com\Daw2\Core\BaseModel{
 
    private const SELECT_ALL = 'SELECT sillas.tipo_silla,sillas.altura,sillas.anchura,sillas.ajustable,productos.*,proveedores.nombre_proveedor FROM sillas LEFT JOIN productos ON sillas.nombre = productos.nombre LEFT JOIN proveedores ON productos.proveedor =  proveedores.id_proveedor';
    
        
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT * FROM sillas WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
        function filterAll(): array{
       $stmt = $this->pdo->query(self::SELECT_ALL);
       return $stmt->fetchAll();
   }
}

