<aside class="w-64 bg-gray-800 text-gray-100 min-h-screen p-6">

    <!-- Avatar -->
    <div class="text-center mb-8">
        <img src="/public/img/avatar.png"
             class="w-20 h-20 mx-auto rounded-full border-2 border-yellow-500"
             alt="Avatar">

        <p class="mt-2 font-bold"><?= $_SESSION['nombre'] ?? 'Usuario' ?></p>

        <span class="text-xs bg-blue-600 px-2 py-1 mt-1 inline-block rounded">
            <?= $_SESSION['rol'] ?? '' ?>
        </span>
    </div>

    <!-- Menú -->
    <nav class="space-y-2">

        <a href="/dashboard" 
           class="block px-4 py-2 rounded hover:bg-gray-700">Inicio</a>

        <a href="/tickets/mis-tickets" 
           class="block px-4 py-2 rounded hover:bg-gray-700">Mis Tickets</a>

        <a href="/tickets/crear" 
           class="block px-4 py-2 rounded hover:bg-gray-700">Crear Ticket</a>

        <a href="/tickets/historial" 
           class="block px-4 py-2 rounded hover:bg-gray-700">Historial</a>

        <hr class="border-gray-600 my-4">

        <a href="/logout" 
           class="block px-4 py-2 rounded text-red-400 hover:text-red-500">
           Cerrar sesión
        </a>

    </nav>

</aside>
