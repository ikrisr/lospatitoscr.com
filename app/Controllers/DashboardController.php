<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::check();

        $contenido = __DIR__ . "/../Views/dashboard/usuario.view.php";
        $title = "Dashboard - Usuario";

        require __DIR__ . "/../Views/layouts/header.php";
        require __DIR__ . "/../Views/layouts/topbar.php";

        echo '<div class="flex">';
            require __DIR__ . "/../Views/layouts/sidebar.php";
            echo '<main class="flex-1 p-10">';
                require $contenido;
            echo '</main>';
        echo '</div>';

        require __DIR__ . "/../Views/layouts/footer.php";
    }
}
