CREATE DATABASE IF NOT EXISTS clinica_dental CHARACTER SET utf8mb4;
USE clinica_dental;
CREATE TABLE usuarios(id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(80), email VARCHAR(100) UNIQUE, password CHAR(64));
CREATE TABLE pacientes(id INT AUTO_INCREMENT PRIMARY KEY, cedula VARCHAR(20) UNIQUE, nombre VARCHAR(60), apellido VARCHAR(60), fecha_nacimiento DATE, telefono VARCHAR(20), alergias VARCHAR(200));
CREATE TABLE procedimientos(id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(80), descripcion VARCHAR(200), precio DECIMAL(10,2));
CREATE TABLE historia(id INT AUTO_INCREMENT PRIMARY KEY, paciente_id INT, procedimiento_id INT, fecha DATE, diente VARCHAR(20), observaciones TEXT,
 FOREIGN KEY(paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE, FOREIGN KEY(procedimiento_id) REFERENCES procedimientos(id));
INSERT INTO usuarios(nombre,email,password) VALUES('Dr. Admin','admin@clinica.com',SHA2('admin123',256));
INSERT INTO procedimientos(nombre,descripcion,precio) VALUES
('Limpieza dental','Profilaxis y remoción de sarro',30),('Blanqueamiento','Blanqueo de la dentadura',120),
('Extracción de muela','Extracción simple',40),('Extracción de cordal','Extracción de muela del juicio',80),
('Tratamiento de conductos','Endodoncia',150),('Calza (resina)','Restauración de muela',35);
