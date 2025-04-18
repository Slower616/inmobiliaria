<?php
session_start();
require_once 'conexion.php';

// Verificar autenticación
if (!isset($_SESSION['admin_loggedin'])) {
    header("Location: login.php");
    exit;
}

// Obtener consultas
try {
    $stmt = $conn->query("
        SELECT c.*, a.nombre as area_nombre 
        FROM consultas c
        JOIN areas_practica a ON c.id_area = a.id_area
        ORDER BY c.fecha DESC
    ");
    $consultas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error al obtener consultas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ... (head del dashboard) ... -->
    <style>
        /* Estilos para la tabla de consultas */
        .consultas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .consultas-table th, .consultas-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .consultas-table th {
            background-color: var(--primary-color);
            color: white;
        }
        
        .consultas-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-pendiente {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .badge-atendida {
            background-color: #d4edda;
            color: #155724;
        }
        
        .action-btn {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        
        .btn-atender {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        
        .btn-eliminar {
            background-color: var(--danger);
            color: white;
        }
    </style>
</head>
<body>
    <!-- ... (estructura del dashboard) ... -->
    
    <div class="admin-content">
        <h2>Consultas Recibidas</h2>
        
        <table class="consultas-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre</th>
                    <th>Área</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($consulta['fecha'])); ?></td>
                    <td><?php echo htmlspecialchars($consulta['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($consulta['area_nombre']); ?></td>
                    <td>
                        <span class="badge <?php echo $consulta['atendida'] ? 'badge-atendida' : 'badge-pendiente'; ?>">
                            <?php echo $consulta['atendida'] ? 'Atendida' : 'Pendiente'; ?>
                        </span>
                    </td>
                    <td>
                        <button class="action-btn btn-atender" data-id="<?php echo $consulta['id_consulta']; ?>">
                            Marcar como atendida
                        </button>
                        <button class="action-btn btn-eliminar" data-id="<?php echo $consulta['id_consulta']; ?>">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Manejo de acciones
        document.querySelectorAll('.btn-atender').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('¿Marcar esta consulta como atendida?')) {
                    window.location.href = `marcar_atendida.php?id=${id}`;
                }
            });
        });
        
        document.querySelectorAll('.btn-eliminar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                if (confirm('¿Eliminar permanentemente esta consulta?')) {
                    window.location.href = `eliminar_consulta.php?id=${id}`;
                }
            });
        });
    </script>
</body>
</html>