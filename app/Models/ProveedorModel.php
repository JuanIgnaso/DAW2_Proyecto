<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class ProveedorModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT * FROM proveedores';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['id_proveedor','nombre_proveedor','direccion','website','email_proveedor','telefono'];
    private const _UPDATE = 'UPDATE proveedores SET '; 
    
    public function filterAll(array $filtros): array{
        
      $conditions = [];
      $parameters = []; 
        
       if(isset($filtros['nombre_proveedor']) && !empty($filtros['nombre_proveedor'])){
            $conditions[] = ' proveedores.nombre_proveedor LIKE :nombre_proveedor';
            $parameters['nombre_proveedor'] = "%".$filtros['nombre_proveedor']."%";
        }
        
        if(isset($filtros['direccion']) && !empty($filtros['direccion'])){
            $conditions[] = ' proveedores.direccion LIKE :direccion';
            $parameters['direccion'] = "%".$filtros['direccion']."%";
        }
        
        if(isset($filtros['email_proveedor']) && !empty($filtros['email_proveedor'])){
            $conditions[] = ' proveedores.email_proveedor LIKE :email_proveedor';
            $parameters['email_proveedor'] = "%".$filtros['email_proveedor']."%";
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
    

    //nombre y direccion son unique
    
    function direccionExists(string $dir):bool{
          $stmt = $this->pdo->prepare('SELECT direccion FROM proveedores WHERE direccion = ?');
          $stmt->execute([$dir]);
          return $stmt->rowCount() != 0;
    }
    
    function direccionOcupada($post):bool{
           $stmt = $this->pdo->prepare('SELECT direccion FROM proveedores WHERE direccion = ? AND id_proveedor != ?');
          $stmt->execute([$post['direccion'],$post['id_proveedor']]);
          return $stmt->rowCount() != 0;
    }
    
    function nombreExists(string $dir):bool{
          $stmt = $this->pdo->prepare('SELECT * FROM proveedores WHERE nombre_proveedor = ?');
          $stmt->execute([$dir]);
          return $stmt->rowCount() != 0;
    }
    
    function nombreOcupado(array $post):bool{
          $stmt = $this->pdo->prepare('SELECT nombre_proveedor FROM proveedores WHERE nombre_proveedor = ? AND id_proveedor != ?');
          $stmt->execute([$post['nombre_proveedor'],$post['id_proveedor']]);
          return $stmt->rowCount() != 0;
    }
    
    
    public function insertProveedor(array $post): bool{
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare('INSERT INTO proveedores(nombre_proveedor,direccion,website,email_proveedor,telefono) values(?,?,?,?,?)');
            $stmt->execute([$post['nombre_proveedor'],$post['direccion'],$post['website'],$post['email_proveedor'],$post['telefono']]);
                $this->pdo->commit();  
            return true;
        } catch (\PDOException $ex) {
            $this->pdo->rollback();
            return false;
        }  

   }
    
    function deleteProveedor($codigo): bool{
        try{
            $this->pdo->beginTransaction();
             $stmt = $this->pdo->prepare('DELETE FROM proveedores WHERE id_proveedor = ?'); 
             $stmt->execute([$codigo]);
             $this->pdo->commit();  
            return true;
           } catch (\PDOException $ex) {
             $this->pdo->rollback();
             return false;
          }  
      } 
      
   function getProveedor($codigo): array{
      $stmt = $this->pdo->prepare('SELECT * FROM proveedores WHERE id_proveedor = ?'); 
      $stmt->execute([$codigo]);
      return $stmt->fetch();
   }
   
   
   function editProveedor(array $post): bool{
        try{
            $this->pdo->beginTransaction();
            $stmt= $this->pdo->prepare(self::_UPDATE.' nombre_proveedor=?, direccion=?, website=?, email_proveedor=?, telefono=? WHERE id_proveedor=?');
            $stmt->execute([$post['nombre_proveedor'],$post['direccion'],$post['website'],$post['email_proveedor'],$post['telefono'],$post['id_proveedor']]);
            $this->pdo->commit();  
            return true;
        } catch (\PDOException $ex) {
            $this->pdo->rollback();
            return false;
        }  
   }
      
    
}
