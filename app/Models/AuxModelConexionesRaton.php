<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxModelConexionesRaton  extends \Com\Daw2\Core\BaseModel{
    
        function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM conexiones_raton ORDER BY 2');
        return $stmt->fetchAll();
    }
}