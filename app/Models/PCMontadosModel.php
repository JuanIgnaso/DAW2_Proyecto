<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class PCMontadosModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT productos.*,PC_montados.id_ordenador,PC_montados.caja,PC_montados.cpu,PC_montados.targeta_video,PC_montados.almacenamiento,PC_montados.memoria,PC_montados.alimentacion,PC_montados.almacenamiento_tipo,proveedores.nombre_proveedor FROM PC_montados LEFT JOIN productos ON PC_montados.nombre = productos.nombre LEFT JOIN proveedores ON  productos.proveedor =  proveedores.id_proveedor';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','cpu','targeta_video','memoria','almacenamiento'];
    private const _UPDATE = 'UPDATE PC_montados SET ';  

    
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT * FROM PC_montados WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
     function filterAll(array $filtros): array{
      $conditions = [];
      $parameters = [];
      
      
       if(isset($filtros['almacenamientos']) && is_array($filtros['almacenamientos'])){
            $contador = 1;
            $condicionesAlmacenamiento = [];
            foreach($filtros['almacenamientos'] as $almacenamiento){
                if(!empty($almacenamiento)){
                    $condicionesAlmacenamiento[] = ':almacenamiento'.$contador;
                    $parameters['almacenamiento'.$contador]  = $almacenamiento;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' almacenamiento IN ('.implode(',',$condicionesAlmacenamiento).')';
            }
        } 
        
        if(isset($filtros['memorias']) && is_array($filtros['memorias'])){
            $contador = 1;
            $condicionesMemoria = [];
            foreach($filtros['memorias'] as $memoria){
                if(!empty($memoria)){
                    $condicionesMemoria[] = ':memoria'.$contador;
                    $parameters['memoria'.$contador]  = $memoria;
                    $contador++;
                }
            }
            if(count($condicionesMemoria) > 0){
                $conditions[] = ' memoria IN ('.implode(',',$condicionesMemoria).')';
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
        
        if(isset($filtros['cpu']) && !empty($filtros['cpu'])){
            $conditions[] = ' cpu LIKE :cpu';
            $parameters['cpu'] = "%".$filtros['cpu']."%";
        }
        
          if(isset($filtros['caja']) && !empty($filtros['caja'])){
            $conditions[] = ' caja LIKE :caja';
            $parameters['caja'] = "%".$filtros['caja']."%";
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
   
   function getStorageQuantity(): array{
       $stmt = $this->pdo->query('SELECT DISTINCT almacenamiento FROM PC_montados ORDER BY 1');
       return $stmt->fetchAll();
   }
    
   
    function getMemoryQuantity(): array{
       $stmt = $this->pdo->query('SELECT DISTINCT memoria FROM PC_montados ORDER BY 1');
       return $stmt->fetchAll();
    }
   
   
    function getAlmacenamientoTipo():array{
       $stmt = $this->pdo->query('SELECT SUBSTRING(COLUMN_TYPE,5)
        FROM information_schema.COLUMNS
        WHERE TABLE_SCHEMA="proxecto" 
            AND TABLE_NAME="PC_montados"
            AND COLUMN_NAME="almacenamiento_tipo"
        ');
        return  $stmt->fetchAll();
        
   }
   
       function getProducto($cod):array{
         $stmt = $this->pdo->prepare(self::SELECT_ALL.' WHERE codigo_producto=?');
         $stmt->execute([$cod]);
         return $stmt->fetch();
    } 
   
   
    public function insertPC(array $post): bool{
           try{
        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare('INSERT INTO PC_montados(nombre,caja,cpu,targeta_video,almacenamiento,memoria,alimentacion,almacenamiento_tipo) values(?,?,?,?,?,?,?,?)');
        $stmt->execute([$post['nombre'],$post['caja'],$post['cpu'],$post['targeta_video'],$post['almacenamiento'],$post['memoria'],$post['alimentacion'],$post['almacenamientos']]);
            $this->pdo->commit();  
        return true;
    } catch (\PDOException $ex) {
        $this->pdo->rollback();
        return false;
    }   

   }
   
   
   function editOrdenador(array $post):bool{
         try{
        $this->pdo->beginTransaction();
        $stmt= $this->pdo->prepare(self::_UPDATE.' nombre=?, caja=?, cpu=?, targeta_video=?, almacenamiento=?, memoria=?, alimentacion=?, almacenamiento_tipo=? WHERE id_ordenador=?');
        $stmt->execute([$post['nombre'],$post['caja'],$post['cpu'],$post['targeta_video'],$post['almacenamiento'],$post['memoria'],$post['alimentacion'],$post['almacenamientos'],$post['id_ordenador']]);
        $this->pdo->commit();  
        return true;
    } catch (\PDOException $ex) {
        $this->pdo->rollback();
        return false;
    }  
    }
   
   
}