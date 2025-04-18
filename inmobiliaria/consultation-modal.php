<!-- Modal de Consulta -->
<div id="consultationModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Describa su caso legal</h2>
        
        <?php if ($mensaje_exito): ?>
            <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
        <?php elseif ($mensaje_error): ?>
            <div class="alert alert-danger"><?php echo $mensaje_error; ?></div>
        <?php endif; ?>
        
        <form id="consultaForm" method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono (opcional)</label>
                <input type="tel" id="telefono" name="telefono" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="id_area">Área de interés</label>
                <select id="id_area" name="id_area" class="form-control" required>
                    <option value="">Seleccione un área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?php echo $area['id_area']; ?>">
                            <?php echo htmlspecialchars($area['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Describa su situación</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required placeholder="Describa su caso con el mayor detalle posible..."></textarea>
            </div>
            
            <button type="submit" name="enviar_consulta" class="btn btn-primary btn-block">Enviar consulta</button>
        </form>
    </div>
</div>