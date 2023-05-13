<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class ConsolasModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT productos.*,consolas.juego_incluido,consolas.manual_usuario,consolas.mando_incluido,consolas.conectividad,conexiones_raton.nombre_conectividad_raton,proveedores.nombre_proveedor FROM consolas LEFT JOIN productos ON consolas.nombre = productos.nombre LEFT JOIN proveedores ON  productos.proveedor =  proveedores.id_proveedor  LEFT JOIN conexiones_raton ON consolas.conectividad = conexiones_raton.id_conexion';
    
    
        function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT consolas.nombre,consolas.juego_incluido,consolas.manual_usuario,consolas.mando_incluido,conexiones_raton.nombre_conectividad_raton FROM consolas LEFT JOIN conexiones_raton ON consolas.conectividad = conexiones_raton.id_conexion WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
         function filterAll(): array{
       $stmt = $this->pdo->query(self::SELECT_ALL);
       return $stmt->fetchAll();
   }
}