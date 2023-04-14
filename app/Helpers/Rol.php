<?php

/*
-ID del rol
-Nombre del rol
-Descripción
 *  */

namespace Com\Daw2\Helpers;

class Rol{
    private $idRol;
    private $nombreRol;
    private $desc;
    private $_permisos;
    //Permisos: usuarios,inventario,comprar
    
    private const _PERMISOS_ADMIN = array(
      'usuarios' => ['r','w','d'],
      'inventario' => ['r','w','d'],
      'comprar' => ['r','w','d']       
    );
    
    private const _PERMISOS_INVENTARIO  = array(
      'inventario' => ['r','w','d'],
      'comprar' => ['r','w','d']       
    );
    
    private const _PERMISOS_REGISTRADO = array(
      'comprar' => ['r','w','d']       
    );
    
    public function __construct(int $idRol, string $nombreRol, string $desc){
        $this->idRol = $idRol;
        $this->nombreRol  = $nombreRol;
        $this->desc = $desc;
        if($this->idRol == 1){
            $this->_permisos = self::_PERMISOS_REGISTRADO;
        }else
         if($this->idRol == 2){
            $this->_permisos = self::_PERMISOS_INVENTARIO;
        }else
         if($this->idRol == 3){
            $this->_permisos = self::_PERMISOS_ADMIN;
        }
    }
    
    public function getIdRol() {
        return $this->idRol;
    }

    public function getNombreRol() {
        return $this->nombreRol;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function get_permisos() {
        return $this->_permisos;
    }


}