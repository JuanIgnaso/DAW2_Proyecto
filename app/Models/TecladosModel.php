<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class TecladosModel extends \Com\Daw2\Core\BaseModel{
 
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT teclados.nombre,teclados.diseño_teclado,clase_conectividad.nombre_conectividad,clase_teclado.nombre_clase,idioma.nombre_idioma FROM teclados LEFT JOIN clase_conectividad ON teclados.id_clase = clase_conectividad.id_conectividad LEFT JOIN clase_teclado ON teclados.id_clase = clase_teclado.id_clase LEFT JOIN idioma ON teclados.idioma_T = idioma.id WHERE teclados.nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
}