<?php
require_once 'conexion.php';
session_start();

if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $stmt = $conn->prepare("DELETE FROM consultas WHERE id_consulta = ?");
        $stmt->execute([$id]);
        
        $_SESSION['mensaje'] = "Consulta eliminada correctamente";
    } catch(PDOException $e) {
        $_SESSION['error'] = "Error al eliminar la consulta: " . $e->getMessage();
    }
}

header("Location: dashboard.php");
exit;
?>