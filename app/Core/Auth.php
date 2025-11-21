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
        self::check();

        $rolUsuario = $_SESSION['rol'] ?? null;

        if (!in_array($rolUsuario, $roles)) {
            http_response_code(403);
            echo "Acceso denegado";
            exit;
        }
    }

    public static function logout()
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
