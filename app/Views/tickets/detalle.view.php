<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Detalle del Ticket</h1>

    <!-- Información del ticket -->
    <div class="bg-white p-6 rounded shadow mb-6">

        <p class="mb-2">
            <strong>Título:</strong> <?= htmlspecialchars($ticket['titulo']) ?>
        </p>

        <p class="mb-2">
            <strong>Estado:</strong>
            <span class="px-2 py-1 rounded text-sm 
                <?= $ticket['estado'] === 'Cerrado' ? 'bg-green-600 text-white' : '' ?>
                <?= $ticket['estado'] === 'Solucionado' ? 'bg-blue-600 text-white' : '' ?>
                <?= $ticket['estado'] === 'En Proceso' ? 'bg-yellow-600 text-white' : '' ?>
                <?= $ticket['estado'] === 'No Asignado' ? 'bg-gray-400 text-white' : '' ?>
            ">
                <?= $ticket['estado'] ?>
            </span>
        </p>

        <p>
            <strong>Fecha:</strong> <?= $ticket['fecha_creacion'] ?>
        </p>
    </div>

    <!-- Historial -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Historial</h2>

        <?php if (empty($entradas)): ?>
            <p class="text-gray-500">No hay entradas todavía.</p>
        <?php else: ?>
            <?php foreach ($entradas as $e): ?>
                <div class="border-b py-3">

                    <!-- Autor -->
                    <p class="font-semibold text-yellow-800"><?= $e['autor'] ?></p>

                    <!-- Fecha -->
                    <p class="text-gray-600 text-sm"><?= $e['fecha_creacion'] ?></p>

                    <!-- Texto -->
                    <p class="mt-2"><?= nl2br(htmlspecialchars($e['texto'])) ?></p>

                    <!-- Imágenes adjuntas -->                
                    <?php if (!empty($e['imagenes'])): ?>
                        <div class="mt-3 flex gap-3 flex-wrap">
                            <?php foreach ($e['imagenes'] as $img): ?>
                                <img src="/uploads/tickets/<?= $img['nombre_en_servidor'] ?>"
                                    class="w-32 h-32 object-cover rounded-lg shadow-md hover:shadow-xl 
                        border border-gray-300 transition duration-200"
                                    alt="Imagen del ticket">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Acciones (solo si está 'Solucionado') -->
    <?php if ($ticket['id_estado_ticket'] == 5): ?>
        <div class="flex gap-4">

            <form action="/tickets/<?= $ticket['id_ticket'] ?>/aceptar" method="POST">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Aceptar solución
                </button>
            </form>

            <form action="/tickets/<?= $ticket['id_ticket'] ?>/rechazar" method="POST">
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    Rechazar solución
                </button>
            </form>

        </div>
    <?php endif; ?>

</div>