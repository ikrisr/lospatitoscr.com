<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">

    <h1 class="text-2xl font-bold mb-6">Crear nuevo Ticket</h1>

    <form action="/tickets/guardar"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6">


        <!-- Título -->
        <div>
            <label class="block font-semibold mb-1">Título *</label>
            <input type="text" name="titulo" maxlength="200" required
                class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-300"
                placeholder="Ej: Problema con mi acceso al sistema">
        </div>

        <!-- Tipo -->
        <div>
            <label class="block font-semibold mb-1">Tipo de Ticket *</label>
            <select name="id_tipo_ticket" required
                class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-300">
                <?php foreach ($tipos as $t): ?>
                    <option value="<?= $t['id_tipo_ticket'] ?>">
                        <?= $t['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Categoría -->
        <div>
            <label class="block font-semibold mb-1">Categoría *</label>
            <select name="id_categoria" required
                class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-300">
                <?php foreach ($categorias as $c): ?>
                    <option value="<?= $c['id_categoria'] ?>">
                        <?= $c['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Descripción -->
        <div>
            <label class="block font-semibold mb-1">Descripción *</label>
            <textarea name="descripcion" rows="5" required
                class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-yellow-300"
                placeholder="Describe el problema o solicitud con el mayor detalle posible..."></textarea>
        </div>
        
        <!-- Imagen opcional -->
        <div>
            <label class="block font-semibold mb-1">Adjuntar imagen (opcional)</label>
            <input type="file" name="imagen[]"
                accept="image/*"
                class="w-full border border-gray-300 p-2 rounded"
                multiple>
            <p class="text-sm text-gray-500 mt-1">
                Puedes subir una o varias fotos del problema (JPG, PNG, GIF).
            </p>
        </div>

        <!-- Botón Crear -->
        <div>
            <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                Crear Ticket
            </button>
        </div>

    </form>
</div>