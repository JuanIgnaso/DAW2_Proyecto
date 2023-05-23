<?php


declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxClaseTecladoModel  extends \Com\Daw2\Core\BaseModel{
    
    function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM clase_teclado ORDER BY 1');
        return $stmt->fetchAll();
    }
    
       
    function claseExists($id):bool{

        $stmt = $this->pdo->prepare('SELECT id_clase FROM clase_teclado WHERE id_clase=?');
         $stmt->execute([$id]);
         return $stmt->rowCount() != 0;

    } 
    
}
