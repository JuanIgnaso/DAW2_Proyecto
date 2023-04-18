<?php

declare(strict_types = 1);
namespace Com\Daw2\Models;

class CategoriaModel extends \Com\Daw2\Core\BaseModel{
    
    private const SELECT_ALL = 'SELECT * FROM categorias ';

    
    function selectCategory($category){
        $stmt = $this->pdo->prepare(self::SELECT_ALL.'WHERE id_categoria=?');
        $stmt->execute([$category]);
        return $stmt->fetch();
       
    }
    
    function getAll(): array{
        $stmt = $this->pdo->query(self::SELECT_ALL.'ORDER BY id_categoria');
        return $stmt->fetchAll();
    }
}
