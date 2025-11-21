<?php

namespace App\Core;

class Auth
{
    public static function check()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: /login");
            exit;
        }
    }

    public static function role($roles = [])
    {
        $actual = $_SESSION['rol'] ?? null;

        if (!in_array($actual, $roles)) {
            echo "Acceso denegado";
            exit;
        }
    }

    public static function logout()
    {
        session_destroy();
        header("Location: /login");
    }
}
