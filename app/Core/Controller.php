<?php

namespace App\Core;

class Controller
{
    protected function view($name, $data = [])
    {
        return View::render($name, $data);
    }

    protected function redirect($ruta)
    {
        header("Location: {$ruta}");
        exit;
    }
}
