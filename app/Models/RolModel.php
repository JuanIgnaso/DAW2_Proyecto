<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class RolModel extends \Com\Daw2\Core\BaseModel{
    
    function getUsersRol(): array{
        $stmt = $this->pdo->query('SELECT * FROM rol_usuarios ORDER BY id_rol');
         return $stmt->fetchAll();
    }
}