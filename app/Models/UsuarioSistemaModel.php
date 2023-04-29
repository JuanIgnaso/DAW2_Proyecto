<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
declare(strict_types = 1);
namespace Com\Daw2\Models;

class UsuarioSistemaModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT usuarios.*,rol_usuarios.nombre_rol,rol_usuarios.descripcion FROM usuarios LEFT JOIN rol_usuarios ON usuarios.id_rol = rol_usuarios.id_rol';
    private const UPDATE = 'UPDATE usuarios SET ';
    
    
    public function login(string $email,string $pass): ?\Com\Daw2\Helpers\UsuarioSistema{
        //Buscamos al usuario en la BBDD
        $query = $this->pdo->prepare(self::SELECT_ALL." WHERE email=? AND baja=0");
        $query->execute([$email]);
        //Si se encuentran coincidencias
         if($row = $query->fetch()){
             if(password_verify($pass,$row['pass'])){
                 return $this->rowToUsuarioSistema($row);
             }else{
                 return NULL;
             }
         }else{
             return NULL;
         }
        
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
        $stmt = $this->pdo->prepare('INSERT INTO usuarios(id_rol,email,nombre_usuario,pass,baja,cartera) values(?,?,?,?,0,0.0)');
        return $stmt->execute([$post['rol'][0],$post['email'],$post['nombre'],password_hash($post['pass'],PASSWORD_DEFAULT)]);     
    }
    
    /***
     * Actualiza el registro del úlitmo logeo del usuario
     */
    function updateLastLogin(string $email){
        $stmt = $this->pdo->prepare(self::UPDATE."ultimo_login=? WHERE email=?");
        $stmt->execute([date("Y-m-d H:i:s", strtotime("now")),$email]);     
    }
    
    //Actualizar la cantidad de dinero del usuario
    function updateUserWallet($amount,$id){
        $stmt = $this->pdo->prepare('UPDATE usuarios SET cartera = cartera - ? WHERE id_usuario = ?');
        $stmt->execute([$amount,$id]);
    }
    
}