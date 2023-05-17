<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxConectividadTecladoModel  extends \Com\Daw2\Core\BaseModel{
    
        function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM clase_conectividad ORDER BY 1');
        return $stmt->fetchAll();
    }
    
    
        function conectividadExists($id):bool{

        $stmt = $this->pdo->prepare('SELECT id_conectividad FROM clase_conectividad WHERE id_conectividad=?');
         $stmt->execute([$id]);
         return $stmt->rowCount() != 0;

    }
}
