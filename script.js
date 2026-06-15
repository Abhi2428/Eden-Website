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



    // =============================================
    // ASSESSMENT FORM — MULTI-STEP WIZARD
    // =============================================
    var assessForm = document.getElementById('edenAssessmentForm');
    if (assessForm) {
        var TOTAL_STEPS = 7;
        var currentStep = 1;
        var STORAGE_KEY = 'eden_assessment_draft';

        var formSection = document.getElementById('assessment-form-section');
        var resultsSection = document.getElementById('resultsSection');
        var progressFill = document.getElementById('progressFill');
        var saveStatus = document.getElementById('saveStatus');

        // ─── Show Step ───
        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(function (el) {
                el.classList.remove('active');
            });
            var target = document.querySelector('.form-step[data-step="' + step + '"]');
            if (target) target.classList.add('active');

            updateProgressBar(step);

            // Smooth scroll to form top
            if (formSection) {
                window.scrollTo({ top: formSection.offsetTop - 30, behavior: 'smooth' });
            }
            currentStep = step;
        }

        function updateProgressBar(step) {
            var percent = ((step - 1) / (TOTAL_STEPS - 1)) * 100;
            if (progressFill) progressFill.style.width = percent + '%';

            document.querySelectorAll('.progress-step').forEach(function (el) {
                var s = parseInt(el.getAttribute('data-step'));
                el.classList.remove('active', 'completed');
                if (s < step) el.classList.add('completed');
                if (s === step) el.classList.add('active');
            });
        }

        // ─── Next / Previous Buttons ───
        document.addEventListener('click', function (e) {
            if (e.target.closest('.btn-next')) {
                if (validateStep(currentStep)) {
                    showStep(currentStep + 1);
                    autoSave();
                }
            }
            if (e.target.closest('.btn-prev')) {
                showStep(currentStep - 1);
            }
        });

        // ─── Validation ───
        function validateStep(step) {
            var isValid = true;
            var stepEl = document.querySelector('.form-step[data-step="' + step + '"]');
            if (!stepEl) return true;

            // Clear previous errors
            stepEl.querySelectorAll('.field-error').forEach(function (el) { el.textContent = ''; });
            stepEl.querySelectorAll('.form-group').forEach(function (el) { el.classList.remove('has-error'); });

            if (step === 1) {
                var nameVal = (document.getElementById('client_name').value || '').trim();
                if (!nameVal) {
                    setFieldError('client_name', 'Organization name is required.');
                    isValid = false;
                }
                var emailVal = (document.getElementById('contact_email').value || '').trim();
                if (!emailVal) {
                    setFieldError('contact_email', 'Email is required.');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
                    setFieldError('contact_email', 'Please enter a valid email address.');
                    isValid = false;
                }
                var phoneVal = (document.getElementById('contact_phone').value || '').trim();
                if (!phoneVal) {
                    setFieldError('contact_phone', 'Phone number is required.');
                    isValid = false;
                }
            }

            if (step === 7) {
                var consent = document.getElementById('consent_checkbox');
                if (consent && !consent.checked) {
                    var consentErr = document.getElementById('consent-error');
                    if (consentErr) consentErr.textContent = 'You must agree to the privacy policy.';
                    isValid = false;
                }
            }

            // Scroll to first error
            if (!isValid) {
                var firstErr = stepEl.querySelector('.has-error');
                if (firstErr) {
                    window.scrollTo({ top: firstErr.offsetTop - 100, behavior: 'smooth' });
                }
            }
            return isValid;
        }

        function setFieldError(id, message) {
            var input = document.getElementById(id);
            if (!input) return;
            var group = input.closest('.form-group');
            if (group) {
                group.classList.add('has-error');
                var errEl = group.querySelector('.field-error');
                if (errEl) errEl.textContent = message;
            }
        }

        // Clear errors on input
        assessForm.addEventListener('input', function (e) {
            var group = e.target.closest('.form-group');
            if (group) {
                group.classList.remove('has-error');
                var errEl = group.querySelector('.field-error');
                if (errEl) errEl.textContent = '';
            }
        });
        assessForm.addEventListener('change', function (e) {
            if (e.target.id === 'consent_checkbox') {
                var ce = document.getElementById('consent-error');
                if (ce) ce.textContent = '';
            }
            var group = e.target.closest('.form-group');
            if (group) {
                group.classList.remove('has-error');
                var errEl = group.querySelector('.field-error');
                if (errEl) errEl.textContent = '';
            }
        });

        // ─── Conditional Logic ───
        document.querySelectorAll('input[name="inhouse_it_support"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var field = document.getElementById('it_staff_field');
                if (!field) return;
                if (this.value === 'yes') {
                    field.style.display = '';
                } else {
                    field.style.display = 'none';
                    var inp = document.getElementById('num_it_support_staff');
                    if (inp) inp.value = '';
                }
            });
        });

        document.querySelectorAll('input[name="dedicated_server_room"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var field = document.getElementById('rack_details_field');
                if (!field) return;
                if (this.value === 'yes') {
                    field.style.display = '';
                } else {
                    field.style.display = 'none';
                    ['num_racks', 'num_patch_panels', 'num_pdus_per_rack'].forEach(function (id) {
                        var inp = document.getElementById(id);
                        if (inp) inp.value = '';
                    });
                }
            });
        });

        // ─── Collect Form Data ───
        function collectFormData() {
            var data = {};
            // Text, number, email, tel, url, textarea, select
            assessForm.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], input[type="tel"], input[type="url"], textarea, select').forEach(function (el) {
                if (el.name) data[el.name] = el.value;
            });
            // Radio buttons
            assessForm.querySelectorAll('input[type="radio"]:checked').forEach(function (el) {
                if (el.name) data[el.name] = el.value;
            });
            // Checkboxes (arrays)
            var cbGroups = {};
            assessForm.querySelectorAll('input[type="checkbox"]:checked').forEach(function (el) {
                if (!el.name) return;
                if (el.name.indexOf('[]') > -1) {
                    var cleanName = el.name.replace('[]', '');
                    if (!cbGroups[cleanName]) cbGroups[cleanName] = [];
                    cbGroups[cleanName].push(el.value);
                } else {
                    data[el.name] = el.value;
                }
            });
            for (var key in cbGroups) {
                data[key] = cbGroups[key];
            }
            return data;
        }

        // ─── Form Submission (fetch API) ───
        assessForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateStep(currentStep)) return;

            var formData = collectFormData();
            var submitBtn = document.getElementById('submitBtn');
            var btnText = submitBtn.querySelector('.btn-text');
            var btnLoading = submitBtn.querySelector('.btn-loading');

            // Show loading
            if (btnText) btnText.style.display = 'none';
            if (btnLoading) btnLoading.style.display = 'inline-flex';
            submitBtn.disabled = true;

            // Build URLSearchParams for fetch
            var params = new URLSearchParams();
            params.append('action', 'eden_submit_assessment');
            params.append('nonce', edenAjax.nonce);

            // Flatten formData into params
            for (var key in formData) {
                if (Array.isArray(formData[key])) {
                    formData[key].forEach(function (val) {
                        params.append('formData[' + key + '][]', val);
                    });
                } else {
                    params.append('formData[' + key + ']', formData[key]);
                }
            }

            fetch(edenAjax.ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: params.toString()
            })
                .then(function (response) { return response.json(); })
                .then(function (response) {
                    // Reset button
                    if (btnText) btnText.style.display = '';
                    if (btnLoading) btnLoading.style.display = 'none';
                    submitBtn.disabled = false;

                    if (response.success) {
                        clearSavedDraft();
                        // Hide form section
                        formSection.style.display = 'none';
                        // Also hide trust bar and hero to focus on results
                        var hero = document.querySelector('.eden-assess-hero');
                        var trust = document.querySelector('.eden-trust-bar');
                        if (hero) hero.style.display = 'none';
                        if (trust) trust.style.display = 'none';

                        displayResults(response.data);
                        resultsSection.style.display = '';
                        window.scrollTo({ top: resultsSection.offsetTop - 30, behavior: 'smooth' });
                    } else {
                        alert('Error: ' + (response.data && response.data.message ? response.data.message : 'An unexpected error occurred.'));
                    }
                })
                .catch(function (err) {
                    if (btnText) btnText.style.display = '';
                    if (btnLoading) btnLoading.style.display = 'none';
                    submitBtn.disabled = false;
                    alert('Network error. Please check your connection and try again.');
                });
        });

        // ─── Display Results & Score Animation ───
        function displayResults(data) {
            var percentage = data.percentage || 0;
            var riskLevel = data.risk_level || 'Unknown';

            setText('resultClientName', document.getElementById('client_name').value);
            setText('riskScoreValue', data.risk_score);
            setText('maxScoreValue', data.max_score);
            setText('assessmentIdValue', '#' + data.id);

            // Risk level badge
            var badge = document.getElementById('scoreLevelBadge');
            if (badge) {
                badge.className = 'score-level level-' + riskLevel.toLowerCase();
            }
            setText('scoreLevelText', riskLevel + ' Risk');

            // Score ring
            var ringFill = document.getElementById('scoreRingFill');
            if (ringFill) {
                var circumference = 2 * Math.PI * 52;
                var color = getRiskColor(riskLevel);
                ringFill.style.stroke = color;
                ringFill.style.strokeDasharray = circumference;
                ringFill.style.strokeDashoffset = circumference;

                setTimeout(function () {
                    var offset = circumference - (percentage / 100) * circumference;
                    ringFill.style.transition = 'stroke-dashoffset 1.5s ease-in-out';
                    ringFill.style.strokeDashoffset = offset;
                }, 200);
            }

            // Counter animation
            animateCounter('scorePercentage', 0, percentage, 1500);

            // Risk message
            var msgEl = document.getElementById('resultsMessage');
            if (msgEl) msgEl.innerHTML = getRiskMessage(riskLevel);
        }

        function setText(id, val) {
            var el = document.getElementById(id);
            if (el) el.textContent = val;
        }

        function getRiskColor(level) {
            var colors = { low: '#00c853', medium: '#ffc107', high: '#ff9800', critical: '#ff5252' };
            return colors[level.toLowerCase()] || '#90a4ae';
        }

        function getRiskMessage(level) {
            var msgs = {
                low: '<div class="risk-msg risk-low"><h3><i class="fa-solid fa-shield-check"></i> Your IT infrastructure is in good shape!</h3><p>You have strong security measures in place. Our team can help you optimize further and ensure continuous protection.</p></div>',
                medium: '<div class="risk-msg risk-medium"><h3><i class="fa-solid fa-triangle-exclamation"></i> Some areas need attention</h3><p>There are moderate gaps in your IT security posture. We recommend a consultation to address key vulnerabilities.</p></div>',
                high: '<div class="risk-msg risk-high"><h3><i class="fa-solid fa-exclamation-circle"></i> Significant risks detected</h3><p>Your infrastructure has notable security gaps. Immediate action is recommended to protect your business.</p></div>',
                critical: '<div class="risk-msg risk-critical"><h3><i class="fa-solid fa-skull-crossbones"></i> Critical vulnerabilities found!</h3><p>Your IT environment is highly exposed. Urgent remediation is required. Book an emergency consultation immediately.</p></div>'
            };
            return msgs[level.toLowerCase()] || '';
        }

        function animateCounter(id, start, end, duration) {
            var el = document.getElementById(id);
            if (!el) return;
            var range = end - start;
            var startTime = null;
            function step(timestamp) {
                if (!startTime) startTime = timestamp;
                var progress = Math.min((timestamp - startTime) / duration, 1);
                el.textContent = Math.floor(progress * range + start);
                if (progress < 1) requestAnimationFrame(step);
            }
            requestAnimationFrame(step);
        }

        // ─── Save & Continue (localStorage) ───
        function autoSave() {
            try {
                var formData = collectFormData();
                localStorage.setItem(STORAGE_KEY, JSON.stringify({
                    step: currentStep,
                    data: formData,
                    timestamp: new Date().toISOString()
                }));
            } catch (e) { }
        }

        var saveBtn = document.getElementById('saveProgressBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function () {
                autoSave();
                if (saveStatus) {
                    saveStatus.textContent = 'Progress saved!';
                    saveStatus.style.display = 'inline';
                    setTimeout(function () { saveStatus.style.display = 'none'; }, 2500);
                }
            });
        }

        function tryRestoreDraft() {
            try {
                var saved = localStorage.getItem(STORAGE_KEY);
                if (!saved) return;
                var obj = JSON.parse(saved);
                if (!obj || !obj.data) return;

                var savedDate = new Date(obj.timestamp);
                var diffDays = (new Date() - savedDate) / (1000 * 60 * 60 * 24);
                if (diffDays > 7) { clearSavedDraft(); return; }

                if (!confirm('We found a saved draft from ' + savedDate.toLocaleDateString() + '. Continue where you left off?')) {
                    clearSavedDraft(); return;
                }

                var data = obj.data;
                for (var key in data) {
                    var val = data[key];

                    // Arrays (checkboxes)
                    if (Array.isArray(val)) {
                        val.forEach(function (v) {
                            var cb = assessForm.querySelector('input[name="' + key + '[]"][value="' + v + '"]');
                            if (cb) cb.checked = true;
                        });
                        continue;
                    }
                    // Radios
                    var radio = assessForm.querySelector('input[type="radio"][name="' + key + '"][value="' + val + '"]');
                    if (radio) {
                        radio.checked = true;
                        radio.dispatchEvent(new Event('change'));
                        continue;
                    }
                    // Text / select / textarea
                    var field = assessForm.querySelector('[name="' + key + '"]');
                    if (field && field.type !== 'radio' && field.type !== 'checkbox') {
                        field.value = val;
                    }
                }

                if (obj.step && obj.step > 1 && obj.step <= TOTAL_STEPS) {
                    showStep(obj.step);
                }
            } catch (e) { }
        }

        function clearSavedDraft() {
            try { localStorage.removeItem(STORAGE_KEY); } catch (e) { }
        }

        // ─── Download Summary ───
        document.addEventListener('click', function (e) {
            if (e.target.closest('#downloadReportBtn')) {
                var clientName = (document.getElementById('resultClientName') || {}).textContent || 'Client';
                var riskLevel = (document.getElementById('scoreLevelText') || {}).textContent || 'N/A';
                var riskScore = (document.getElementById('riskScoreValue') || {}).textContent || '0';
                var maxScore = (document.getElementById('maxScoreValue') || {}).textContent || '0';
                var pct = (document.getElementById('scorePercentage') || {}).textContent || '0';
                var assessId = (document.getElementById('assessmentIdValue') || {}).textContent || '#—';

                var s = '';
                s += '═══════════════════════════════════════════════\n';
                s += '  IT INFRASTRUCTURE & SECURITY ASSESSMENT\n';
                s += '  Eden Infosol Pvt. Ltd.\n';
                s += '═══════════════════════════════════════════════\n\n';
                s += '  Client:         ' + clientName + '\n';
                s += '  Assessment ID:  ' + assessId + '\n';
                s += '  Date:           ' + new Date().toLocaleDateString() + '\n\n';
                s += '───────────────────────────────────────────────\n';
                s += '  RISK SUMMARY\n';
                s += '───────────────────────────────────────────────\n\n';
                s += '  Risk Level:     ' + riskLevel + '\n';
                s += '  Risk Score:     ' + riskScore + ' / ' + maxScore + '\n';
                s += '  Risk %:         ' + pct + '%\n\n';
                s += '───────────────────────────────────────────────\n';
                s += '  NEXT STEPS\n';
                s += '───────────────────────────────────────────────\n\n';
                s += '  1. Our team will review your detailed assessment.\n';
                s += '  2. A comprehensive report will be sent to your email\n';
                s += '     within 24 hours.\n';
                s += '  3. Book a free consultation to discuss findings\n';
                s += '     and recommendations.\n\n';
                s += '───────────────────────────────────────────────\n';
                s += '  CONTACT\n';
                s += '───────────────────────────────────────────────\n\n';
                s += '  Email: management@edeninfosol.com\n';
                s += '  Web:   https://edeninfosol.com\n\n';
                s += '═══════════════════════════════════════════════\n';
                s += '  © ' + new Date().getFullYear() + ' Eden Infosol. All rights reserved.\n';
                s += '═══════════════════════════════════════════════\n';

                var blob = new Blob([s], { type: 'text/plain' });
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'IT_Assessment_' + clientName.replace(/\s+/g, '_') + '.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        });

        // ─── Keyboard: Enter → Next Step ───
        document.addEventListener('keydown', function (e) {
            if (!assessForm.contains(e.target)) return;
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && e.target.type !== 'submit') {
                e.preventDefault();
                if (currentStep < TOTAL_STEPS) {
                    var nextBtn = document.querySelector('.form-step.active .btn-next');
                    if (nextBtn) nextBtn.click();
                }
            }
        });

        // ─── Init ───
        showStep(1);
        tryRestoreDraft();

    } // end if (assessForm)

});
