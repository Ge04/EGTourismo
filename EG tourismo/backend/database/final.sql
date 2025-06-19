-- Drop and recreate the eg_turismo database
DROP DATABASE IF EXISTS eg_turismo;
CREATE DATABASE IF NOT EXISTS eg_turismo;
USE eg_turismo;

-- Zona_Turismo table (moved to top since it's referenced by other tables)
CREATE TABLE IF NOT EXISTS zona_turismo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    ubicacion VARCHAR(255),
    atractivos TEXT,
    main_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create hotels table
CREATE TABLE IF NOT EXISTS `hotel` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT,
    `ubicacion` VARCHAR(255) NOT NULL,
    `precio_rango` ENUM('Económico', 'Medio', 'Lujo') NOT NULL,
    `calificacion` INT CHECK (calificacion BETWEEN 1 AND 5),
    `categoria` ENUM('hotel', 'resort', 'guesthouse') NOT NULL,
    `servicios` TEXT,
    `telefono` VARCHAR(20),
    `email` VARCHAR(255),
    `website` VARCHAR(255),
    `image` VARCHAR(255),
    `imagenes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create hotel reviews table
CREATE TABLE IF NOT EXISTS `hotel_review` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `hotel_id` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `calificacion` INT CHECK (calificacion BETWEEN 1 AND 5),
    `comentario` TEXT,
    `avatar` VARCHAR(255),
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`hotel_id`) REFERENCES `hotel`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create hotel rooms table
CREATE TABLE IF NOT EXISTS `hotel_room` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `hotel_id` INT NOT NULL,
    `tipo` ENUM('standard', 'deluxe', 'suite') NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT,
    `precio` DECIMAL(10,2) NOT NULL,
    `capacidad` INT NOT NULL,
    `imagen` VARCHAR(255),
    `servicios` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`hotel_id`) REFERENCES `hotel`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create hotel bookings table
CREATE TABLE IF NOT EXISTS `hotel_booking` (
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `hotel_id` INT NOT NULL,
    `room_id` INT NOT NULL,
    `nombre` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `telefono` VARCHAR(20) NOT NULL,
    `check_in` DATE NOT NULL,
    `check_out` DATE NOT NULL,
    `huespedes` INT NOT NULL,
    `estado` ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`hotel_id`) REFERENCES `hotel`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`room_id`) REFERENCES `hotel_room`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create hotel zones junction table
CREATE TABLE IF NOT EXISTS `zona_hotel` (
    `zona_id` INT NOT NULL,
    `hotel_id` INT NOT NULL,
    PRIMARY KEY (`zona_id`, `hotel_id`),
    FOREIGN KEY (`zona_id`) REFERENCES `zona_turismo`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`hotel_id`) REFERENCES `hotel`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario table
CREATE TABLE IF NOT EXISTS usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Foto (User photo, linked to usuario)
CREATE TABLE IF NOT EXISTS foto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    url_img VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

-- Reserva table (no paquete)
CREATE TABLE IF NOT EXISTS reserva (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    fecha_reser DATE,
    duracion VARCHAR(50),
    precio DECIMAL(10,2),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- Servicios table
CREATE TABLE IF NOT EXISTS servicios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2),
    guia_turist VARCHAR(100),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    d_servicio VARCHAR(100)
);

-- Actividad table
CREATE TABLE IF NOT EXISTS actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    duracion VARCHAR(50),
    precio DECIMAL(10,2),
    categoria VARCHAR(50),
    caracteristicas TEXT,
    imagen VARCHAR(255),
    telefono VARCHAR(30),
    correo VARCHAR(100),
    zona_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transporte table
CREATE TABLE IF NOT EXISTS transporte (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricula VARCHAR(50),
    telefono VARCHAR(20),
    correo VARCHAR(100),
    zona_id INT,
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id)
);

-- Reseña (Review) table for Transporte
CREATE TABLE IF NOT EXISTS resena (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_trans INT NOT NULL,
    resena TEXT,
    FOREIGN KEY (id_trans) REFERENCES transporte(id) ON DELETE CASCADE
);

-- Restaurantes table
CREATE TABLE IF NOT EXISTS restaurantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100)
);

-- Galeria_Multimedia (Dynamic, for all images)
CREATE TABLE IF NOT EXISTS galeria_multimedia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    url_img VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    entity_type ENUM('usuario','zona_turismo','servicios','hotel','actividad','transporte','reserva','restaurantes') NOT NULL,
    entity_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- N:M Relationships (Junction Tables)

-- Reserva <-> Zona_Turismo (N:M)
CREATE TABLE IF NOT EXISTS reserva_zona (
    reserva_id INT,
    zona_id INT,
    PRIMARY KEY (reserva_id, zona_id),
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE CASCADE,
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE CASCADE
);

-- Reserva <-> Servicios (N:M)
CREATE TABLE IF NOT EXISTS reserva_servicio (
    reserva_id INT,
    servicio_id INT,
    PRIMARY KEY (reserva_id, servicio_id),
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);

-- Zona_Turismo <-> Servicios (N:M)
CREATE TABLE IF NOT EXISTS zona_servicio (
    zona_id INT,
    servicio_id INT,
    PRIMARY KEY (zona_id, servicio_id),
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);

-- Zona_Turismo <-> Hotel (N:M)
CREATE TABLE IF NOT EXISTS zona_hotel (
    zona_id INT,
    hotel_id INT,
    PRIMARY KEY (zona_id, hotel_id),
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE
);

-- Zona_Turismo <-> Actividad (N:M)
CREATE TABLE IF NOT EXISTS zona_actividad (
    zona_id INT,
    actividad_id INT,
    PRIMARY KEY (zona_id, actividad_id),
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE CASCADE,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE CASCADE
);

-- Hotel <-> Servicios (N:M)
CREATE TABLE IF NOT EXISTS hotel_servicio (
    hotel_id INT,
    servicio_id INT,
    PRIMARY KEY (hotel_id, servicio_id),
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE
);

-- Hotel <-> Actividad (N:M)
CREATE TABLE IF NOT EXISTS hotel_actividad (
    hotel_id INT,
    actividad_id INT,
    PRIMARY KEY (hotel_id, actividad_id),
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE CASCADE
);

-- Zona_Turismo <-> Restaurantes (N:M)
CREATE TABLE IF NOT EXISTS zona_restaurante (
    zona_id INT,
    restaurante_id INT,
    PRIMARY KEY (zona_id, restaurante_id),
    FOREIGN KEY (zona_id) REFERENCES zona_turismo(id) ON DELETE CASCADE,
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE
);

-- Transporte <-> Reserva (N:M)
CREATE TABLE IF NOT EXISTS reserva_transporte (
    reserva_id INT,
    transporte_id INT,
    PRIMARY KEY (reserva_id, transporte_id),
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE CASCADE,
    FOREIGN KEY (transporte_id) REFERENCES transporte(id) ON DELETE CASCADE
);

-- Reserva <-> Actividad (N:M)
CREATE TABLE IF NOT EXISTS reserva_actividad (
    reserva_id INT,
    actividad_id INT,
    PRIMARY KEY (reserva_id, actividad_id),
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE CASCADE,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE CASCADE
);

-- Tabla de restaurantes
CREATE TABLE IF NOT EXISTS restaurante (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(255) NOT NULL,
    tipo_cocina VARCHAR(50) NOT NULL,
    precio_medio VARCHAR(50) NOT NULL,
    descripcion TEXT,
    horario VARCHAR(100),
    imagen VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de hoteles
CREATE TABLE IF NOT EXISTS hotel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(255) NOT NULL,
    num_habitaciones INT NOT NULL,
    precio_por_noche DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    caracteristicas JSON,
    imagenes JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de habitaciones de hotel
CREATE TABLE IF NOT EXISTS hotel_room (
    id INT PRIMARY KEY AUTO_INCREMENT,
    hotel_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    capacidad INT NOT NULL,
    precio_por_noche DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    caracteristicas JSON,
    imagenes JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de reservas de hotel
CREATE TABLE IF NOT EXISTS hotel_booking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    hotel_id INT NOT NULL,
    room_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    num_huespedes INT NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES hotel_room(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de reseñas de hotel
CREATE TABLE IF NOT EXISTS hotel_review (
    id INT PRIMARY KEY AUTO_INCREMENT,
    hotel_id INT NOT NULL,
    usuario_id INT NOT NULL,
    puntuacion INT NOT NULL CHECK (puntuacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de actividades
CREATE TABLE IF NOT EXISTS actividad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    ubicacion VARCHAR(255),
    precio DECIMAL(10,2),
    duracion VARCHAR(50),
    dificultad ENUM('facil', 'moderada', 'dificil'),
    imagenes JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de reservas de actividades
CREATE TABLE IF NOT EXISTS reserva_actividad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    actividad_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    num_personas INT NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de transportes
CREATE TABLE IF NOT EXISTS transporte (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    capacidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    horario JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de reservas de transporte
CREATE TABLE IF NOT EXISTS reserva_transporte (
    id INT PRIMARY KEY AUTO_INCREMENT,
    transporte_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    num_personas INT NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (transporte_id) REFERENCES transporte(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS servicio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    duracion VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de reservas de servicios
CREATE TABLE IF NOT EXISTS reserva_servicio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    servicio_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    precio_total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada') DEFAULT 'pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (servicio_id) REFERENCES servicio(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    direccion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla de relación entre categorías y elementos
CREATE TABLE IF NOT EXISTS categoria_elemento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    categoria_id INT NOT NULL,
    tipo ENUM('hotel', 'actividad', 'zona', 'restaurante') NOT NULL,
    elemento_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar datos de ejemplo para categorías
INSERT INTO categoria (nombre, descripcion) VALUES
('Playa', 'Lugares con acceso a playas y actividades acuáticas'),
('Montaña', 'Destinos en zonas montañosas y senderismo'),
('Ciudad', 'Atracciones urbanas y vida nocturna'),
('Cultural', 'Sitios históricos y museos'),
('Gastronomía', 'Restaurantes y experiencias culinarias');

-- Insertar datos de ejemplo para administradores
INSERT INTO admin_users (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@egturismo.com', 'Administrador Principal'); 