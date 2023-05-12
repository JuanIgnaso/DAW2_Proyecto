<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class RatonesModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT proveedores.nombre_proveedor,productos.*,ratones.dpi,ratones.clase,conexiones_raton.nombre_conectividad_raton FROM ratones LEFT JOIN conexiones_raton ON ratones.id_conexion = conexiones_raton.id_conexion LEFT JOIN productos ON productos.nombre = ratones.nombre LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor';
    
    
       function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT ratones.nombre,ratones.dpi,ratones.clase,conexiones_raton.nombre_conectividad_raton FROM ratones LEFT JOIN conexiones_raton ON ratones.id_conexion = conexiones_raton.id_conexion WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
   function filterAll(): array{
       $stmt = $this->pdo->query(self::SELECT_ALL);
       return $stmt->fetchAll();
   }
}
