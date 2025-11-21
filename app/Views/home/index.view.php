<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bienvenido al Curso de Programación Web</h1>
        <p class="col-md-8 fs-4">Esta es una aplicación de ejemplo utilizando el patrón MVC en PHP sin frameworks.</p>
        <?php if (isset($_SESSION['user'])): ?>
            <a class="btn btn-primary btn-lg" href="/vehicles" role="button">Ver Vehículos</a>
        <?php endif; ?>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>