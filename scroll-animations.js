// ===== SCROLL ANIMATIONS (IntersectionObserver) =====
document.addEventListener('DOMContentLoaded', function() {

    // --- Hero entrance animation (auto on page load) ---
    var heroAnims = document.querySelectorAll('.hero-anim');
    heroAnims.forEach(function(el, i) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        el.style.transitionDelay = (i * 0.2) + 's';
        setTimeout(function() {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 100);
    });

    // --- Scroll-triggered animations ---
    var animElements = document.querySelectorAll('.anim, .fade-in');

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);

                    // Stat counter animation
                    if (entry.target.classList.contains('stat-card') || entry.target.closest('.stat-card')) {
                        var numEl = entry.target.querySelector('.stat-number');
                        if (numEl) animateCounter(numEl);
                    }
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        animElements.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        // Fallback for old browsers
        animElements.forEach(function(el) {
            el.classList.add('visible');
        });
    }

    // --- Counter animation for stat numbers ---
    function animateCounter(el) {
        var text = el.textContent.trim();
        var match = text.match(/([0-9]+)/);
        if (!match) return;

        var target = parseInt(match[0]);
        var suffix = text.replace(match[0], '');
        var duration = 2000;
        var start = 0;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            var current = Math.floor(eased * target);
            el.textContent = current + suffix;
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target + suffix;
            }
        }

        el.textContent = '0' + suffix;
        requestAnimationFrame(step);
    }
});
