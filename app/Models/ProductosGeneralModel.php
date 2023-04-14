<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class ProductosGeneralModel extends \Com\Daw2\Core\BaseModel{
       
    
    function showCategory($id): ?array{
        $stmt = $this->pdo->prepare('SELECT productos.*,categorias.*,proveedores.nombre_proveedor FROM productos LEFT JOIN categorias ON productos.categoria = categorias.id_categoria  LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor WHERE id_categoria=? ');
        $stmt->execute([$id]);
        $array = $stmt->fetchAll();
        return count($array) != 0 ? $array : NULL;
        
    }
    
    
}