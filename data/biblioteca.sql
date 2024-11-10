-- Crear la base de datos
CREATE DATABASE biblioteca;
USE biblioteca;

-- Crear la tabla usuarios
CREATE TABLE usuarios (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT(11),
    nick_usuario VARCHAR(10) UNIQUE,
    contrasena VARCHAR(255)
);

-- Crear la tabla pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    fecha DATE NOT NULL,
    usuario VARCHAR(10) NOT NULL,
    FOREIGN KEY (usuario) REFERENCES usuarios(nick_usuario)
);