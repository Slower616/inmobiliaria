<footer class="footer">
    <div class="container">
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">
                    <i class="fas fa-balance-scale"></i> Estudio Jurídico
                </div>
                <p>Ofrecemos soluciones legales integrales con profesionalismo, ética y compromiso con nuestros clientes.</p>
                <div class="social-links">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="areas-practica.php">Áreas de Práctica</a></li>
                    <li><a href="equipo.php">Nuestra Abogada</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h3>Contacto</h3>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <p>Av. Principal 1234, Ciudad, País</p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <p><?php echo htmlspecialchars($abogada['telefono'] ?? '+54 11 1234-5678'); ?></p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p><?php echo htmlspecialchars($abogada['email'] ?? 'info@estudiojuridico.com'); ?></p>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> Estudio Jurídico. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>