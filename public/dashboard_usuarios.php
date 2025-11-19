<?php 
require_once "../config/start_app.php";
require_once "../config/database.php";
include "../includes/head.php";
?>

<body>

<!-- NAVBAR -->
<?php include "../includes/topbar.php"; ?>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-2 p-0">
            <?php include "../includes/sidebar.php"; ?>
        </div>

        <!-- CONTENIDO DINÁMICO -->
        <main class="col-10 pt-5 mt-4">

            <?php
            $viewsPath = __DIR__ . "/vistas_usuarios/";
            $view = $_GET['view'] ?? 'inicio';

            if ($view === "mis_tickets") {
                include $viewsPath . "mis_tickets.php";
            } elseif ($view === "crear") {
                include $viewsPath . "crear_ticket.php";
            } elseif ($view === "historial") {
                include $viewsPath . "historial.php";
            } else {
                include $viewsPath . "inicio.php";
            }
            ?>

        </main>

    </div>
</div>

</body>
</html>
