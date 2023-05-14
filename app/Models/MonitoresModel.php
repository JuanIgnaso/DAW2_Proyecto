<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class MonitoresModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT monitores.entrada_video,monitores.pulgadas,tecnologia.nombre_tecnología,monitores.tecnologia,monitores.refresco,productos.*,proveedores.nombre_proveedor FROM monitores LEFT JOIN productos ON monitores.nombre = productos.nombre LEFT JOIN tecnologia ON monitores.tecnologia = tecnologia.id_tecnologia LEFT JOIN proveedores ON  productos.proveedor = proveedores.id_proveedor';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['codigo_producto','nombre','nombre_proveedor','precio','entrada_video','refresco','nombre_tecnología'];


    
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT monitores.*,tecnologia.nombre_tecnología FROM monitores LEFT JOIN tecnologia ON monitores.tecnologia = tecnologia.id_tecnologia WHERE nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
    function filterAll(array $filtros): array{
      $conditions = [];
      $parameters = [];
      
      
        if(isset($filtros['tecnologias']) && is_array($filtros['tecnologias'])){
        $contador = 1;
        $condicionesTecnologia = [];
        foreach($filtros['tecnologias'] as $tecnologia){
            if(filter_var($tecnologia,FILTER_VALIDATE_INT)){
                $condicionesTecnologia [] = ':tecnologia'.$contador;
                $parameters['tecnologia'.$contador]  = $tecnologia;
                $contador++;
            }
        }
        if(count($parameters) > 0){
            $conditions[] = ' monitores.tecnologia IN ('.implode(',',$condicionesTecnologia ).')';
        }
    }
    
    if(isset($filtros['refrescos']) && is_array($filtros['refrescos'])){
            $contador = 1;
            $condicionesRefresco = [];
            foreach($filtros['refrescos'] as $refresco){
                if(!empty($refresco)){
                    $condicionesRefresco[] = ':refresco'.$contador;
                    $parameters['refresco'.$contador]  = $refresco;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' refresco IN ('.implode(',',$condicionesRefresco).')';
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
        
        if(isset($filtros['entrada_video']) && !empty($filtros['entrada_video'])){
            $conditions[] = ' entrada_video LIKE :entrada_video';
            $parameters['entrada_video'] = "%".$filtros['entrada_video']."%";
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
   
   function getRefreshRate(): array{
     $stmt = $this->pdo->query('SELECT DISTINCT refresco FROM monitores ORDER BY 1');
       return $stmt->fetchAll();  
   }
}