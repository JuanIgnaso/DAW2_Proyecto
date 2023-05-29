<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class ProductosGeneralModel extends \Com\Daw2\Core\BaseModel{
    
    const _SELECT_ALL = 'SELECT productos.*,categorias.*,proveedores.nombre_proveedor FROM productos LEFT JOIN categorias ON productos.categoria = categorias.id_categoria  LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor ';
     private const _UPDATE = 'UPDATE productos SET ';  
    
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
        return $stmt->fetch();
       
    }
    
    //Usar transacciones ya que se trata de un método que puede hacer
    //Múltiples actualizaciones
    function updateStock(array $carrito): bool{
        try {
            $this->pdo->beginTransaction();

            for($i = 0; $i < count($carrito); $i++) {
            $stmt = $this->pdo->prepare('UPDATE productos SET stock = stock - ? WHERE codigo_producto = ?'); 

                 $stmt->execute([intval($carrito[$i]['cantidad']),intval($carrito[$i]['codigo_producto'])]);

            }     
           $this->pdo->commit(); 
           return true;
        } catch (\PDOException $ex) {
            $this->pdo->rollback();
            return false;
        }

      }
      
    function deleteProduct($codigo): bool{
        $stmt = $this->pdo->prepare('DELETE FROM productos WHERE codigo_producto = ?'); 
        $urlimg = $this->getProductImg($codigo);
        if($urlimg != NULL){
          unlink(substr($urlimg,1,strlen($urlimg)));
        }
        return $stmt->execute([$codigo]);
    }
      
    
    function productNameExists($nombre): bool{
          $stmt = $this->pdo->prepare('SELECT nombre FROM productos WHERE nombre =?');
          $stmt->execute([$nombre]);
          return $stmt->rowCount() != 0;
    }
      
      
    function occupiedProductName($nombre,$codigo):bool{
          $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE nombre=? AND codigo_producto != ?');
          $stmt->execute([$nombre,$codigo]);
          return $stmt->rowCount() != 0; 
    }
      
    function insertProduct($categoria,array $post,$iva): bool{
        try{
            $this->pdo->beginTransaction();
            if(!isset($post['imagen_p'])){
                $post['imagen_p'] = NULL;
            }
            $post['iva'] = $iva;
            $stmt= $this->pdo->prepare('INSERT INTO productos(nombre,proveedor,categoria,marca,desc_producto,url_imagen,precio_bruto,iva,stock) values(?,?,?,?,?,?,?,?,?)');
            $stmt->execute([$post['nombre'],$post['proveedor'],$categoria,$post['marca'],$post['desc_producto'],$post['imagen_p'],$post['precio_bruto'],$post['iva'],$post['stock']]);
            $this->pdo->commit();  
            return true;
        } catch (\PDOException $ex) {
            $this->pdo->rollback();
            return false;
        }  
        
    }
      
      
       function editProduct(array $post,$codigo,$iva):bool{
            try{
                $this->pdo->beginTransaction();
                $post['iva'] = $iva;
                if(!isset($post['imagen_p'])){
                    $post['imagen_p'] = NULL;
                }
                $stmt= $this->pdo->prepare(self::_UPDATE.' nombre=?, proveedor=?, marca=?, desc_producto=?, url_imagen=?, precio_bruto=?, iva=?, stock=? WHERE codigo_producto=?');
                $stmt->execute([$post['nombre'],$post['proveedor'],$post['marca'],$post['desc_producto'],$post['imagen_p'],$post['precio_bruto'],$post['iva'],$post['stock'],$codigo]);
                $this->pdo->commit();  
                return true;
            } catch (\PDOException $ex) {
                  $this->pdo->rollback();
                  return false;
            }  
        
        }
        
        
        function getProductImg($codigo){
          $stmt = $this->pdo->prepare('SELECT url_imagen FROM productos WHERE codigo_producto=?');
          $stmt->execute([$codigo]);
          $var = $stmt->fetch();
          return $var['url_imagen']; 
        }
        
      
}