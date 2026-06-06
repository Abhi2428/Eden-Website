document.addEventListener('DOMContentLoaded', function () {

    // ===== STICKY NAVBAR =====
    const navbar = document.querySelector('.navbar');
    function handleScroll() {
        if (window.scrollY > 80) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleScroll);
    handleScroll();

    // ===== LAZY LOAD HERO VIDEO (INJECT AFTER PAGE LOAD) =====
    var heroWrap = document.getElementById('hero-video-wrap');
    if (heroWrap) {
        function injectHeroVideo() {


            var themeUrl = heroWrap.querySelector('.hero-poster').src;
            var baseUrl = themeUrl.substring(0, themeUrl.lastIndexOf('/assets/')) + '/assets/videos/';

            var video = document.createElement('video');
            video.className = 'hero-bg-video';
            video.muted = true;
            video.loop = true;
            video.playsInline = true;
            video.setAttribute('aria-hidden', 'true');

            // Try WebM first (smaller), fallback to MP4
            var sourceWebm = document.createElement('source');
            sourceWebm.src = baseUrl + 'hero-bg.webm';
            sourceWebm.type = 'video/webm';

            var sourceMp4 = document.createElement('source');
            sourceMp4.src = baseUrl + 'hero-bg.mp4';
            sourceMp4.type = 'video/mp4';

            video.appendChild(sourceWebm);
            video.appendChild(sourceMp4);

            // Insert video before the overlay
            var overlay = heroWrap.querySelector('.hero-video-overlay');
            heroWrap.insertBefore(video, overlay);

            video.play().then(function () {
                // Fade out poster once video is playing
                var poster = heroWrap.querySelector('.hero-poster');
                if (poster) poster.classList.add('hidden');
            }).catch(function () {
                // Autoplay blocked — poster stays, no problem
            });
        }

        // Wait until page is fully loaded (all other assets done)
        if (document.readyState === 'complete') {
            setTimeout(injectHeroVideo, 100);
        } else {
            window.addEventListener('load', function () {
                setTimeout(injectHeroVideo, 100);
            });
        }
    }

    // ===== HAMBURGER MENU =====
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');

    if (hamburger) {
        hamburger.addEventListener('click', function (e) {
            e.stopPropagation();
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }

    // Close menu when clicking a nav link
    document.querySelectorAll('.nav-links > li > a:not(.dropdown-toggle)').forEach(function (link) {
        link.addEventListener('click', function () {
            if (navLinks.classList.contains('active')) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (e) {
        if (navLinks && navLinks.classList.contains('active')) {
            if (!navLinks.contains(e.target) && !hamburger.contains(e.target)) {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            }
        }
    });

    // ===== MOBILE DROPDOWN =====
    const dropdownToggle = document.querySelector('.dropdown-toggle');
    const dropdown = document.querySelector('.dropdown');

    if (dropdownToggle) {
        dropdownToggle.addEventListener('click', function (e) {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                dropdown.classList.toggle('active');
            }
        });

        // Desktop: show dropdown on hover
        if (dropdown) {
            dropdown.addEventListener('mouseenter', function () {
                if (window.innerWidth > 992) {
                    dropdown.classList.add('active');
                }
            });
            dropdown.addEventListener('mouseleave', function () {
                if (window.innerWidth > 992) {
                    dropdown.classList.remove('active');
                }
            });
        }
    }

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                if (navLinks && navLinks.classList.contains('active')) {
                    hamburger.classList.remove('active');
                    navLinks.classList.remove('active');
                }
            }
        });
    });

    // ===== SCROLL ANIMATIONS (Intersection Observer) =====
    const fadeElements = document.querySelectorAll('.fade-in');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        fadeElements.forEach(function (el) {
            observer.observe(el);
        });
    } else {
        // Fallback: show all immediately
        fadeElements.forEach(function (el) {
            el.classList.add('visible');
        });
    }

    // ===== TESTIMONIAL CAROUSEL - ARROWS + HOVER PAUSE =====
    var tViewport = document.querySelector('.testimonial-viewport');
    var tTrack = document.querySelector('.testimonial-track');
    var tCards = document.querySelectorAll('.testimonial-card');
    var tPrev = document.querySelector('.testimonial-prev');
    var tNext = document.querySelector('.testimonial-next');

    if (tTrack && tCards.length > 0) {
        var tCurrent = 0;
        var tTotal = tCards.length;
        var tAutoInterval = null;
        var tIsHovering = false;

        function tGoTo(index) {
            if (index >= tTotal) index = 0;
            if (index < 0) index = tTotal - 1;
            tCurrent = index;
            tTrack.style.transform = 'translateX(-' + (tCurrent * 100) + '%)';
        }

        function tNextSlide() {
            tGoTo(tCurrent + 1);
        }

        function tStartAuto() {
            // Always clear first to prevent duplicates
            if (tAutoInterval) {
                clearInterval(tAutoInterval);
                tAutoInterval = null;
            }
            tAutoInterval = setInterval(tNextSlide, 5000);
        }

        function tStopAuto() {
            if (tAutoInterval) {
                clearInterval(tAutoInterval);
                tAutoInterval = null;
            }
        }

        // Arrow clicks — only restart auto if NOT hovering
        if (tNext) {
            tNext.addEventListener('click', function () {
                tGoTo(tCurrent + 1);
                tStopAuto();
                if (!tIsHovering) {
                    tStartAuto();
                }
            });
        }

        if (tPrev) {
            tPrev.addEventListener('click', function () {
                tGoTo(tCurrent - 1);
                tStopAuto();
                if (!tIsHovering) {
                    tStartAuto();
                }
            });
        }

        // Pause on hover — track hover state
        var tSlider = document.querySelector('.testimonial-slider');
        if (tSlider) {
            tSlider.addEventListener('mouseenter', function () {
                tIsHovering = true;
                tStopAuto();
            });
            tSlider.addEventListener('mouseleave', function () {
                tIsHovering = false;
                tStartAuto();
            });
        }

        // Touch swipe support
        var tStartX = 0;
        if (tViewport) {
            tViewport.addEventListener('touchstart', function (e) {
                tStartX = e.touches[0].clientX;
                tStopAuto();
            });
            tViewport.addEventListener('touchend', function (e) {
                var diff = tStartX - e.changedTouches[0].clientX;
                if (diff > 50) {
                    tGoTo(tCurrent + 1);
                } else if (diff < -50) {
                    tGoTo(tCurrent - 1);
                }
                if (!tIsHovering) {
                    tStartAuto();
                }
            });
        }

        // Start auto-scroll
        tStartAuto();
    }
    // ===== TRUST BAR INFINITE SCROLL =====
    const trustTrack = document.querySelector('.trust-track');
    if (trustTrack) {
        const items = Array.from(trustTrack.children);
        // Clone all items and append for seamless loop
        items.forEach(function (item) {
            const clone = item.cloneNode(true);
            trustTrack.appendChild(clone);
        });
    }

    // ===== ACTIVE NAV LINK =====
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav-links > li > a').forEach(function (link) {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === '' && href === 'index.html')) {
            link.style.color = '#ffffff';
            link.style.background = 'rgba(255,255,255,0.1)';
        }
    });
    // ===== MARQUEE CENTER HIGHLIGHT =====
    var trustTrackEl = document.querySelector('.trust-track');
    if (trustTrackEl) {
        function highlightCenterLogo() {
            var logos = trustTrackEl.querySelectorAll('.trust-item-logo');
            var center = window.innerWidth / 2;
            var closest = null;
            var minDist = Infinity;

            logos.forEach(function (logo) {
                logo.classList.remove('center-highlight');
                var rect = logo.getBoundingClientRect();
                var logoCenter = rect.left + (rect.width / 2);
                var dist = Math.abs(logoCenter - center);
                if (dist < minDist) {
                    minDist = dist;
                    closest = logo;
                }
            });

            if (closest) {
                closest.classList.add('center-highlight');
            }

            requestAnimationFrame(highlightCenterLogo);
        }

        requestAnimationFrame(highlightCenterLogo);
    }

    // ===== CONTACT FORM AJAX SUBMISSION =====
    var contactForm = document.getElementById('eden-contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            var btnText = document.getElementById('btn-text');
            var btnLoading = document.getElementById('btn-loading');
            var submitBtn = document.getElementById('submit-btn');
            var successMsg = document.getElementById('form-success');
            var errorMsg = document.getElementById('form-error');

            // Hide previous messages
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';

            // Validate required fields
            var firstName = document.getElementById('first_name').value.trim();
            var lastName = document.getElementById('last_name').value.trim();
            var email = document.getElementById('email').value.trim();
            var phone = document.getElementById('phone').value.trim();
            var company = document.getElementById('company').value.trim();
            var interest = document.getElementById('interest').value.trim();
            var message = document.getElementById('message').value.trim();

            if (!firstName || !lastName || !email || !phone || !company || !interest || !message) {
                errorMsg.textContent = '❌ Please fill in all required fields.';
                errorMsg.style.display = 'block';
                return;
            }

            // Show loading
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            submitBtn.disabled = true;

            // Gather form data
            var formData = new FormData(contactForm);
            formData.append('action', 'eden_contact_form');

            // Send AJAX request
            fetch(edenAjax.ajaxurl, {
                method: 'POST',
                body: formData,
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.success) {
                        successMsg.style.display = 'block';
                        contactForm.reset();
                        // Scroll to success message
                        successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        errorMsg.textContent = '❌ ' + (data.data.message || 'Something went wrong.');
                        errorMsg.style.display = 'block';
                    }
                })
                .catch(function () {
                    errorMsg.textContent = '❌ Network error. Please try again.';
                    errorMsg.style.display = 'block';
                })
                .finally(function () {
                    btnText.style.display = 'inline';
                    btnLoading.style.display = 'none';
                    submitBtn.disabled = false;
                });
        });
    }
    // Note: enqueue PHP/WordPress scripts should be added in the theme's PHP files,
    // not in this JavaScript file.

});
