<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class TecladosModel extends \Com\Daw2\Core\BaseModel{
 
    
        private const SELECT_ALL = 'SELECT proveedores.nombre_proveedor,productos.*,teclados.id_conectividad,teclados.id_clase,teclados.idioma_T,teclados.diseño_Teclado,clase_conectividad.nombre_conectividad,clase_teclado.nombre_clase,idioma.nombre_idioma FROM teclados LEFT JOIN productos ON productos.nombre = teclados.nombre LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor LEFT JOIN clase_conectividad ON clase_conectividad.id_conectividad = teclados.id_conectividad LEFT JOIN clase_teclado ON clase_teclado.id_clase = teclados.id_clase LEFT JOIN idioma ON idioma.id = teclados.idioma_T';
        private const DEFAULT_ORDER = 0;
        private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','nombre_conectividad','nombre_clase','nombre_idioma'];
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT teclados.nombre,teclados.diseño_teclado,clase_conectividad.nombre_conectividad,clase_teclado.nombre_clase,idioma.nombre_idioma FROM teclados LEFT JOIN clase_conectividad ON teclados.id_clase = clase_conectividad.id_conectividad LEFT JOIN clase_teclado ON teclados.id_clase = clase_teclado.id_clase LEFT JOIN idioma ON teclados.idioma_T = idioma.id WHERE teclados.nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
    
       function filterAll(array $filtros): array{
             $conditions = [];
             $parameters = [];
             
         if(isset($filtros['idioma']) && is_array($filtros['idioma'])){
            $contador = 1;
            $condicionesIdioma = [];
            foreach($filtros['idioma'] as $idioma){
                if(filter_var($idioma,FILTER_VALIDATE_INT)){
                    $condicionesIdioma[] = ':idioma'.$contador;
                    $parameters['idioma'.$contador]  = $idioma;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' teclados.idioma_T IN ('.implode(',',$condicionesIdioma).')';
            }
        } 
        
        if(isset($filtros['conectividad']) && is_array($filtros['conectividad'])){
            $contador = 1;
            $condicionesConectividad = [];
            foreach($filtros['conectividad'] as $conectividad){
                if(filter_var($conectividad,FILTER_VALIDATE_INT)){
                    $condicionesConectividad[] = ':conectividad'.$contador;
                    $parameters['conectividad'.$contador]  = $conectividad;
                    $contador++;
                }
            }
            if(count($condicionesConectividad) > 0){
                $conditions[] = ' teclados.id_conectividad IN ('.implode(',',$condicionesConectividad).')';
            }
        }  
        
        if(isset($filtros['clase']) && is_array($filtros['clase'])){
            $contador = 1;
            $condicionesClase = [];
            foreach($filtros['conectividad'] as $clase){
                if(filter_var($clase,FILTER_VALIDATE_INT)){
                    $condicionesClase[] = ':conectividad'.$contador;
                    $parameters['conectividad'.$contador]  = $clase;
                    $contador++;
                }
            }
            if(count($condicionesClase) > 0){
                $conditions[] = ' teclados.id_clase IN ('.implode(',',$condicionesClase).')';
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