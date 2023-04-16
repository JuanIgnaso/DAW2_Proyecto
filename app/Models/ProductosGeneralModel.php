<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class ProductosGeneralModel extends \Com\Daw2\Core\BaseModel{
       
    //En funcion del valor recibido en el filterby de la URL
    private const _FILTER_BY = array(
          1 => ' ORDER BY precio DESC',
          2 => ' ORDER BY precio ASC',
          3 => ' AND stock !=0',
          4 => ' ORDER BY codigo_producto DESC'
        );
    
    
    function showCategory($id,$filtros): ?array{
        
        if(isset($filtros['filterby']) && filter_var($filtros['filterby'],FILTER_VALIDATE_INT)){
            if($filtros['filterby'] <= count(self::_FILTER_BY) && $filtros['filterby'] >= 1){
                $fieldOrder = self::_FILTER_BY[$filtros['filterby']];
            }else{
                //$filtros['filterby'] = self::DEFAULT_ORDER;
                $fieldOrder = NULL;
            }
        }else{
                //$filtros['filterby'] = self::DEFAULT_ORDER;
                $fieldOrder = NULL;
        }
        
        if($fieldOrder != NULL){
        $stmt = $this->pdo->prepare('SELECT productos.*,categorias.*,proveedores.nombre_proveedor FROM productos LEFT JOIN categorias ON productos.categoria = categorias.id_categoria  LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor WHERE id_categoria=?'.$fieldOrder);
        $stmt->execute([$id]); 
        }else{
        $stmt = $this->pdo->prepare('SELECT productos.*,categorias.*,proveedores.nombre_proveedor FROM productos LEFT JOIN categorias ON productos.categoria = categorias.id_categoria  LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor WHERE id_categoria=?');
        $stmt->execute([$id]); 
        }
        $array = $stmt->fetchAll();
        return count($array) != 0 ? $array : NULL;
        
    }
    
    
}