// Ejemplo: Botón de "Contactar" que abre WhatsApp
document.querySelectorAll(".contact-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        const phone = "521234567890"; // Número de tu mamá
        window.open(`https://wa.me/${phone}?text=Me%20interesa%20una%20propiedad`);
    });
});