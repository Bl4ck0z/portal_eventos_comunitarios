// Añadir efecto de hover a las tarjetas de eventos

document.addEventListener('DOMContentLoaded', function() {
    const eventCards = document.querySelectorAll('.event-card');
    eventCards.forEach(card => {
        card.style.transition = 'transform 0.3s ease-in-out';

        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
        });
    });
});
