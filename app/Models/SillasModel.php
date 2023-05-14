<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class SillasModel extends \Com\Daw2\Core\BaseModel{
 
    private const SELECT_ALL = 'SELECT sillas.tipo_silla,sillas.altura,sillas.anchura,sillas.ajustable,productos.*,proveedores.nombre_proveedor FROM sillas LEFT JOIN productos ON sillas.nombre = productos.nombre LEFT JOIN proveedores ON productos.proveedor =  proveedores.id_proveedor';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','altura','anchura','tipo_silla','ajustable'];

        
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT * FROM sillas WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
        function filterAll(array $filtros): array{
        $conditions = [];
        $parameters = [];
        
        if(isset($filtros['alturas']) && is_array($filtros['alturas'])){
            $contador = 1;
            $condicionesAlturas = [];
            foreach($filtros['alturas'] as $altura){
                if(!empty($altura)){
                    $condicionesAlturas[] = ':altura'.$contador;
                    $parameters['altura'.$contador]  = $altura;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' altura IN ('.implode(',',$condicionesAlturas).')';
            }
        } 
        
        if(isset($filtros['anchuras']) && is_array($filtros['alturas'])){
            $contador = 1;
            $condicionesAnchuras = [];
            foreach($filtros['anchuras'] as $anchura){
                if(!empty($anchura)){
                    $condicionesAnchuras[] = ':anchura'.$contador;
                    $parameters['anchura'.$contador]  = $anchura;
                    $contador++;
                }
            }
            if(count($condicionesAnchuras) > 0){
                $conditions[] = ' anchura IN ('.implode(',',$condicionesAnchuras).')';
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
        
               
       if(isset($filtros['tipo_silla']) && !empty($filtros['tipo_silla'])){
            $conditions[] = ' sillas.tipo_silla LIKE :tipo_silla';
            $parameters['tipo_silla'] = "%".$filtros['tipo_silla']."%";
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
   
   
      function getChairHight(): array{
       $stmt = $this->pdo->query('SELECT DISTINCT altura FROM sillas ORDER BY 1');
       return $stmt->fetchAll();
   }
    
   
    function getChairLenght(): array{
       $stmt = $this->pdo->query('SELECT DISTINCT anchura FROM sillas ORDER BY 1');
       return $stmt->fetchAll();
   } 
}

