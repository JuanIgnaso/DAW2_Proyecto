<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class ConsolasModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT productos.*,consolas.juego_incluido,consolas.id_consola,consolas.manual_usuario,consolas.mando_incluido,consolas.conectividad,conexiones_raton.nombre_conectividad_raton,proveedores.nombre_proveedor FROM consolas LEFT JOIN productos ON consolas.nombre = productos.nombre LEFT JOIN proveedores ON  productos.proveedor =  proveedores.id_proveedor  LEFT JOIN conexiones_raton ON consolas.conectividad = conexiones_raton.id_conexion';
    
    private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','juego_incluido','mando_incluido','nombre_conectividad_raton'];
    private const DEFAULT_ORDER = 0;
    private const _UPDATE = 'UPDATE consolas SET ';  
        
        function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT consolas.nombre,consolas.juego_incluido,consolas.manual_usuario,consolas.mando_incluido,conexiones_raton.nombre_conectividad_raton FROM consolas LEFT JOIN conexiones_raton ON consolas.conectividad = conexiones_raton.id_conexion WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
    
        function getProducto($cod):array{
         $stmt = $this->pdo->prepare(self::SELECT_ALL.' WHERE codigo_producto=?');
         $stmt->execute([$cod]);
         return $stmt->fetch();
    }
    
    
    
    
         function filterAll(array $filtros): array{
             
        $conditions = [];
        $parameters = [];
        
        
         if(isset($filtros['conexiones']) && is_array($filtros['conexiones'])){
            $contador = 1;
            $condicionesConexion = [];
            foreach($filtros['conexiones'] as $conexion){
                if(filter_var($conexion,FILTER_VALIDATE_INT)){
                    $condicionesConexion[] = ':conexiones'.$contador;
                    $parameters['conexiones'.$contador]  = $conexion;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' consolas.conectividad IN ('.implode(',',$condicionesConexion).')';
            }
        } 

        
        if(isset($filtros['nombre']) && !empty($filtros['nombre'])){
            $conditions[] = ' productos.nombre LIKE :nombre';
            $parameters['nombre'] = "%".$filtros['nombre']."%";
        }
        
        
        if(isset($filtros['min_precio']) && is_numeric($filtros['min_precio']) && $filtros['min_precio'] != -1){
            $conditions[] = ' precio >= :min_precio';
            $parameters['min_precio'] = $filtros['min_precio'];
        }
        
         if(isset($filtros['max_precio']) && is_numeric($filtros['max_precio']) && $filtros['max_precio'] != -1){
            $conditions[] = ' precio <= :max_precio';
            $parameters['max_precio'] = $filtros['max_precio'];
        }
        
        if(isset($filtros['juego_incluido']) && !empty($filtros['juego_incluido'])){
            $conditions[] = ' juego_incluido LIKE :juego_incluido';
            $parameters['juego_incluido'] = "%".$filtros['juego_incluido']."%";
        }
        
          if(isset($filtros['mando_incluido']) && !empty($filtros['mando_incluido'])){
            $conditions[] = ' mando_incluido LIKE :mando_incluido';
            $parameters['mando_incluido'] = "%".$filtros['mando_incluido']."%";
        }
        
        
                
                if(isset($filtros['order']) && filter_var($filtros['order'],FILTER_VALIDATE_INT)){
            if($filtros['order'] <= count(self::FIELD_ORDER) && $filtros['order'] >= 1){
                $fieldOrder = self::FIELD_ORDER[$filtros['order'] -1];
            }else{
                $filtros['order'] = self::DEFAULT_ORDER;
                $fieldOrder = self::FIELD_ORDER[self::DEFAULT_ORDER];
            }
        }else{
                $filtros['order'] = self::DEFAULT_ORDER;
                $fieldOrder = self::FIELD_ORDER[self::DEFAULT_ORDER];
        }
        
        if(count($parameters) > 0){
            $sql = self::SELECT_ALL." WHERE ".implode(" AND ",$conditions)." ORDER BY $fieldOrder";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
            return $stmt->fetchAll();
        }else{
            $stmt = $this->pdo->query(self::SELECT_ALL." ORDER BY $fieldOrder");
            return $stmt->fetchAll();
        }
   }
   
   
       public function insertConsola(array $post): bool{
           try{
        $this->pdo->beginTransaction();
        if(empty($post['juego_incluido'])){
           $post['juego_incluido'] = 'No'; 
        }
         if(empty($post['mando_incluido'])){
           $post['mando_incluido'] = 'No'; 
        }
        $stmt = $this->pdo->prepare('INSERT INTO consolas(nombre,juego_incluido,manual_usuario,mando_incluido,conectividad) values(?,?,?,?,?)');
        $stmt->execute([$post['nombre'],$post['juego_incluido'],$post['manual'],$post['mando_incluido'],$post['conectividades']]);
            $this->pdo->commit();  
        return true;
    } catch (\PDOException $ex) {
        $this->pdo->rollback();
        return false;
    }   

   }
   
   function editConsola(array $post):bool{
         try{
        $this->pdo->beginTransaction();
             if(empty($post['juego_incluido'])){
           $post['juego_incluido'] = 'No'; 
        }
         if(empty($post['mando_incluido'])){
           $post['mando_incluido'] = 'No'; 
        }
        $stmt= $this->pdo->prepare(self::_UPDATE.' nombre=?, juego_incluido=?, manual_usuario=?, mando_incluido=?, conectividad=? WHERE id_consola=?');
        $stmt->execute([$post['nombre'],$post['juego_incluido'],$post['manual'],$post['mando_incluido'],$post['conectividades'],$post['id_consola']]);
        $this->pdo->commit();  
        return true;
    } catch (\PDOException $ex) {
        $this->pdo->rollback();
        return false;
    }  
    }
   
}