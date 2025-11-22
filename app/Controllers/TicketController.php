<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Model;
use App\Models\Categoria;
use App\Models\TipoTicket;
use App\Models\Ticket;
use App\Models\TicketEntrada;

class TicketController extends Controller
{
    /* ============================================================
        FORMULARIO PARA CREAR TICKET (solo usuario)
    ============================================================ */
    public function crear()
    {
        Auth::check();
        Auth::role(['Usuario']);

        $tipos = TipoTicket::all();
        $categorias = Categoria::all();

        $contenido = __DIR__ . "/../Views/tickets/crear.view.php";

        return require __DIR__ . "/../Views/layouts/dashboard_layout.php";
    }


    /* ============================================================
        GUARDAR TICKET NUEVO
    ============================================================ */
    public function guardar()
    {
        Auth::check();
        Auth::role(['Usuario']);

        // Datos del formulario
        $data = [
            "titulo"               => $_POST["titulo"],
            "descripcion"          => $_POST["descripcion"],
            "id_tipo_ticket"       => $_POST["id_tipo_ticket"],
            "id_categoria"         => $_POST["id_categoria"],
            "id_usuario_creador"   => $_SESSION["usuario"]
        ];

        //  Crear el ticket
        $idTicket = Ticket::crear($data);

        // Crear la primera entrada (la descripción inicial)
        TicketEntrada::crear([
            "id_ticket"        => $idTicket,
            "id_autor"         => $_SESSION["usuario"],
            "texto"            => $_POST["descripcion"],
            "estado_anterior"  => null,
            "estado_nuevo"     => 1 // No Asignado
        ]);

        // Guardamos el ID de la entrada recién creada
        $idEntrada = TicketEntrada::ultimaEntradaID();

        // Procesar imágenes 
        if (!empty($_FILES['imagen']['name'][0])) {

            // Ruta donde guardaremos las imágenes (dentro de /public)
            $uploadDir = __DIR__ . '/../../public/uploads/tickets/';

            // Crear carpeta si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Tipos de archivo permitidos
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            // Límite de tamaño por archivo (5 MB)
            $maxSize = 5 * 1024 * 1024;

            // Recorrer todas las imágenes subidas
            foreach ($_FILES['imagen']['tmp_name'] as $key => $tmpName) {

                // Evitar archivos vacíos o con error
                if ($_FILES['imagen']['error'][$key] !== UPLOAD_ERR_OK) {
                    continue;
                }

                // Validar tamaño de archivo (no más de 5 MB)
                if ($_FILES['imagen']['size'][$key] > $maxSize) {
                    die("Una de las imágenes supera el límite de 5 MB.");
                }

                // Validar tipo de archivo (solo imágenes permitidas)
                if (!in_array($_FILES['imagen']['type'][$key], $allowedTypes)) {
                    die("Solo se permiten imágenes JPG, PNG o GIF.");
                }

                // Nombre original del archivo
                $original = $_FILES['imagen']['name'][$key];

                // Obtener extensión del archivo
                $ext = pathinfo($original, PATHINFO_EXTENSION);

                // Crear nombre único para guardarlo en el servidor
                $serverName = uniqid('img_') . "." . $ext;

                // Guardar archivo en /public/uploads/tickets/
                move_uploaded_file($tmpName, $uploadDir . $serverName);

                // Guardar datos de la imagen en la base de datos          
                TicketEntrada::guardarImagen([
                    "id_entrada" => $idEntrada,
                    "original"   => $original,
                    "servidor"   => $serverName,
                    "mime"       => $_FILES['imagen']['type'][$key],
                    "tamano"     => $_FILES['imagen']['size'][$key]
                ]);
            }
        }

        // Redirigir al listado "Mis Tickets"
        header("Location: /tickets/mis-tickets");
        exit();
    }

    /* ============================================================
        LISTAR TICKETS DEL USUARIO
    ============================================================ */
    public function misTickets()
    {
        Auth::check();
        Auth::role(['Usuario']);

        // Leer filtro de estado si viene por GET
        $estado = isset($_GET['estado']) ? $_GET['estado'] : null;

        // Si hay filtro → usar método con filtro
        if ($estado) {
            $tickets = Ticket::misTicketsPorEstado($_SESSION['usuario'], $estado);
        } else {
            $tickets = Ticket::misTickets($_SESSION['usuario']);
        }

        // Pasar variable a la vista para marcar el select
        $estadoSeleccionado = $estado;

        $contenido = __DIR__ . "/../Views/tickets/mis-tickets.view.php";
        require __DIR__ . "/../Views/layouts/dashboard_layout.php";
    }


    /* ============================================================
        DETALLE DE TICKET (ver historial)
    ============================================================ */
    public function detalle($id)
    {
        Auth::check();

        $ticket = Ticket::encontrar($id);

        // Seguridad: usuarios solo ven sus tickets
        if ($_SESSION['rol'] === 'Usuario' && $ticket['id_usuario_creador'] != $_SESSION['usuario']) {
            echo "No tienes permiso para ver este ticket.";
            exit();
        }

        $entradas = TicketEntrada::porTicket($id);

        // Le decimos cuál vista cargar dentro del layout
        $contenido = __DIR__ . "/../Views/tickets/detalle.view.php";

        // layout completo del Dashboard
        require __DIR__ . "/../Views/layouts/dashboard_layout.php";
    }


    /* ============================================================
        ACEPTAR SOLUCIÓN (solo usuario)
    ============================================================ */
    public function aceptarSolucion($id)
    {
        Auth::check();
        Auth::role(['Usuario']);

        Ticket::aceptar($id);

        header("Location: /tickets/detalle/$id");
        exit();
    }

    /* ============================================================
        RECHAZAR SOLUCIÓN (solo usuario)
    ============================================================ */
    public function rechazarSolucion($id)
    {
        Auth::check();
        Auth::role(['Usuario']);

        Ticket::rechazar($id);

        header("Location: /tickets/detalle/$id");
        exit();
    }
}
