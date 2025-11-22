<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Categoria
{
    public static function all()
    {
        $pdo = Model::connection();
        $stmt = $pdo->query("SELECT * FROM categorias_ticket ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
