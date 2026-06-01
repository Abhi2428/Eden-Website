// Expandable Service Cards - Accordion
document.addEventListener('DOMContentLoaded', function() {
    var cards = document.querySelectorAll('.service-card');
    
    cards.forEach(function(card) {
        card.addEventListener('click', function() {
            var parent = this.closest('.services-grid');
            var isExpanded = this.classList.contains('expanded');
            
            // Close all other cards in same grid
            if (parent) {
                parent.querySelectorAll('.service-card.expanded').forEach(function(openCard) {
                    if (openCard !== card) {
                        openCard.classList.remove('expanded');
                    }
                });
            }
            
            // Toggle current card
            this.classList.toggle('expanded');
        });
    });
});
