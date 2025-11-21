


-- 1. Tabla roles
CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  descripcion VARCHAR(255) NULL
);

-- 2. Tabla departamentos
CREATE TABLE departamentos (
  id_departamento INT  AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  descripcion VARCHAR(255) NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1
);

-- 3. Tabla tipos_ticket (Incidente / Petición)
CREATE TABLE tipos_ticket (
  id_tipo_ticket INT  AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  descripcion VARCHAR(255) NULL
);

-- 4. Tabla estados_ticket

CREATE TABLE estados_ticket (
  id_estado_ticket INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  cierre TINYINT(1) NOT NULL DEFAULT 0
);

-- 5. Tabla prioridades_ticket
CREATE TABLE prioridades_ticket (
  id_prioridad INT  AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  nivel TINYINT  NOT NULL
);

-- 6. Tabla categorias_ticket
CREATE TABLE categorias_ticket (
  id_categoria INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  descripcion VARCHAR(255) NULL
);

-- 7. Tabla usuarios
CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre_completo VARCHAR(150) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  id_rol INT NOT NULL,
  id_departamento INT NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_usuarios_rol
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
  CONSTRAINT fk_usuarios_depto
    FOREIGN KEY (id_departamento) REFERENCES departamentos(id_departamento)
);

-- 8. Tabla tickets (incluye descripcion_inicial)
CREATE TABLE tickets (
  id_ticket INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  descripcion_inicial TEXT NOT NULL,
  id_tipo_ticket INT NOT NULL,
  id_estado_ticket INT NOT NULL,
  id_prioridad INT NOT NULL,
  id_categoria INT NOT NULL,
  id_usuario_creador INT NOT NULL,
  id_operador_asignado INT NULL,
  fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  fecha_actualizacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  fecha_cierre DATETIME NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_tickets_tipo
    FOREIGN KEY (id_tipo_ticket) REFERENCES tipos_ticket(id_tipo_ticket),
  CONSTRAINT fk_tickets_estado
    FOREIGN KEY (id_estado_ticket) REFERENCES estados_ticket(id_estado_ticket),
  CONSTRAINT fk_tickets_prioridad
    FOREIGN KEY (id_prioridad) REFERENCES prioridades_ticket(id_prioridad),
  CONSTRAINT fk_tickets_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias_ticket(id_categoria),
  CONSTRAINT fk_tickets_creador
    FOREIGN KEY (id_usuario_creador) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_tickets_operador
    FOREIGN KEY (id_operador_asignado) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. Tabla ticket_entradas (bitácora: comentarios y cambios de estado)
CREATE TABLE ticket_entradas (
  id_entrada INT  AUTO_INCREMENT PRIMARY KEY,
  id_ticket INT  NOT NULL,
  id_autor INT  NOT NULL,
  texto TEXT NOT NULL,
  id_estado_anterior INT NULL,
  id_estado_nuevo INT NULL,
  fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_entradas_ticket
    FOREIGN KEY (id_ticket) REFERENCES tickets(id_ticket),
  CONSTRAINT fk_entradas_autor
    FOREIGN KEY (id_autor) REFERENCES usuarios(id_usuario),
  CONSTRAINT fk_entradas_estado_ant
    FOREIGN KEY (id_estado_anterior) REFERENCES estados_ticket(id_estado_ticket),
  CONSTRAINT fk_entradas_estado_nuevo
    FOREIGN KEY (id_estado_nuevo) REFERENCES estados_ticket(id_estado_ticket)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. Tabla ticket_imagenes (solo fotos asociadas a entradas)
CREATE TABLE ticket_imagenes (
  id_imagen INT AUTO_INCREMENT PRIMARY KEY,
  id_entrada INT NOT NULL,
  nombre_archivo_original VARCHAR(255) NOT NULL,
  nombre_en_servidor VARCHAR(255) NOT NULL,
  tipo_mime VARCHAR(100) NOT NULL,
  tamano_bytes INT  NOT NULL,
  fecha_subida DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_imagen_entrada
    FOREIGN KEY (id_entrada) REFERENCES ticket_entradas(id_entrada)
);

-- 11. Tabla transiciones_estado (matriz de estados permitidos)
CREATE TABLE transiciones_estado (
  id_transicion INT  AUTO_INCREMENT PRIMARY KEY,
  id_estado_origen INT  NOT NULL,
  id_estado_destino INT  NOT NULL,
  descripcion VARCHAR(255) NULL,
  CONSTRAINT fk_trans_origen
    FOREIGN KEY (id_estado_origen) REFERENCES estados_ticket(id_estado_ticket),
  CONSTRAINT fk_trans_destino
    FOREIGN KEY (id_estado_destino) REFERENCES estados_ticket(id_estado_ticket),
  CONSTRAINT uq_transicion UNIQUE (id_estado_origen, id_estado_destino)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================================================
-- 	VISTAS
-- =========================================================
	select * from roles; 
	select * from departamentos;
	select * from tipos_ticket ;
	select * from estados_ticket;
	select *  from prioridades_ticket;
    select * from categorias_ticket; 
	select * from usuarios;
	
-- =========================================================
-- INSERTS BÁSICOS (catálogos y superadministrador)
-- =========================================================

-- Roles básicos
INSERT INTO roles (nombre, descripcion) VALUES
  ('Super Administrador', 'Acceso total al sistema'),
  ('Operador', 'Atiende y gestiona tickets'),
  ('Usuario', 'Reporta incidentes y peticiones');

-- Departamentos
INSERT INTO departamentos (nombre, descripcion, activo) VALUES
  ('Mesa de Ayuda', 'Soporte de tickets', 1),
  ('Desarrollo de Software', 'Desarrollo y mantenimiento de sistemas internos', 1),
  ('Recursos Humanos', 'Gestión de personal, nómina y procesos de talento humano', 1),
  ('Finanzas y Contabilidad', 'Gestión financiera y contable', 1),
  ('Ventas', 'Gestión comercial y procesos de venta', 1),
  ('Proveeduría', 'Relación con proveedores, compras y abastecimiento', 1),
  ('Dirección General', 'Gerencia general y alta dirección', 1);
	
-- Tipos de ticket
INSERT INTO tipos_ticket (nombre, descripcion) VALUES
  ('Incidente', 'Reporte de fallo o problema con servicio existente'),
  ('Petición', 'Solicitud de nuevo servicio o recurso');

-- Estados de los tickets
INSERT INTO estados_ticket (nombre, cierre) VALUES
  ('No Asignado', 0),
  ('Asignado', 0),
  ('En Proceso', 0),
  ('En Espera de Terceros', 0),
  ('Solucionado', 0),  
  ('Cerrado', 1);


-- Prioridades
INSERT INTO prioridades_ticket (nombre, nivel) VALUES
  ('Baja', 1),
  ('Media', 2),
  ('Alta', 3),
  ('Crítica', 4);

--  Categorías
INSERT INTO categorias_ticket (nombre, descripcion) VALUES
  ('Hardware', 'Problemas con equipos físicos'),
  ('Software', 'Aplicaciones y sistemas'),
  ('Red', 'Conectividad y comunicaciones'),
  ('Accesos', 'Usuarios, contraseñas, permisos');

-- Usuario Super Administrador
-- Contraseña: admin123 
INSERT INTO usuarios (
  nombre_completo,
  username,
  password_hash,
  email,
  id_rol,
  id_departamento,
  activo
) VALUES (
  'Super Administrador',
  'admin',
  '$2y$10$Jj1zPqvHfaRelVn.BcELC.hb3uLU9VxzIPZFpGDbI.Y0QuQt48PPS',
  'admin@gmail.com',
  1,      
  7,  
  1       
);

