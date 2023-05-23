<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxModelConexionesRaton  extends \Com\Daw2\Core\BaseModel{
    
    function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM conexiones_raton ORDER BY 2');
        return $stmt->fetchAll();
    }
    
    function conexionExists($id): bool{
        $stmt = $this->pdo->prepare('SELECT id_conexion FROM conexiones_raton WHERE id_conexion=?');
        $stmt->execute([$id]);
        return $stmt->rowCount() != 0;
    }
}