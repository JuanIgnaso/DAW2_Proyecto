<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class ProductosGeneralModel extends \Com\Daw2\Core\BaseModel{
    
    const _SELECT_ALL = 'SELECT productos.*,categorias.*,proveedores.nombre_proveedor FROM productos LEFT JOIN categorias ON productos.categoria = categorias.id_categoria  LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor ';
       
    //En funcion del valor recibido en el filterby de la URL
    private const _FILTER_BY = array(     
          1 => ' ORDER BY precio DESC',
          2 => ' ORDER BY precio ASC',
          3 => ' AND stock !=0',
          4 => ' ORDER BY codigo_producto DESC'
        );
    private const _DEFAULT_ORDER = ' ORDER BY codigo_producto';
    
    function showCategory($id,$filtros): ?array {
      try{        
         $fieldOrder = $this->orderBy($filtros);
        if(isset($filtros['buscar_por'])){

        $stmt = $this->pdo->prepare(self::_SELECT_ALL.'WHERE id_categoria=? AND '.$filtros['buscar_por'].' LIKE ?'.$fieldOrder);
        $stmt->execute([$id,'%'.$filtros['nombre'].'%']);
        
        }else{
        $stmt = $this->pdo->prepare(self::_SELECT_ALL.'WHERE id_categoria=?'.$fieldOrder);
        $stmt->execute([$id]);   
        }
        $array = $stmt->fetchAll();
        return count($array) != 0 ? $array : NULL;
        
      } catch (\PDOException $ex) {
        $stmt = $this->pdo->prepare(self::_SELECT_ALL.'WHERE id_categoria=? ORDER BY codigo_producto');
        $stmt->execute([$id]);
        return $stmt->fetchAll();
      }     
    }
    
    /***
     * Devuelve el orden por el cual se va a filtrar
     */
    private function orderBy($filtros): string{
       if(isset($filtros['filterby']) && filter_var($filtros['filterby'],FILTER_VALIDATE_INT)){
            if($filtros['filterby'] <= count(self::_FILTER_BY) && $filtros['filterby'] >= 1){
                $fieldOrder = self::_FILTER_BY[$filtros['filterby']];
            }else{
               
                $fieldOrder = self::_DEFAULT_ORDER;
            }
        }else{
                //$filtros['filterby'] = self::DEFAULT_ORDER;
                $fieldOrder = self::_DEFAULT_ORDER;
        }  
        return $fieldOrder;
    }
    
    function getProduct($nombre) {
        $stmt = $this->pdo->prepare(self::_SELECT_ALL.' WHERE productos.nombre LIKE ?');
        $stmt->execute(['%'.$nombre.'%']);
        //var_dump($stmt);
        return $stmt->fetch();
       
    }
    
    function updateStock($id,$cantidad){
        $condiciones = [];
        $condiciones['id'] = $id;
        $condiciones['cantidad'] = $cantidad;
        $stmt = $this->pdo->prepare('update productos set("stock" = ((select(stock) FROM productos WHERE codigo_producto = :id)-:cantidad) ) WHERE codigo_producto = :id'); 
         return $stmt->execute($condiciones);
      }
    
}