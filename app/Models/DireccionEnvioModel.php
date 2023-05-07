<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class DireccionEnvioModel  extends \Com\Daw2\Core\BaseModel{
    
    private const _INSERT_INTO = 'INSERT INTO direccion_envio (id_usuario,nombre_titular,provincia,ciudad,calle,cod_postal)';
    private const _UPDATE = 'UPDATE direccion_envio SET ';
    
    
    function insertShippingAddress(array $post,$id): bool{
        try {
         $this->pdo->beginTransaction();
         //Comprobamos lo que nos devuelve el método auxiliar
         $existe = $this->fieldExists($id);
         if($existe){
             //Si existe hacemos un UPDATE
          $stmt = $this->pdo->prepare(self::_UPDATE.' nombre_titular=?, provincia=?, ciudad=?, calle=?,cod_postal=? WHERE id_usuario=?');
          $stmt->execute([$post['nombre_titular'],$post['provincia'],$post['ciudad'],$post['calle'],$post['cod_postal'],$id]);
         }else{
            //Si no existe hacemos el INSERT  
          $stmt = $this->pdo->prepare(self::_INSERT_INTO.' VALUES(?,?,?,?,?,?)');
          $stmt->execute([$id,$post['nombre_titular'],$post['provincia'],$post['ciudad'],$post['calle'],$post['cod_postal']]);
         }
        $this->pdo->commit();
        return true;
        } catch (\PDOException $ex) {
         $this->pdo->rollback();
         return false;  
        } 
    }
    
    private function fieldExists($id): bool{
        $stmt = $this->pdo->prepare('SELECT * FROM direccion_envio WHERE id_usuario=?');
        $stmt->execute([$id]);
        return $stmt->rowCount() != 0;
    }
    
}

