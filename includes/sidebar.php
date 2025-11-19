<?php
// Asegurar que la sesión esté activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   VARIABLES DE USUARIO (TEMPORALES SI NO HAY LOGIN)
   ============================================================ */

// Nombre del usuario
$usuarioNombre = $_SESSION["nombre"] ?? "Usuario";

// Rol del usuario (puede ser Usuario, Operador, Superadministrador)
$usuarioRol = $_SESSION["rol"] ?? "Usuario";

// Foto del usuario
if (defined("BASE_URL")) {
    $usuarioFoto = $_SESSION["foto"] ?? BASE_URL . "images/usuario_default.png";
} else {
    $usuarioFoto = "/images/usuario_default.png";
}

/* ============================================================
   CLASES DE BOOTSTRAP PARA EL BADGE SEGÚN EL ROL
   ============================================================ */
switch ($usuarioRol) {
    case "Usuario":
        $badgeClass = "bg-primary";              // azul
        break;

    case "Operador":
        $badgeClass = "bg-warning text-dark";    // anaranjado
        break;

    case "Superadministrador":
        $badgeClass = "bg-success";              // verde
        break;

    default:
        $badgeClass = "bg-secondary";            // gris por si acaso
}
?>

<!-- ============================================================
     SIDEBAR
============================================================ -->
<div class="bg-dark text-white vh-100 p-4 sidebar">

    <!-- Info del usuario -->
    <div class="text-center mb-4 sidebar-user">
        <img src="<?= htmlspecialchars($usuarioFoto) ?>" 
             alt="Usuario"
             class="rounded-circle"
             style="width:70px; height:70px; object-fit:cover; border:2px solid white;">

        <h6 class="mt-2 mb-0"><?= htmlspecialchars($usuarioNombre) ?></h6>

        <span class="badge <?= $badgeClass ?> mt-2">
            <?= htmlspecialchars($usuarioRol) ?>
        </span>
    </div>

    <hr class="bg-secondary">

    <!-- ============================================================
         MENÚ DEPENDIENDO DEL ROL
    ============================================================ -->

    <?php if ($usuarioRol === "Usuario"): ?>

        <a href="<?= BASE_URL ?>public/dashboard_usuarios.php?view=inicio"
           class="d-block text-white mb-3 text-decoration-none">Inicio</a>

        <a href="<?= BASE_URL ?>public/dashboard_usuarios.php?view=mis_tickets"
           class="d-block text-white mb-3 text-decoration-none">Mis Tickets</a>

        <a href="<?= BASE_URL ?>public/dashboard_usuarios.php?view=crear"
           class="d-block text-white mb-3 text-decoration-none">Crear Ticket</a>

        <a href="<?= BASE_URL ?>public/dashboard_usuarios.php?view=historial"
           class="d-block text-white mb-3 text-decoration-none">Historial</a>


    <?php elseif ($usuarioRol === "Operador"): ?>

        <a href="<?= BASE_URL ?>public/dashboard_operarios.php?view=inicio"
           class="d-block text-white mb-3 text-decoration-none">Panel Operador</a>

        <a href="<?= BASE_URL ?>public/dashboard_operarios.php?view=no_asignados"
           class="d-block text-white mb-3 text-decoration-none">Tickets No Asignados</a>

        <a href="<?= BASE_URL ?>public/dashboard_operarios.php?view=en_proceso"
           class="d-block text-white mb-3 text-decoration-none">En Proceso</a>

        <a href="<?= BASE_URL ?>public/dashboard_operarios.php?view=solucionados"
           class="d-block text-white mb-3 text-decoration-none">Solucionados</a>


    <?php elseif ($usuarioRol === "Superadministrador"): ?>

        <a href="<?= BASE_URL ?>public/dashboard_superadmin.php?view=inicio"
           class="d-block text-white mb-3 text-decoration-none">Panel Admin</a>

        <a href="<?= BASE_URL ?>public/dashboard_superadmin.php?view=usuarios"
           class="d-block text-white mb-3 text-decoration-none">Gestión de Usuarios</a>

        <a href="<?= BASE_URL ?>public/dashboard_superadmin.php?view=tickets"
           class="d-block text-white mb-3 text-decoration-none">Todos los Tickets</a>

        <a href="<?= BASE_URL ?>public/dashboard_superadmin.php?view=roles"
           class="d-block text-white mb-3 text-decoration-none">Roles del Sistema</a>

    <?php endif; ?>

    <hr class="bg-secondary">

    <!-- Logout -->
    <a href="<?= BASE_URL ?>public/logout.php"
       class="text-danger text-decoration-none">Cerrar sesión</a>

</div>
