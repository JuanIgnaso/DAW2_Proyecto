<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
declare(strict_types = 1);
namespace Com\Daw2\Models;

class UsuarioSistemaModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT usuarios.*,rol_usuarios.descripcion FROM usuarios LEFT JOIN rol_usuarios ON usuarios.id_rol = rol_usuarios.id_rol';
    private const UPDATE = 'UPDATE usuarios SET ';
    
    
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
     * Devuelve el usuario convertido en objeto para usar luego
     */
    private function rowToUsuarioSistema(array $row): ?\Com\Daw2\Helpers\UsuarioSistema{
        $rol = new \Com\Daw2\Helpers\Rol($row['id_rol'],$row['nombre_rol'],$row['descripcion']);
        return new \Com\Daw2\Helpers\UsuarioSistema($row['id_usuario'],$rol,$row['email'],$row['nombre_usuario'],$row['cartera']);
    }
    
    /*
    Añadir usuario a la bbdd
     */
    function addUser(array $post):bool{
        //hasheamos la password
        try {
           $this->pdo->beginTransaction();
           $post['password'] = password_hash($post['password'],PASSWORD_DEFAULT);
           $stmt = $this->pdo->prepare('INSERT INTO usuarios(id_rol,email,nombre_usuario,pass,baja,cartera) values(1,?,?,?,0,0.0)');
           $stmt->execute([$post['email'],$post['nombre_usuario'],$post['password']]); 
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
    function occupiedUserName(int $id,$nombre): bool{
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
    function occupiedMail(int $id,$email): bool{
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
        return $stmt->rowCount() !== 0;
    }
    
    function darDeBaja($nombre): bool{
        try{
        $this->pdo->beginTransaction();

        if($this->comprobarBaja($nombre)){
        $stmt = $this->pdo->prepare(self::UPDATE."baja=0 WHERE nombre_usuario=?");
        $stmt->execute([$nombre]);  
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
    
    
    //EDITAR USUARIO
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
    
}


