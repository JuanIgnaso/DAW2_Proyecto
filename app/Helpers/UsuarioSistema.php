<?php

namespace Com\Daw2\Helpers;

class UsuarioSistema{
    private $idUsuario;
    private $rol;
    private $email;
    private $nombre;
    private $cartera;
    
    public function __construct(int $idUsuario,Rol $rol,string $email,string $nombre){
        $this->idUsuario = $idUsuario;
        $this->rol = $rol;
        $this->email = $email;
        $this->nombre = $nombre;
        $this->cartera = 0.0;
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCartera() {
        return $this->cartera;
    }
    
    //SETTERS

    public function setRol($rol): void {
        $this->rol = $rol;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setCartera($cartera): void {
        $this->cartera = $cartera;
    }


}
