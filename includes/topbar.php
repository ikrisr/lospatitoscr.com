<nav class="navbar navbar-light bg-warning shadow-sm px-3 w-100" style="height: 60px;">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="<?= BASE_URL ?>images/logo.png"
            width="35" height="35"
            class="d-inline-block align-top me-2"
            alt="Logo">
        <span class="fw-bold">Los Patitos S.A. — Mesa de Ayuda</span>
    </a>

    <span class="me-2"><?= $_SESSION["nombre"] ?? "Usuario" ?></span>
</nav>