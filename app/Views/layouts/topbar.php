<header class="bg-yellow-500 text-white px-6 h-14 flex items-center justify-between shadow-md">
    
    <div class="flex items-center gap-2">
        <span class="text-2xl">🦆</span>
        <h1 class="font-bold">Los Patitos S.A. — Mesa de Ayuda</h1>
    </div>

    <div class="font-semibold">
        <?= $_SESSION['nombre'] ?? 'Usuario' ?>
        <span class="text-sm opacity-80">(<?= $_SESSION['rol'] ?? '' ?>)</span>
    </div>

</header>
