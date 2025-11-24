CREATE TABLE roles (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  descripcion TEXT
);
 
CREATE TABLE usuarios (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(150) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  id_rol BIGINT NOT NULL,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_rol FOREIGN KEY (id_rol) REFERENCES roles(id)
);
 
CREATE TABLE clientes (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  nombres VARCHAR(100) NOT NULL,
  apellidos VARCHAR(100) NOT NULL,
  telefono VARCHAR(50),
  correo_electronico VARCHAR(150) UNIQUE,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
CREATE TABLE vehiculos (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  id_cliente BIGINT NOT NULL,
  marca VARCHAR(100) NOT NULL,
  modelo VARCHAR(100) NOT NULL,
  anio INT NOT NULL,
  tipo_motor ENUM('dos_tiempos', 'cuatro_tiempos') NOT NULL DEFAULT 'dos_tiempos',
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_cliente FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);
 
CREATE TABLE servicios (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  id_vehiculo BIGINT NOT NULL,
  id_usuario BIGINT NOT NULL,
  descripcion TEXT NOT NULL,
  fecha_servicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  costo DECIMAL(10, 2) NOT NULL,
  CONSTRAINT fk_vehiculo FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id),
  CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);