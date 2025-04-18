<?php
require_once 'conexion.php';

// Obtener abogados disponibles
try {
    $stmt = $conn->query("SELECT * FROM abogados ORDER BY nombre");
    $abogados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error al obtener abogados: " . $e->getMessage());
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_abogado = $_POST['id_abogado'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $motivo = $_POST['motivo'];
    
    try {
        $conn->beginTransaction();
        
        // Insertar cita
        $stmt = $conn->prepare("INSERT INTO citas 
                              (id_abogado, fecha, hora, nombre_cliente, email, telefono, motivo, estado) 
                              VALUES 
                              (:id_abogado, :fecha, :hora, :nombre, :email, :telefono, :motivo, 'pendiente')");
        $stmt->execute([
            ':id_abogado' => $id_abogado,
            ':fecha' => $fecha,
            ':hora' => $hora,
            ':nombre' => $nombre,
            ':email' => $email,
            ':telefono' => $telefono,
            ':motivo' => $motivo
        ]);
        
        // Enviar confirmación (simulado)
        $asunto = "Confirmación de cita con Estudio Jurídico";
        $mensaje = "Estimado/a $nombre,\n\n";
        $mensaje .= "Su cita con nuestro abogado ha sido programada para:\n";
        $mensaje .= "Fecha: " . date('d/m/Y', strtotime($fecha)) . "\n";
        $mensaje .= "Hora: $hora\n\n";
        $mensaje .= "Modalidad: Videollamada (recibirá el enlace 1 hora antes)\n\n";
        $mensaje .= "Gracias por confiar en nuestro estudio.\n\n";
        $mensaje .= "Atentamente,\nEl equipo de Estudio Jurídico Inmobiliario";
        
        // mail($email, $asunto, $mensaje); // Descomentar en producción
        
        $conn->commit();
        
        header("Location: confirmacion-cita.php?id=" . $conn->lastInsertId());
        exit;
        
    } catch(PDOException $e) {
        $conn->rollBack();
        $error = "Error al agendar la cita: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita | Estudio Jurídico</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --navy-blue: #0a2540;
            --royal-blue: #1a4b8c;
            --light-blue: #4d8bd4;
            --gold: #d4af37;
            --dark-gray: #333;
            --medium-gray: #666;
            --light-gray: #f5f5f5;
            --white: #fff;
            --success: #28a745;
            --danger: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: var(--dark-gray);
            background-color: var(--light-gray);
            padding-top: 80px;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        .header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        /* Card Styles */
        .card {
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background-color: var(--navy-blue);
            color: var(--white);
            padding: 20px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--navy-blue);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
            border: none;
            font-size: 1rem;
        }
        
        .btn-gold {
            background-color: var(--gold);
            color: var(--navy-blue);
        }
        
        .btn-gold:hover {
            background-color: #c9a227;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(10, 37, 64, 0.8);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            color: var(--white);
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: var(--gold);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Responsive Grid */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        
        .col-md-6, .col-md-4 {
            padding: 0 15px;
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        @media (min-width: 768px) {
            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .col-md-4 {
                flex: 0 0 33.333%;
                max-width: 33.333%;
            }
        }
        
        /* Form Check */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-check-input {
            margin-right: 10px;
        }
        
        /* Modal Trigger Links */
        [data-toggle="modal"] {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }
        
        [data-toggle="modal"]:hover {
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            
            .card-body {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p class="text-white mt-3">Procesando su solicitud...</p>
    </div>

    <header class="header">
        <div class="container">
            <div class="logo" style="padding: 15px 0;">
                <i class="fas fa-balance-scale"></i> Estudio Jurídico Inmobiliario
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header">
                        <h2 class="mb-0"><i class="fas fa-calendar-check mr-2"></i> Agendar Consulta</h2>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form id="citaForm" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_abogado">Abogado Especialista</label>
                                        <select class="form-control" id="id_abogado" name="id_abogado" required>
                                            <option value="">Seleccione un abogado</option>
                                            <?php foreach ($abogados as $abogado): ?>
                                            <option value="<?php echo $abogado['id_abogado']; ?>">
                                                <?php echo htmlspecialchars($abogado['nombre']); ?> - <?php echo htmlspecialchars($abogado['especialidad']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="motivo">Motivo de Consulta</label>
                                        <select class="form-control" id="motivo" name="motivo" required>
                                            <option value="">Seleccione un motivo</option>
                                            <option value="sucesiones">Sucesiones y Herencias</option>
                                            <option value="desalojos">Desalojos y Recuperación</option>
                                            <option value="contratos">Revisión de Contratos</option>
                                            <option value="usucapion">Usucapión (Prescripción Adquisitiva)</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha</label>
                                        <input type="date" class="form-control" id="fecha" name="fecha" min="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hora">Hora</label>
                                        <select class="form-control" id="hora" name="hora" required>
                                            <option value="">Seleccione una hora</option>
                                            <option value="09:00">09:00 AM</option>
                                            <option value="10:30">10:30 AM</option>
                                            <option value="12:00">12:00 PM</option>
                                            <option value="15:00">03:00 PM</option>
                                            <option value="16:30">04:30 PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Completo</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="detalles">Detalles Adicionales</label>
                                <textarea class="form-control" id="detalles" name="detalles" rows="3"></textarea>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="confirmacion" required>
                                <label class="form-check-label" for="confirmacion">
                                    Acepto la <a href="#" data-toggle="modal" data-target="#politicaPrivacidad">Política de Privacidad</a> y los 
                                    <a href="#" data-toggle="modal" data-target="#terminosServicio">Términos de Servicio</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-gold btn-block py-3">
                                <i class="fas fa-calendar-check mr-2"></i> Confirmar Cita
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Política de Privacidad -->
    <div class="modal fade" id="politicaPrivacidad" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Política de Privacidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Texto detallado de la política de privacidad...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Términos de Servicio -->
    <div class="modal fade" id="terminosServicio" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Términos de Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Texto detallado de los términos de servicio...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('citaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if (!document.getElementById('confirmacion').checked) {
                alert('Debe aceptar la Política de Privacidad y los Términos de Servicio');
                return;
            }
            
            // Mostrar loading
            document.getElementById('loading').style.display = 'flex';
            
            // Simular procesamiento (en producción sería una petición AJAX real)
            setTimeout(() => {
                this.submit();
            }, 1500);
        });

        // Validación en tiempo real
        document.getElementById('fecha').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                alert('No puede seleccionar una fecha anterior a hoy');
                this.value = '';
            }
        });

        // Efectos para botones
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
            
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(1px)';
            });
            
            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-3px)';
            });
        });

        // Simulación de modales (en producción usar Bootstrap JS)
        document.querySelectorAll('[data-toggle="modal"]').forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                document.querySelector(target).style.display = 'block';
            });
        });

        document.querySelectorAll('.modal .close, .modal .btn-secondary').forEach(closeBtn => {
            closeBtn.addEventListener('click', function() {
                this.closest('.modal').style.display = 'none';
            });
        });
    </script>
</body>
</html>