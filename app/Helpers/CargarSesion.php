<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace Com\Daw2\Helpers;

/**
 * Description of CargarSesion
 *
 * @author USUARIO
 */
class CargarSesion {
    //put your code here
    
    private $email;
    private $pass;
    
    public function __construct(string $email, string $pass){
        $this->email = $email;
        $this->pass = $pass;
    }
}
