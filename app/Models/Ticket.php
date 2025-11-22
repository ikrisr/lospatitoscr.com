<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Ticket
{
    /* ============================================================
        CREAR TICKET
    ============================================================ */
    public static function crear($data)
    {
        $pdo = Model::connection();

        $stmt = $pdo->prepare("
            INSERT INTO tickets 
            (titulo, descripcion_inicial, id_tipo_ticket, id_estado_ticket, id_prioridad, id_categoria, id_usuario_creador)
            VALUES (?, ?, ?, 1, 1, ?, ?)
        ");

        $stmt->execute([
            $data["titulo"],
            $data["descripcion"],
            $data["id_tipo_ticket"],
            $data["id_categoria"],
            $data["id_usuario_creador"]
        ]);

        return $pdo->lastInsertId();
    }

    /* ============================================================
        OBTENER TODOS LOS TICKETS DEL USUARIO
    ============================================================ */
    public static function misTickets($idUsuario)
    {
        $pdo = Model::connection();
        $stmt = $pdo->prepare("
            SELECT t.*, et.nombre AS estado
            FROM tickets t
            INNER JOIN estados_ticket et ON t.id_estado_ticket = et.id_estado_ticket
            WHERE id_usuario_creador = ?
            ORDER BY fecha_creacion DESC
        ");
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        BUSCAR TICKET POR ID
    ============================================================ */
    public static function encontrar($idTicket)
    {
        $pdo = Model::connection();
        $stmt = $pdo->prepare("
            SELECT t.*, et.nombre AS estado
            FROM tickets t
            INNER JOIN estados_ticket et ON t.id_estado_ticket = et.id_estado_ticket
            WHERE id_ticket = ?
        ");
        $stmt->execute([$idTicket]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ============================================================
        ACEPTAR SOLUCIÓN (cambia a estado CERRADO)
    ============================================================ */
    public static function aceptar($idTicket)
    {
        $pdo = Model::connection();
        $stmt = $pdo->prepare("
            UPDATE tickets 
            SET id_estado_ticket = 6, fecha_cierre = NOW()
            WHERE id_ticket = ?
        ");
        $stmt->execute([$idTicket]);
    }

    /* ============================================================
        RECHAZAR SOLUCIÓN (regresa a estado ASIGNADO)
    ============================================================ */
    public static function rechazar($idTicket)
    {
        $pdo = Model::connection();
        $stmt = $pdo->prepare("
            UPDATE tickets 
            SET id_estado_ticket = 2
            WHERE id_ticket = ?
        ");
        $stmt->execute([$idTicket]);
    }

    /* ============================================================
        filtra los tickets por estado y Devuelve la lista filtrada
    ============================================================ */
    public static function misTicketsPorEstado($idUsuario, $estado)
    {
        $pdo = Model::connection();

        $stmt = $pdo->prepare("
        SELECT t.*, et.nombre AS estado
        FROM tickets t
        INNER JOIN estados_ticket et ON t.id_estado_ticket = et.id_estado_ticket
        WHERE id_usuario_creador = ?
        AND t.id_estado_ticket = ?
        ORDER BY fecha_creacion DESC
    ");

        $stmt->execute([$idUsuario, $estado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
