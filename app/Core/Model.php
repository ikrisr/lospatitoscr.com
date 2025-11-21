<?php

namespace App\Core;

use PDO;

class Model
{
    protected static $pdo;

    public static function connection()
    {
        if (!isset(self::$pdo)) {
            $config = require __DIR__ . '/../../config/database.php';

            try {
                self::$pdo = new PDO(
                    "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
                    $config['username'],
                    $config['password']
                );

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (\PDOException $e) {
                die('Could not connect to the database: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
