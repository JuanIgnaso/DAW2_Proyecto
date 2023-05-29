<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
declare(strict_types = 1);
namespace Com\Daw2\Models;

class UsuarioSistemaModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT usuarios.*,rol_usuarios.* FROM usuarios LEFT JOIN rol_usuarios ON usuarios.id_rol = rol_usuarios.id_rol';
    private const UPDATE = 'UPDATE usuarios SET ';
    private const DEFAULT_ORDER = 0;
    private const FIELD_ORDER = ['id_usuario','email','nombre_usuario','nombre_rol','ultimo_login'];
    
    
    function getUser($id): array{
      $stmt = $this->pdo->prepare(self::SELECT_ALL.' WHERE id_usuario = ?');
     $stmt->execute([$id]);
     return $stmt->fetch();  
    }
    
    
    
    function filterAll(array $filtros): array{
        
       $conditions = [];
       $parameters = [];  
       
       
       if(isset($filtros['id_rol']) && is_array($filtros['id_rol'])){
            $contador = 1;
            $condicionesRol = [];
            foreach($filtros['id_rol'] as $rol){
                if(filter_var($rol,FILTER_VALIDATE_INT)){
                    $condicionesRol[] = ':id_rol'.$contador;
                    $parameters['id_rol'.$contador]  = $rol;
                    $contador++;
                }
            }
            if(count($parameters) > 0){
                $conditions[] = ' usuarios.id_rol IN ('.implode(',',$condicionesRol).')';
            }
        }
        

         if(isset($filtros['nombre_usuario']) && !empty($filtros['nombre_usuario'])){
            $conditions[] = ' nombre_usuario LIKE :nombre_usuario';
            $parameters['nombre_usuario'] = "%".$filtros['nombre_usuario']."%";
         }
             
       if(isset($filtros['email']) && !empty($filtros['email'])){
            $conditions[] = ' email LIKE :email';
            $parameters['email'] = "%".$filtros['email']."%";
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
    
    
    
    public function login($post): ?array{

        //Buscamos al usuario en la BBDD
        $query = $this->pdo->prepare(self::SELECT_ALL." WHERE email=? AND baja=0");
        $query->execute([$post['email']]);
        //Si se encuentran coincidencias
         if($row = $query->fetch()){
             if(password_verify($post['password'],$row['pass'])){ 
                 
                 $row['id_usuario'] = $this->getUserId($post['email']);
                 return $row;
             }else{
                 return NULL;
             }
         }else{
             return NULL;
         }
        
    }
    
    function updateUserSession($id):array{
       $query = $this->pdo->prepare(self::SELECT_ALL." WHERE usuarios.id_usuario=? AND baja=0");
       $query->execute([$id]);
       $row = $query->fetch();
       $row['id_usuario'] = $this->getUserId($row['email']);
       return $row;
    }
    
    private function getUserId($email): int{

       $stmt = $this->pdo->prepare('SELECT id_usuario FROM usuarios WHERE email=?');
        $stmt->execute([$email]);
        $var = $stmt->fetch();
        return $var['id_usuario'];
    }
    

    
    
    /*
    Añadir usuario a la bbdd
     */
    function addUser(array $post):bool{
        //hasheamos la password
        try {
           $this->pdo->beginTransaction();
           $post['pass'] = password_hash($post['pass'],PASSWORD_DEFAULT);
           $stmt = $this->pdo->prepare('INSERT INTO usuarios(id_rol,email,nombre_usuario,pass,baja,cartera) values(?,?,?,?,0,0.0)');
           $stmt->execute([$post['id_rol'],$post['email'],$post['nombre_usuario'],$post['pass']]); 
           $this->pdo->commit();
           return true; //<-Si todo va OK
        } catch (\PDOException $ex) {
          $this->pdo->rollback();  
          return false;
        }
            
    }
    
    /***
     * Actualiza el registro del úlitmo logeo del usuario
     */
    function updateLastLogin(string $email){
        $stmt = $this->pdo->prepare(self::UPDATE."ultimo_login=? WHERE email=?");
        $stmt->execute([date("Y-m-d H:i:s", strtotime("now")),$email]);     
    }
    
    
    //  Comprobar si el correo no está en uso
    function occupiedUserName($id,$nombre): bool{
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE nombre_usuario=? AND id_usuario != ?');
        $stmt->execute([$nombre,$id]);
            return $stmt->rowCount() != 0;
    }
    
    //Comprobar solo si el nombre está ya en uso por un usuario registrado
    function isUserNameUsed($username): bool{
         $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE nombre_usuario=?');
        $stmt->execute([$username]);
        return $stmt->rowCount() != 0;  
    }
    
    //Comprobar solo si el email está ya en uso por un usuario registrado
    function isEmailUsed($email): bool{
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email=?');
        $stmt->execute([$email]);
        return $stmt->rowCount() != 0;  
    }
    
    
       //  Comprobar si el correo no está en uso
    function occupiedMail($id,$email): bool{
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email=? AND id_usuario != ?');
        $stmt->execute([$email,$id]);
        return $stmt->rowCount() != 0;
    }
    
    
    //Actualizar la cantidad de dinero del usuario
    function updateUserWallet($amount,$id){
        $stmt = $this->pdo->prepare('UPDATE usuarios SET cartera = cartera - ? WHERE id_usuario = ?');
        $stmt->execute([$amount,$id]);
    }
    
    
    private function comprobarBaja($nombre): bool{
        $stmt = $this->pdo->prepare(self::SELECT_ALL." WHERE nombre_usuario=? AND baja=1");
        $stmt->execute([$nombre]);
        return $stmt->rowCount() != 0;
    }
    
    
    
    function darDeBaja($nombre): bool{
        try{
            $this->pdo->beginTransaction();

            if($this->comprobarBaja($nombre)){
                $stmt = $this->pdo->prepare(self::UPDATE."baja=0 WHERE nombre_usuario=?");
                $stmt->execute([$nombre]); 
                $this->pdo->commit();
                return true;
            }else{
                $stmt = $this->pdo->prepare(self::UPDATE."baja=1 WHERE nombre_usuario=?");
                $stmt->execute([$nombre]); 
                $this->pdo->commit();
                return true;
            } 
        } catch (\PDOException $ex) {
        $this->pdo->rollback();
         return false;
        }
        
        
    }
    
    function deleteUser($nombre): bool{
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE nombre_usuario=?');
            $stmt->execute([$nombre]);
            $this->pdo->commit();
            return true;
        } catch (\PDOException $ex) {
         $this->pdo->rollback();
         return false;   
        }
    }
    
    //EDITAR USADO POR ADMIN
    function editUserWeb($post):bool{
        try {
           $this->pdo->beginTransaction(); 
           if(empty($post['pass'])){
            $stmt = $this->pdo->prepare(self::UPDATE.' id_rol=?,email=?,nombre_usuario=? WHERE id_usuario=?');
                $stmt->execute([$post['id_rol'],$post['email'],$post['nombre_usuario'],$post['id_usuario']]);
           }else{
            $post['pass'] = password_hash($post['pass'],PASSWORD_DEFAULT); 
            $stmt = $this->pdo->prepare(self::UPDATE.' id_rol=?,email=?,nombre_usuario=?,pass=? WHERE id_usuario=?');
            $stmt->execute([$post['id_rol'],$post['email'],$post['nombre_usuario'],$post['pass'],$post['id_usuario']]);  
           }
           
           $this->pdo->commit();
            return true; 
           
        } catch (\PDOException $ex) {
        $this->pdo->rollback();
         return false;   
        }
    }
    
    
    //EDITAR USUARIO EN PERFIL
    function editUser($post,$pass,$id): bool{
        try{
           $this->pdo->beginTransaction(); 
           //Si se pasa un valor vacío se le introduce la contraseña actual del usuario
                if(empty($post['password'])){
                  $post['password'] = $pass;  
                }else{
                   $post['password'] = password_hash($post['password'],PASSWORD_DEFAULT); 
                } 
            if(empty($post['cartera'])){
                //Si el usuario no introduce valor ninguno al editar, se le asigna un valor de cero
                //ya que cantidad + 0 no cambia el valor. 
                $post['cartera'] = 0;
            }     
           $stmt = $this->pdo->prepare(self::UPDATE.' email=?, nombre_usuario=?, pass=?, cartera= cartera + ? WHERE id_usuario=?');
            $stmt->execute([$post['email'],$post['nombre_usuario'],$post['password'],$post['cartera'],$id]);
            $this->pdo->commit();
            return true;
        } catch (\PDOException $ex) {
        $this->pdo->rollback();
         return false;   
        }
    }
    
    function updateUserAvatar($id,$url):bool{
    try{
        $this->pdo->beginTransaction();     
        $stmt = $this->pdo->prepare(self::UPDATE.' profile_image=? WHERE id_usuario=?');
        $stmt->execute([$url,$id]);
        $this->pdo->commit();
        return true;
    } catch (\PDOException $ex) {
       $this->pdo->rollback();
       return false;   
    }
    }
    
}


