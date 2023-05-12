<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class MonitoresModel extends \Com\Daw2\Core\BaseModel{
    
    
    private const SELECT_ALL = 'SELECT monitores.entrada_video,monitores.pulgadas,tecnologia.nombre_tecnología,monitores.tecnologia,monitores.refresco,productos.*,proveedores.nombre_proveedor FROM monitores LEFT JOIN productos ON monitores.nombre = productos.nombre LEFT JOIN tecnologia ON monitores.tecnologia = tecnologia.id_tecnologia LEFT JOIN proveedores ON  productos.proveedor = proveedores.id_proveedor';
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT monitores.*,tecnologia.nombre_tecnología FROM monitores LEFT JOIN tecnologia ON monitores.tecnologia = tecnologia.id_tecnologia WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
    function filterAll(): array{
       $stmt = $this->pdo->query(self::SELECT_ALL);
       return $stmt->fetchAll();
   }
}