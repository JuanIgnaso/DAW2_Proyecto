<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxIdiomaModel  extends \Com\Daw2\Core\BaseModel{
    
        function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM idioma ORDER BY 1');
        return $stmt->fetchAll();
    }
    
    function idiomaExists($id):bool{

        $stmt = $this->pdo->prepare('SELECT id FROM idioma WHERE id=?');
         $stmt->execute([$id]);
         return $stmt->rowCount() != 0;

    }
}
