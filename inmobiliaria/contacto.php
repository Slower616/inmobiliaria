<?php
// Configuración de WhatsApp
define('WHATSAPP_NUMBER', '584163117367'); // Número de WhatsApp con prefijo de país
define('WHATSAPP_DEFAULT_MESSAGE', 'Hola, estoy interesado/a en una consulta legal con el Estudio Jurídico Acuña');

// Configuración de correo electrónico
define('EMAIL_TO', 'yumili3369@yahoo.com.ve'); // Correo donde se recibirán las consultas
define('EMAIL_FROM', 'noreply@estudiojuridico.com'); // Correo desde donde se enviarán las consultas
define('EMAIL_SUBJECT', 'Nueva consulta legal desde el sitio web');
define('CONSULTAS_FILE', __DIR__ . '/../consultas.txt'); // Archivo para guardar las consultas

/**
 * Genera un enlace de WhatsApp con un mensaje personalizado
 * 
 * @param string $message Mensaje personalizado (opcional)
 * @return string URL de WhatsApp
 */
function getWhatsAppLink($message = '') {
    $number = WHATSAPP_NUMBER;
    $defaultMessage = WHATSAPP_DEFAULT_MESSAGE;
    
    // Si no se proporciona mensaje, usar el predeterminado
    if (empty($message)) {
        $message = $defaultMessage;
    }
    
    // Codificar el mensaje para la URL
    $encodedMessage = urlencode($message);
    
    // Construir y devolver la URL de WhatsApp
    return "https://wa.me/{$number}?text={$encodedMessage}";
}

/**
 * Genera un enlace de WhatsApp para un formulario de consulta
 * 
 * @param array $formData Datos del formulario (nombre, email, telefono, area, descripcion)
 * @return string URL de WhatsApp con mensaje formateado
 */
function getWhatsAppConsultationLink($formData) {
    $number = WHATSAPP_NUMBER;
    
    // Formatear el mensaje con los datos del formulario
    $message = "Nueva consulta legal:\n\n";
    $message .= "Nombre: " . $formData['nombre'] . "\n";
    $message .= "Email: " . $formData['email'] . "\n";
    
    if (!empty($formData['telefono'])) {
        $message .= "Teléfono: " . $formData['telefono'] . "\n";
    }
    
    $message .= "Área: " . $formData['area'] . "\n";
    $message .= "Descripción: " . $formData['descripcion'];
    
    // Codificar el mensaje para la URL
    $encodedMessage = urlencode($message);
    
    // Construir y devolver la URL de WhatsApp
    return "https://wa.me/{$number}?text={$encodedMessage}";
}

/**
 * Guarda los datos de la consulta en un archivo de texto
 * 
 * @param array $formData Datos del formulario (nombre, email, telefono, area, descripcion)
 * @return bool True si se guardó correctamente, false en caso contrario
 */
function enviarCorreoConsulta($formData) {
    try {
        // Construir el contenido del archivo
        $content = "=== NUEVA CONSULTA LEGAL ===\n";
        $content .= "Fecha: " . date('d/m/Y H:i:s') . "\n";
        $content .= "Nombre: " . $formData['nombre'] . "\n";
        $content .= "Email: " . $formData['email'] . "\n";
        
        if (!empty($formData['telefono'])) {
            $content .= "Teléfono: " . $formData['telefono'] . "\n";
        }
        
        $content .= "Área: " . $formData['area'] . "\n";
        $content .= "Descripción: " . $formData['descripcion'] . "\n";
        $content .= "================================\n\n";
        
        // Guardar en el archivo
        $result = file_put_contents(CONSULTAS_FILE, $content, FILE_APPEND);
        
        return $result !== false;
    } catch (Exception $e) {
        error_log("Error al guardar la consulta: " . $e->getMessage());
        return false;
    }
}
?> 