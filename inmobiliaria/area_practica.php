<?php
require_once 'conexion.php';

// Obtener todas las áreas de práctica
try {
    $stmt = $conn->query("SELECT * FROM areas_practica ORDER BY nombre");
    $areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error al obtener áreas de práctica: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Áreas de Práctica | Estudio Jurídico Inmobiliario</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos base iguales al index.php */
        :root {
            --primary-color: #0a2540;
            --secondary-color: #d4af37;
            --accent-color: #1a4b8c;
            --light-color: #f5f5f5;
            --dark-color: #333;
            --medium-gray: #666;
            --white: #fff;
        }
        
        /* Mantener los mismos estilos de header, footer y componentes */
        
        /* Estilos específicos para la página de áreas */
        .page-header {
            background: linear-gradient(rgba(10, 37, 64, 0.8), rgba(10, 37, 64, 0.8)), 
                        url('img/ley-books.jpg') center/cover no-repeat;
            color: var(--white);
            padding: 120px 0 80px;
            text-align: center;
            margin-top: 70px;
        }
        
        .page-header h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
        }
        
        .page-header p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .areas-container {
            padding: 80px 0;
        }
        
        .area-card {
            display: flex;
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        
        .area-card:hover {
            transform: translateY(-5px);
        }
        
        .area-icon {
            flex: 0 0 100px;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: var(--white);
        }
        
        .area-content {
            flex: 1;
            padding: 30px;
        }
        
        .area-content h2 {
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .area-content p {
            margin-bottom: 20px;
            color: var(--medium-gray);
        }
        
        @media (max-width: 768px) {
            .area-card {
                flex-direction: column;
            }
            
            .area-icon {
                flex: 0 0 80px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <i class="fas fa-balance-scale"></i> Estudio Jurídico Inmobiliario
            </div>
            <nav class="nav-links">
                <a href="index.php">Inicio</a>
                <a href="areas-practica.php" class="active">Áreas de Práctica</a>
                <a href="equipo.php">Nuestro Equipo</a>
                <a href="casos.php">Casos de Estudio</a>
                <a href="contacto.php">Contacto</a>
            </nav>
        </div>
    </header>

    <section class="page-header">
        <div class="container">
            <h1>Nuestras Áreas de Práctica</h1>
            <p>Especialización en diversas ramas del derecho inmobiliario para ofrecer soluciones integrales a nuestros clientes</p>
        </div>
    </section>

    <section class="areas-container">
        <div class="container">
            <?php foreach ($areas as $area): ?>
            <div class="area-card">
                <div class="area-icon">
                    <i class="fas <?php echo htmlspecialchars($area['icono']); ?>"></i>
                </div>
                <div class="area-content">
                    <h2><?php echo htmlspecialchars($area['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($area['descripcion']); ?></p>
                    <a href="area-practica.php?id=<?php echo $area['id_area']; ?>" class="btn btn-primary">Ver detalles</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer y scripts similares al index.php -->
</body>
</html>