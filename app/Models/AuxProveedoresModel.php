<?php
declare(strict_types = 1);
namespace Com\Daw2\Models;

class AuxProveedoresModel  extends \Com\Daw2\Core\BaseModel{
    
    function getAll(): array{
        $stmt = $this->pdo->query('SELECT * FROM proveedores ORDER BY 1');
        return $stmt->fetchAll();
    }
    
    function proveedorExists($id): bool{
        $stmt = $this->pdo->prepare('SELECT id_proveedor FROM proveedores WHERE id_proveedor=?');
         $stmt->execute([$id]);
         return $stmt->rowCount() != 0;
    }
}

