-- Create database if not exists
Drop database eg_tourism;
CREATE DATABASE IF NOT EXISTS eg_tourism;
USE eg_tourism;
insert into usuario (nombre, apellido, email, telefono, passw) values ('Manuel', 'Perez', 'as@gmail.com', '123456789', '1234');
insert into usuario (nombre, apellido, email, telefono, passw) values ('Maria', 'Lopez', 'f@gmai;.com', '987654321', '1234');
insert into usuario (nombre, apellido, email, telefono, passw) values ('Juan', 'Gomez', 'gh@gmail.com', '456789123', '1234');

INSERT INTO reserva (id_usuario, fecha_reser, duracion, precio) VALUES
(1, '2023-10-01', '3 días', 150.00),
(2, '2023-10-05', '2 días', 100.00),
(3, '2023-10-10', '5 días', 300.00);

SELECT MONTHNAME(fecha_reser) AS mes, COUNT(id) AS total
        FROM reserva
        GROUP BY mes, MONTH(fecha_reser)
        ORDER BY MONTH(fecha_reser);


SELECT*From transporte;
SHOW TABLES;
DESCRIBE zona_turismo;
DESCRIBE zona_turismo;
SELECT * FROM usuario;
SELECT * FROM reserva;
-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Usuario table
CREATE TABLE IF NOT EXISTS usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    passw varchar(225) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Foto (User photo, linked to usuario)
CREATE TABLE IF NOT EXISTS foto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    url_img VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);
describe reserva;
SELECT * FROM reserva;
-- Reserva table (no paquete)
CREATE TABLE IF NOT EXISTS reserva (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    fecha_reser DATE,
    duracion VARCHAR(50),
    precio DECIMAL(10,2),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

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
INSERT INTO servicios (nombre, descripcion, precio, guia_turist, telefono, correo, d_servicio) VALUES
('Guía Turístico', 'Servicio de guía turístico para tours personalizados.', 50.00, 'Carlos Pérez', '123456789', 'asepere@gmail.com', 'Guía turístico'),
('Transporte Privado', 'Servicio de transporte privado para grupos.', 100.00, 'Ana López', '987654321', 'analo@gmail.com', 'Transporte privado'),
('Excursión a la Montaña', 'Excursión guiada a la montaña con almuerzo incluido.', 75.00, 'Luis García', '456789123', 'se@gmail.com', 'Excursión a la montaña');
CREATE TABLE IF NOT EXISTS actividad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(100),
    Descripcion TEXT
);
INSERT INTO actividad (tipo, Descripcion) VALUES
('Senderismo', 'Actividad de senderismo guiado por rutas naturales.'),
('Ciclismo', 'Recorridos en bicicleta por paisajes escénicos.'),
('Avistamiento de Aves', 'Tours especializados en avistamiento de aves locales.'),
('Fotografía de Naturaleza', 'Sesiones de fotografía en entornos naturales.'),
('Cultura Local', 'Experiencias culturales con comunidades locales.');
CREATE TABLE IF NOT EXISTS hotel (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_hotel VARCHAR(100) NOT NULL,
    descripcion TEXT,
    correo VARCHAR(100),
    telefono VARCHAR(20),
    imagen VARCHAR(255) NOT NULL,
    servicio_id INT,
    FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE SET NULL,
    ubicacion VARCHAR(255),
    estrellas INT CHECK (estrellas BETWEEN 1 AND 5),
    actividad_id INT,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE SET NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO hotel (nom_hotel, descripcion, correo, telefono, imagen, ubicacion, estrellas) VALUES
('Hotel Panafrica', 'Hotel de lujo con vistas al mar.', 'swe@gmail.com', '123456789', 'hotel_paraiso.jpg', 'Playa del Sol', 5),
('Grand Hotel Djibloho', 'Hotel ecológico en la montaña.', 'des@gmail.com', '987654321', 'hotel_montana_verde.jpg', 'Valle Verde', 4),
('Hotel Bata', 'Hotel céntrico con todas las comodidades.', 'dora@gmail.com', '456789123', 'hotel_ciudad_dorada.jpg', 'Centro de la Ciudad', 3);
-- Zona_Turismo table
CREATE TABLE IF NOT EXISTS transporte (
    id INT PRIMARY KEY AUTO_INCREMENT,
    telefono VARCHAR(20),
    correo VARCHAR(100),
    tipo_transporte VARCHAR(100) NOT NULL,
    precio int(10),
    ruta VARCHAR(255),
    imag varchar(60)
);
INSERT INTO transporte (telefono, correo, tipo_transporte, precio, ruta, imag) VALUES
('123456789', 'lu@gmail.com', 'Taxi', 20, 'Ruta 1', 'taxi.jpg'),
('987654321', 'er@gmail.com', 'Autobús', 10, 'Ruta 2', 'autobus.jpg'),
('456789123', 'df@gmail.com', 'Bicicleta', 5, 'Ruta 3', 'bicicleta.jpg');
CREATE TABLE IF NOT EXISTS restaurantes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    direccion VARCHAR(255),
    telefono VARCHAR(20),
    correo VARCHAR(100)
);
INSERT INTO restaurantes (nombre, descripcion, direccion, telefono, correo) VALUES
('Restaurante El Sabor', 'Cocina local con ingredientes frescos.', 'Calle Principal 123', '123456789', 'res@gmail.com'),
('Restaurante La Vista', 'Vistas panorámicas y cocina internacional.', 'Avenida del Mar 456', '987654321', 'yummi@gmail.com'),
('Restaurante Gourmet', 'Experiencia gastronómica de alta cocina.', 'Boulevard Gourmet 789', '456789123', 'labola@gmail.com');
CREATE TABLE IF NOT EXISTS zona_turismo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    ubicacion VARCHAR(255),
    atractivos TEXT,
    hotel_id INT,
    FOREIGN KEY (hotel_id) REFERENCES hotel(id) ON DELETE SET NULL,
    actividad_id INT,
    FOREIGN KEY (actividad_id) REFERENCES actividad(id) ON DELETE SET NULL,
    transporte_id INT,
    FOREIGN KEY (transporte_id) REFERENCES transporte(id) ON DELETE SET NULL,   
    restaurante_id INT,
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE SET NULL,
    id_reserva INT,
    FOREIGN KEY (reserva_id) REFERENCES reserva(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO zona_turismo (nombre, descripcion, ubicacion, atractivos, hotel_id, actividad_id, transporte_id, restaurante_id) VALUES
('Playa del Sol', 'Hermosa playa con arena blanca y aguas cristalinas.', 'Calle Playa 123', 'Surf, Buceo', 1, 1, 1, 1),
('Valle Verde', 'Valle montañoso con rutas de senderismo.', 'Avenida Valle 456', 'Senderismo, Ciclismo', 2, 2, 2, 2),
('Centro Histórico', 'Zona cultural con museos y arquitectura colonial.', 'Calle Centro 789', 'Cultura Local', 3, 3, 3, 3);

-- Reseña (Review) table for Transporte
CREATE TABLE IF NOT EXISTS resena (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_trans INT NOT NULL,
    resena TEXT,
    FOREIGN KEY (id_trans) REFERENCES transporte(id) ON DELETE CASCADE
);

-- Restaurantes table

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
INSERT INTO reserva_zona (reserva_id, zona_id) VALUES
(1, 1),
(2, 2),
(3, 3);

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

-- Sample admin user (password: admin123)
INSERT IGNORE INTO admin_users (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@egturismo.com', 'Administrador');
INSERT IGNORE INTO admin_users (username, password, email, full_name) VALUES
('superadmin', '1234', 'arse@egturismo.com', 'Super Administrador');
SELECT * FROM admin_users;

SELECT * FROM transporte;