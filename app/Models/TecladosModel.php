<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class TecladosModel extends \Com\Daw2\Core\BaseModel{
 
    
        private const SELECT_ALL = 'SELECT proveedores.nombre_proveedor,productos.*,teclados.id_conectividad,teclados.id_clase,teclados.idioma_T,teclados.diseño_Teclado,clase_conectividad.nombre_conectividad,clase_teclado.nombre_clase,idioma.nombre_idioma FROM teclados LEFT JOIN productos ON productos.nombre = teclados.nombre LEFT JOIN proveedores ON productos.proveedor = proveedores.id_proveedor LEFT JOIN clase_conectividad ON clase_conectividad.id_conectividad = teclados.id_conectividad LEFT JOIN clase_teclado ON clase_teclado.id_clase = teclados.id_clase LEFT JOIN idioma ON idioma.id = teclados.idioma_T';

    
    
    function loadDetails($nombre){
        $stmt = $this->pdo->prepare('SELECT teclados.nombre,teclados.diseño_teclado,clase_conectividad.nombre_conectividad,clase_teclado.nombre_clase,idioma.nombre_idioma FROM teclados LEFT JOIN clase_conectividad ON teclados.id_clase = clase_conectividad.id_conectividad LEFT JOIN clase_teclado ON teclados.id_clase = clase_teclado.id_clase LEFT JOIN idioma ON teclados.idioma_T = idioma.id WHERE teclados.nombre=?');
        $stmt->execute([$nombre]);
        return $stmt->fetch();      
    }
    
    
    
       function filterAll(): array{
       $stmt = $this->pdo->query(self::SELECT_ALL);
       return $stmt->fetchAll();
   }
}