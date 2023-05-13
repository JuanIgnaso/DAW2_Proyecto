<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class RatonesModel extends \Com\Daw2\Core\BaseModel{
   
    private const SELECT_ALL = 'SELECT proveedores.nombre_proveedor,productos.*,ratones.dpi,ratones.clase,conexiones_raton.nombre_conectividad_raton FROM ratones LEFT JOIN conexiones_raton ON ratones.id_conexion = conexiones_raton.id_conexion LEFT JOIN productos ON productos.nombre = ratones.nombre LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','dpi','clase','nombre_conectividad_raton'];

    
       function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT ratones.nombre,ratones.dpi,ratones.clase,conexiones_raton.nombre_conectividad_raton FROM ratones LEFT JOIN conexiones_raton ON ratones.id_conexion = conexiones_raton.id_conexion WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
   function filterAll(array $filtros): array{
//       $stmt = $this->pdo->query(self::SELECT_ALL);
//       return $stmt->fetchAll();
       $conditions = [];
       $parameters = [];
       
      if(isset($filtros['conexion']) && is_array($filtros['conexion'])){
            $contador = 1;
            $condicionesConexion = [];
            foreach($filtros['conexion'] as $conexion){
                if(filter_var($conexion,FILTER_VALIDATE_INT)){
                    $condicionesConexion[] = ':conexion'.$contador;
                    $parameters['conexion'.$contador]  = $conexion;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' ratones.id_conexion IN ('.implode(',',$condicionesConexion).')';
            }
        }
        
        if(isset($filtros['nombre']) && !empty($filtros['nombre'])){
            $conditions[] = ' productos.nombre LIKE :nombre';
            $parameters['nombre'] = "%".$filtros['nombre']."%";
        }
        
        
              if(isset($filtros['clase']) && !empty($filtros['clase'])){
            $conditions[] = ' clase LIKE :clase';
            $parameters['clase'] = "%".$filtros['clase']."%";
        }
        
        if(isset($filtros['min_dpi']) && is_numeric($filtros['min_dpi']) && $filtros['min_dpi'] != -1){
            $conditions[] = ' dpi >= :min_dpi';
            $parameters['min_dpi'] = $filtros['min_dpi'];
        }
        
         if(isset($filtros['max_dpi']) && is_numeric($filtros['max_dpi']) && $filtros['max_dpi'] != -1){
            $conditions[] = ' dpi <= :max_dpi';
            $parameters['max_dpi'] = $filtros['max_dpi'];
        }
        
        if(isset($filtros['min_precio']) && is_numeric($filtros['min_precio']) && $filtros['min_precio'] != -1){
            $conditions[] = ' precio >= :min_precio';
            $parameters['min_precio'] = $filtros['min_precio'];
        }
        
         if(isset($filtros['max_precio']) && is_numeric($filtros['max_precio']) && $filtros['max_precio'] != -1){
            $conditions[] = ' precio <= :max_precio';
            $parameters['max_precio'] = $filtros['max_precio'];
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
}
