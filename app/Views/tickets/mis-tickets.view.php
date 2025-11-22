<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Mis Tickets</h1>

    <?php if (empty($tickets)): ?>

        <div class="bg-yellow-50 border-l-4 border-yellow-600 text-yellow-900 p-4 rounded mb-4">
            <p class="font-semibold text-lg">No hay resultados</p>

            <?php if ($estadoSeleccionado): ?>
                <p class="mt-1">No existen tickets en el estado seleccionado.</p>
            <?php else: ?>
                <p class="mt-1">Aún no has creado ningún ticket.</p>
            <?php endif; ?>
        </div>

        <!-- Botón para volver -->
        <?php if ($estadoSeleccionado): ?>
            <a href="/tickets/mis-tickets"
                class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Ver todos los tickets
            </a>
        <?php else: ?>
            <a href="/tickets/crear"
                class="inline-block mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Crear ticket
            </a>
        <?php endif; ?>

    <?php else: ?>


        <!-- FILTRO POR ESTADO -->
        <form method="GET" action="/tickets/mis-tickets" class="mb-6 flex gap-4 items-center">

            <label class="font-semibold">Filtrar por estado:</label>

            <select name="estado"
                class="border border-gray-300 p-2 rounded"
                onchange="this.form.submit()">

                <option value="">Todos</option>

                <option value="1" <?= ($estadoSeleccionado == 1) ? 'selected' : '' ?>>No Asignado</option>
                <option value="2" <?= ($estadoSeleccionado == 2) ? 'selected' : '' ?>>Asignado</option>
                <option value="3" <?= ($estadoSeleccionado == 3) ? 'selected' : '' ?>>En Proceso</option>
                <option value="4" <?= ($estadoSeleccionado == 4) ? 'selected' : '' ?>>En Espera</option>
                <option value="5" <?= ($estadoSeleccionado == 5) ? 'selected' : '' ?>>Solucionado</option>
                <option value="6" <?= ($estadoSeleccionado == 6) ? 'selected' : '' ?>>Cerrado</option>
            </select>

        </form>


        <table class="w-full bg-white shadow-md rounded overflow-hidden">
            <thead class="bg-yellow-500 text-white">
                <tr>
                    <th class="p-3 text-left">Título</th>
                    <th class="p-3 text-left">Estado</th>
                    <th class="p-3 text-left">Fecha</th>
                    <th class="p-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                <?php foreach ($tickets as $t): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3"><?= htmlspecialchars($t['titulo']) ?></td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs 
                        <?= $t['estado'] === 'Cerrado' ? 'bg-green-600 text-white' : '' ?>
                        <?= $t['estado'] === 'Solucionado' ? 'bg-blue-600 text-white' : '' ?>
                        <?= $t['estado'] === 'En Proceso' ? 'bg-yellow-600 text-white' : '' ?>
                        <?= $t['estado'] === 'No Asignado' ? 'bg-gray-400 text-white' : '' ?>
                    ">
                                <?= $t['estado'] ?>
                            </span>
                        </td>

                        <td class="p-3"><?= $t['fecha_creacion'] ?></td>

                        <td class="p-3 text-center">
                            <a href="/tickets/detalle/<?= $t['id_ticket'] ?>"
                                class="text-blue-600 font-semibold hover:underline">
                                Ver
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>