-- ============================================================
--  TABLA: roles
-- ============================================================
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) UNIQUE NOT NULL
);


-- ============================================================
--  TABLA: usuarios
-- ============================================================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    rol_id INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,

    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_rol FOREIGN KEY (rol_id) REFERENCES roles(id)
);


-- ============================================================
--  TABLA: tickets
-- ============================================================
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,

    tipo VARCHAR(20) NOT NULL CHECK (
        tipo IN ('Peticion', 'Incidente')
    ),

    usuario_id INT NOT NULL,      -- creador
    operador_id INT NULL,         -- operador asignado

    estado VARCHAR(30) NOT NULL CHECK (
        estado IN (
            'No Asignado',
            'Asignado',
            'En Proceso',
            'En Espera de Terceros',
            'Solucionado',
            'Cerrado'
        )
    ),

    fotografia LONGBLOB,          -- Foto en binario

    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario_creador FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_usuario_operador FOREIGN KEY (operador_id) REFERENCES usuarios(id)
);


-- ============================================================
--  TABLA: ticket_entradas (bitácora / comentarios)
-- ============================================================
CREATE TABLE ticket_entradas (
    id INT AUTO_INCREMENT PRIMARY KEY,

    ticket_id INT NOT NULL,
    autor_id INT NOT NULL,

    contenido TEXT NOT NULL,

    -- Si la entrada implica un cambio de estado (opcional)
    estado_anterior VARCHAR(30),
    estado_nuevo VARCHAR(30),

    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_ticket FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    CONSTRAINT fk_autor FOREIGN KEY (autor_id) REFERENCES usuarios(id)
);
