<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Estudio Jurídico Inmobiliario'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <?php if(isset($custom_css)): ?>
    <link rel="stylesheet" href="css/<?php echo $custom_css; ?>">
    <?php endif; ?>
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-balance-scale"></i> Estudio Jurídico Inmobiliario
            </div>
            <nav class="nav-links">
                <a href="index.php">Inicio</a>
                <a href="areas-practica.php">Áreas de Práctica</a>
                <a href="equipo.php">Nuestro Equipo</a>
                <a href="casos.php">Casos de Estudio</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>
    </header>