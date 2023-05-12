<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxIdiomaModel  extends \Com\Daw2\Core\BaseModel{
    
        function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM idioma ORDER BY 1');
        return $stmt->fetchAll();
    }
}
