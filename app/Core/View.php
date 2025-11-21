<?php

namespace App\Core;

class View
{
    public static function render($name, $data = [])
    {
        extract($data);

        return require __DIR__ . "/../Views/{$name}.view.php";
    }
}
