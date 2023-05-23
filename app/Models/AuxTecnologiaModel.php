<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxTecnologiaModel  extends \Com\Daw2\Core\BaseModel{
    
    function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM tecnologia WHERE id_tecnologia != 1 ORDER BY 1 ');
        return $stmt->fetchAll();
    }
}