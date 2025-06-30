-- Tabla: roles
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL
); 

-- Tabla: personas
CREATE TABLE personas (
    id_persona INT AUTO_INCREMENT PRIMARY KEY,
    tipo_documento VARCHAR(20) NOT NULL,
    numero_documento VARCHAR(20) UNIQUE NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    correo_personal VARCHAR(100) NOT NULL,
    departamento VARCHAR(50) NOT NULL,
    municipio VARCHAR(50) NOT NULL,
    direccion VARCHAR(150) NOT NULL
); 

-- Tabla: usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    id_persona INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
    FOREIGN KEY (id_persona) REFERENCES personas(id_persona)
); 

-- Tabla: eventos
CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    titulo_evento VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    departamento_evento VARCHAR(50) NOT NULL,
    municipio_evento VARCHAR(50) NOT NULL,
    institucion_evento VARCHAR(100) NOT NULL,
    lugar_detallado VARCHAR(100) NOT NULL,
    cupo_maximo INT NOT NULL,
    id_usuario_creador INT NOT NULL,
    FOREIGN KEY (id_usuario_creador) REFERENCES usuarios(id_usuario)
); 

-- Tabla: ponentes
CREATE TABLE ponentes (
    id_ponente INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    tema VARCHAR(150) NOT NULL,
    descripcion_biografica TEXT NOT NULL,
    especializacion VARCHAR(100) NOT NULL,
    institucion_ponente VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES personas(id_persona)
); 

-- Tabla: ponentes_evento
CREATE TABLE ponentes_evento (
    id_ponente_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_ponente INT NOT NULL,
    id_evento INT NOT NULL,
    hora_participacion TIME NOT NULL,
    FOREIGN KEY (id_ponente) REFERENCES ponentes(id_ponente),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
); 

-- Tabla: invitados_evento
CREATE TABLE invitados_evento (
    id_invitado_evento INT AUTO_INCREMENT PRIMARY KEY,
    id_persona INT NOT NULL,
    id_evento INT NOT NULL,
    tipo_invitado VARCHAR(50) NOT NULL,
    correo_institucional VARCHAR(100) NOT NULL,
    programa_academico VARCHAR(100),
    nombre_carrera VARCHAR(100),
    jornada VARCHAR(50),
    facultad VARCHAR(100),
    cargo VARCHAR(100),
    sede_institucion VARCHAR(100) NOT NULL,
    estado_asistencia VARCHAR(50) NOT NULL,
    fecha_inscripcion DATETIME NOT NULL,
    certificado_generado BOOLEAN NOT NULL,
    FOREIGN KEY (id_persona) REFERENCES personas(id_persona),
    FOREIGN KEY (id_evento) REFERENCES eventos(id_evento)
); 

-- Tabla: asistencias
CREATE TABLE asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    id_invitado_evento INT NOT NULL,
    fecha_asistencia DATE NOT NULL,
    hora_asistencia TIME NOT NULL,
    asistio BOOLEAN NOT NULL,
    FOREIGN KEY (id_invitado_evento) REFERENCES invitados_evento(id_invitado_evento)
); 

-- Tabla: auditoria_admin
CREATE TABLE auditoria_admin (
    id_auditoria INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    accion_realizada VARCHAR(100) NOT NULL,
    tabla_afectada VARCHAR(50) NOT NULL,
    fecha_hora DATETIME NOT NULL,
    detalle_opcional TEXT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
