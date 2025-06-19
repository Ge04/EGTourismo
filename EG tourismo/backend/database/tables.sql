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