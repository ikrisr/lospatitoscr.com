<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class TicketEntrada
{
    /* ============================================================
        TRAER TODAS LAS ENTRADAS DEL TICKET
    ============================================================ */
    public static function porTicket($idTicket)
    {
        $pdo = Model::connection();

        $stmt = $pdo->prepare("
        SELECT te.*, u.nombre_completo AS autor
        FROM ticket_entradas te
        INNER JOIN usuarios u ON te.id_autor = u.id_usuario
        WHERE id_ticket = ?
        ORDER BY fecha_creacion ASC;
    ");
        $stmt->execute([$idTicket]);
        $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($entradas as &$e) {
            $s = $pdo->prepare("SELECT * FROM ticket_imagenes WHERE id_entrada = ?");
            $s->execute([$e['id_entrada']]);
            $e['imagenes'] = $s->fetchAll(PDO::FETCH_ASSOC);
        }

        return $entradas;
    }

    /* ============================================================
        CREA NUEVA ENTRADA (Comentario / Cambio de Estado)
    ============================================================ */
    public static function crear($data)
    {
        $pdo = Model::connection();

        $stmt = $pdo->prepare("
            INSERT INTO ticket_entradas
            (id_ticket, id_autor, texto, id_estado_anterior, id_estado_nuevo)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data["id_ticket"],
            $data["id_autor"],
            $data["texto"],
            $data["estado_anterior"],
            $data["estado_nuevo"]
        ]);
    }
    /* ============================================================
        Obtener el ID de la última entrada creada
    ============================================================ */
    public static function ultimaEntradaID()
    {
        $pdo = Model::connection();
        return $pdo->lastInsertId();
    }

    /* ============================================================
         Guardar registro de una imagen en la BD
    ============================================================ */
    public static function guardarImagen($data)
    {
        $pdo = Model::connection();

        $stmt = $pdo->prepare("
        INSERT INTO ticket_imagenes
        (id_entrada, nombre_archivo_original, nombre_en_servidor, tipo_mime, tamano_bytes)
        VALUES (?, ?, ?, ?, ?)
    ");

        $stmt->execute([
            $data["id_entrada"],
            $data["original"],
            $data["servidor"],
            $data["mime"],
            $data["tamano"]
        ]);
    }
}
