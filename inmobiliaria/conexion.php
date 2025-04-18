<?php
$host = "localhost";
$dbname = "asesoramiento_judicial";
$username_db = "root";
$password_db = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Crear tabla de consultas si no existe
    $conn->exec("CREATE TABLE IF NOT EXISTS consultas (
        id_consulta INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        telefono VARCHAR(20),
        id_area INT NOT NULL,
        descripcion TEXT NOT NULL,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
        atendida BOOLEAN DEFAULT FALSE,
        FOREIGN KEY (id_area) REFERENCES areas_practica(id_area)
    )");
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>