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


            var posterImg = heroWrap.querySelector('.hero-poster');
            var themeUrl = posterImg ? posterImg.src : '';
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
                var posterEl = heroWrap.querySelector('.hero-poster-picture') || heroWrap.querySelector('.hero-poster');
                if (posterEl) posterEl.classList.add('hidden');
            }).catch(function () {
                // Autoplay blocked — poster stays visible
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
    // ASSESSMENT FORM — COMPLETE REWRITE
    // =============================================
    var assessForm = document.getElementById('edenAssessmentForm');
    if (assessForm) {

        var TOTAL_STEPS = 4;
        var currentStep = 1;
        var STORAGE_KEY = 'eden_assessment_draft';
        var formSection = document.getElementById('assessment-form-section');
        var resultsSection = document.getElementById('resultsSection');
        var progressFill = document.getElementById('progressFill');
        var saveStatus = document.getElementById('saveStatus');
        var locTemplate = document.getElementById('eden-loc-template');
        var locTabsBar = document.getElementById('locationTabs');
        var locContents = document.getElementById('locationContents');
        var currentLocCount = 0;

        // ═══════════════════════════════════════════
        // MINIMIZE / EXPAND SECTIONS (Step 2 + Step 3)
        // ═══════════════════════════════════════════

        function injectMinimizeButtons() {
            // ─── Step 2: toggle-sections that are open ───
            document.querySelectorAll('.toggle-section.open').forEach(function (sec) {
                if (sec.querySelector('.section-minimize-btn')) return; // already has one
                addMinimizeButton(sec, 'toggle');
            });

            // ─── Step 3: section-cards in Step 3 ───
            document.querySelectorAll('.form-step[data-step="3"] .section-card').forEach(function (card) {
                if (card.querySelector('.section-minimize-btn')) return;
                addMinimizeButton(card, 'card');
            });
        }

        function addMinimizeButton(container, type) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'section-minimize-btn';
            btn.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
            btn.setAttribute('aria-label', 'Minimize section');
            btn.setAttribute('title', 'Minimize');

            if (type === 'card') {
                // Inject into the section-card-header (right-aligned)
                var header = container.querySelector('.section-card-header');
                if (header) header.appendChild(btn);
            } else {
                // For toggle-section, append directly (CSS will position it)
                container.appendChild(btn);
            }
        }

        // Toggle collapsed state on click
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.section-minimize-btn');
            if (!btn) return;
            e.preventDefault();
            e.stopPropagation();

            var container = btn.closest('.toggle-section.open, .section-card');
            if (!container) return;

            container.classList.toggle('collapsed');
            var icon = btn.querySelector('i');
            if (container.classList.contains('collapsed')) {
                icon.className = 'fa-solid fa-chevron-down';
                btn.setAttribute('title', 'Expand');
            } else {
                icon.className = 'fa-solid fa-chevron-up';
                btn.setAttribute('title', 'Minimize');
            }
        });

        // Inject buttons on page load + whenever sections open
        setTimeout(injectMinimizeButtons, 300);

        // Also inject when a section toggle opens a new section
        document.addEventListener('change', function (e) {
            if (e.target.classList && e.target.classList.contains('section-toggle')) {
                setTimeout(injectMinimizeButtons, 50);
            }
        });

        // Inject when location tabs are built/switched
        var originalBuildLocationTabs = buildLocationTabs;
        buildLocationTabs = function (count) {
            originalBuildLocationTabs(count);
            setTimeout(injectMinimizeButtons, 100);
        };

        // Re-inject when step changes (so Step 3 cards get buttons on first visit)
        var originalShowStepForMinimize = showStep;
        showStep = function (step) {
            originalShowStepForMinimize(step);
            setTimeout(injectMinimizeButtons, 100);
        };
        // ═══════════════════════════════════════════
        // APPLY ROW 1 TO ALL DYNAMIC ROWS (FIXED REGEX)
        // ═══════════════════════════════════════════
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.btn-apply-to-all');
            if (!btn) return;

            var containerId = btn.getAttribute('data-container');
            var container = document.getElementById(containerId);
            if (!container) return;

            var rows = container.querySelectorAll('.dynamic-row');
            if (rows.length < 2) return;

            var firstRow = rows[0];
            var firstFields = {};

            // ─── Extract suffix using GREEDY match (matches LAST _N_suffix in the name) ───
            firstRow.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (!f.name) return;
                // .* is greedy, so this matches the LAST _<digits>_<suffix> in the name
                var match = f.name.match(/^.*_(\d+)_(.+)$/);
                if (match) {
                    firstFields[match[2]] = f.value;
                }
            });

            // Sanity check
            if (Object.keys(firstFields).length === 0) {
                showSaveToast('Could not find any fields to copy from Row 1', 'error');
                return;
            }

            // Apply suffix-matched values to rows 2+
            var appliedCount = 0;
            for (var i = 1; i < rows.length; i++) {
                rows[i].querySelectorAll('input, select, textarea').forEach(function (f) {
                    if (!f.name) return;
                    var match = f.name.match(/^.*_(\d+)_(.+)$/);
                    if (match && firstFields[match[2]] !== undefined) {
                        f.value = firstFields[match[2]];
                        appliedCount++;
                    }
                });
            }

            showSaveToast('Applied Row 1 values to ' + (rows.length - 1) + ' other rows', 'success');
            autoSave();
        });
        // ═══════════════════════════════════════════
        // 1. LOCATION TAB GENERATOR
        // ═══════════════════════════════════════════
        function buildLocationTabs(count) {
            count = Math.max(1, Math.min(20, parseInt(count) || 1));
            if (count === currentLocCount) return;

            for (var i = currentLocCount; i < count; i++) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'loc-tab' + (i === 0 ? ' active' : '');
                btn.setAttribute('data-loc', i);
                btn.textContent = 'Location ' + (i + 1);
                locTabsBar.appendChild(btn);

                var html = locTemplate.innerHTML
                    .replace(/\{\{IDX\}\}/g, i)
                    .replace(/\{\{NUM\}\}/g, (i + 1));
                var wrap = document.createElement('div');
                wrap.innerHTML = html;
                var panel = wrap.firstElementChild;
                panel.style.display = (i === 0) ? '' : 'none';
                locContents.appendChild(panel);

                bindPanelHandlers(panel);
            }

            var allTabs = locTabsBar.querySelectorAll('.loc-tab');
            var allPanels = locContents.querySelectorAll('.location-panel');
            for (var j = 0; j < allTabs.length; j++) {
                if (j < count) {
                    allTabs[j].style.display = '';
                } else {
                    allTabs[j].style.display = 'none';
                    allPanels[j].style.display = 'none';
                }
            }

            var activeIdx = parseInt((locTabsBar.querySelector('.loc-tab.active') || {}).getAttribute('data-loc') || '0');
            if (activeIdx >= count) {
                switchLocTab(0);
            }

            currentLocCount = Math.max(currentLocCount, count);
        }

        function switchLocTab(idx) {
            locTabsBar.querySelectorAll('.loc-tab').forEach(function (t) { t.classList.remove('active'); });
            locContents.querySelectorAll('.location-panel').forEach(function (p) { p.style.display = 'none'; });
            var tab = locTabsBar.querySelector('.loc-tab[data-loc="' + idx + '"]');
            var panel = locContents.querySelector('.location-panel[data-loc="' + idx + '"]');
            if (tab) tab.classList.add('active');
            if (panel) panel.style.display = '';
        }
        // ═══════════════════════════════════════════
        // LOCATION COPY — clone data from one location to another
        // ═══════════════════════════════════════════
        function updateCopyFromDropdown() {
            var dropdown = document.getElementById('copyFromLocSelect');
            var toolbar = document.getElementById('locationCopyToolbar');
            if (!dropdown || !toolbar) return;

            var locCount = parseInt(numLocInput.value) || 1;
            var activeTab = locTabsBar.querySelector('.loc-tab.active');
            var activeIdx = activeTab ? parseInt(activeTab.getAttribute('data-loc')) : 0;

            // Find locations that have at least some data
            var availableLocs = [];
            for (var i = 0; i < locCount; i++) {
                if (i === activeIdx) continue;
                var panel = locContents.querySelector('.location-panel[data-loc="' + i + '"]');
                if (!panel) continue;
                var hasData = false;
                panel.querySelectorAll('input, select, textarea').forEach(function (f) {
                    if (f.type === 'checkbox' || f.type === 'radio') {
                        if (f.checked) hasData = true;
                    } else if (f.value && f.value.trim() !== '') {
                        hasData = true;
                    }
                });
                if (hasData) {
                    var nameInput = panel.querySelector('[name="loc_' + i + '_name"]');
                    var locName = (nameInput && nameInput.value.trim()) ? nameInput.value.trim() : 'Location ' + (i + 1);
                    availableLocs.push({ idx: i, name: locName });
                }
            }

            // Show/hide toolbar based on whether other filled locations exist
            if (availableLocs.length === 0 || locCount < 2) {
                toolbar.style.display = 'none';
                return;
            }
            toolbar.style.display = '';

            // Rebuild dropdown
            dropdown.innerHTML = '<option value="">— Select a location —</option>';
            availableLocs.forEach(function (loc) {
                var opt = document.createElement('option');
                opt.value = loc.idx;
                opt.textContent = loc.name;
                dropdown.appendChild(opt);
            });
        }

        function copyLocationData(sourceIdx, targetIdx) {
            var sourcePanel = locContents.querySelector('.location-panel[data-loc="' + sourceIdx + '"]');
            var targetPanel = locContents.querySelector('.location-panel[data-loc="' + targetIdx + '"]');
            if (!sourcePanel || !targetPanel) return;


            // ─── Step 0: Copy SECTION TOGGLES first (they have no name, matched by data-target) ───
            sourcePanel.querySelectorAll('.section-toggle').forEach(function (srcToggle) {
                var srcTarget = srcToggle.getAttribute('data-target');
                if (!srcTarget) return;
                // Swap the location index in data-target
                var targetTarget = srcTarget.replace('loc_' + sourceIdx + '_', 'loc_' + targetIdx + '_');
                var tgtToggle = targetPanel.querySelector('.section-toggle[data-target="' + targetTarget + '"]');
                if (!tgtToggle) return;

                tgtToggle.checked = srcToggle.checked;
                var tgtSection = document.getElementById(targetTarget);
                if (tgtSection) {
                    if (srcToggle.checked) {
                        tgtSection.classList.add('open');
                    } else {
                        tgtSection.classList.remove('open');
                    }
                }
            });
            // Step 1: Copy basic fields (text/number/select/textarea)
            sourcePanel.querySelectorAll('input, select, textarea').forEach(function (sf) {
                if (!sf.name) return;
                // Skip location-name (we don't want to copy "Mumbai HQ" to a new location)
                if (sf.name.indexOf('_name') > -1 && sf.name === 'loc_' + sourceIdx + '_name') return;

                // Build target field name by swapping the location index
                var targetName = sf.name.replace('loc_' + sourceIdx + '_', 'loc_' + targetIdx + '_').replace(/_(\d+)$/, function (m, n) {
                    return n === String(sourceIdx) ? '_' + targetIdx : m;
                });
                // For fields with {{IDX}} suffix like has_san_0 → has_san_1
                if (targetName === sf.name) {
                    var idxMatch = sf.name.match(/_(\d+)(?:\b|$)/);
                    if (idxMatch && parseInt(idxMatch[1]) === sourceIdx) {
                        targetName = sf.name.replace(/_(\d+)(\b|$)/, '_' + targetIdx + '$2');
                    }
                }

                var tf = targetPanel.querySelector('[name="' + targetName + '"]');
                if (!tf) return;

                if (sf.type === 'checkbox') {
                    tf.checked = sf.checked;
                    if (sf.checked) {
                        if (tf.classList.contains('section-toggle')) {
                            var sec = document.getElementById(tf.getAttribute('data-target'));
                            if (sec) sec.classList.add('open');
                        } else {
                            tf.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                    }
                } else if (sf.type === 'radio') {
                    if (sf.checked) {
                        // Find matching radio in target group with same value
                        var targetRadios = targetPanel.querySelectorAll('input[type="radio"][name="' + targetName + '"]');
                        targetRadios.forEach(function (tr) {
                            if (tr.value === sf.value) {
                                tr.checked = true;
                                tr.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        });
                    }
                } else {
                    tf.value = sf.value;
                    // Trigger qty inputs to regenerate dynamic rows
                    if (tf.classList.contains('eden-qty-trigger') && tf.value && parseInt(tf.value) > 0) {
                        tf.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            });

            // Step 2: After dynamic rows are regenerated, copy their values too (timed pass)
            setTimeout(function () { copyDynamicRowValues(sourcePanel, targetPanel, sourceIdx, targetIdx); }, 100);
            setTimeout(function () { copyDynamicRowValues(sourcePanel, targetPanel, sourceIdx, targetIdx); }, 350);

            // Step 3: Show success toast
            showSaveToast('Data copied successfully — edit what\'s different', 'success');

            // Step 4: Auto-save
            setTimeout(autoSave, 600);
        }

        function copyDynamicRowValues(sourcePanel, targetPanel, sourceIdx, targetIdx) {
            // Iterate over all source dynamic-rows containers
            sourcePanel.querySelectorAll('.dynamic-rows').forEach(function (srcContainer) {
                var srcId = srcContainer.id;
                if (!srcId) return;
                var targetId = srcId.replace('loc_' + sourceIdx + '_', 'loc_' + targetIdx + '_').replace(/_(\d+)/, function (m, n) {
                    return n === String(sourceIdx) ? '_' + targetIdx : m;
                });
                var targetContainer = document.getElementById(targetId);
                if (!targetContainer) return;

                // Copy each input/select inside source rows to target rows by name swap
                srcContainer.querySelectorAll('input, select, textarea').forEach(function (sf) {
                    if (!sf.name) return;
                    var targetName = sf.name.replace('loc_' + sourceIdx + '_', 'loc_' + targetIdx + '_').replace(/_(\d+)_/, function (m, n) {
                        return n === String(sourceIdx) ? '_' + targetIdx + '_' : m;
                    });
                    // Handle SAN/extinguisher style: san_drive_0_1 → san_drive_1_1
                    if (targetName === sf.name) {
                        var m = sf.name.match(/_(\d+)_(\d+)$/);
                        if (m && parseInt(m[1]) === sourceIdx) {
                            targetName = sf.name.replace(/_(\d+)_(\d+)$/, '_' + targetIdx + '_$2');
                        }
                    }
                    var tf = targetContainer.querySelector('[name="' + targetName + '"]');
                    if (tf && tf.type !== 'radio' && tf.type !== 'checkbox') {
                        tf.value = sf.value;
                    }
                });
            });
        }

        // Bind the copy button
        document.addEventListener('click', function (e) {
            if (e.target.closest('#copyFromLocBtn')) {
                var dropdown = document.getElementById('copyFromLocSelect');
                var sourceIdx = parseInt(dropdown.value);
                if (isNaN(sourceIdx)) {
                    showSaveToast('Please select a location to copy from', 'error');
                    return;
                }
                var activeTab = locTabsBar.querySelector('.loc-tab.active');
                var targetIdx = activeTab ? parseInt(activeTab.getAttribute('data-loc')) : 0;

                if (sourceIdx === targetIdx) {
                    showSaveToast('Cannot copy a location into itself', 'error');
                    return;
                }

                // Confirm modal
                showEdenModal({
                    title: 'Copy location data?',
                    subtitle: 'This will overwrite the current location with data from the selected one.',
                    bodyText: 'You\'ll be able to edit only the fields that are different. Continue?',
                    cancelText: 'Cancel',
                    confirmText: 'Yes, Copy Data',
                    icon: 'fa-clone'
                }).then(function (proceed) {
                    if (proceed) copyLocationData(sourceIdx, targetIdx);
                });
            }
        });

        // Update dropdown when tab changes
        var originalSwitchLocTab = switchLocTab;
        switchLocTab = function (idx) {
            originalSwitchLocTab(idx);
            updateCopyFromDropdown();
        };

        // Initial dropdown update
        setTimeout(updateCopyFromDropdown, 500);

        locTabsBar.addEventListener('click', function (e) {
            var tab = e.target.closest('.loc-tab');
            if (tab) switchLocTab(parseInt(tab.getAttribute('data-loc')));
        });

        var numLocInput = document.getElementById('num_locations');
        if (numLocInput) {
            numLocInput.addEventListener('input', function () {
                var val = parseInt(this.value) || 0;
                if (val > 0 && val <= 20) buildLocationTabs(val);
            });
        }


        // ═══════════════════════════════════════════
        // 2. BIND HANDLERS FOR DYNAMIC PANELS
        // ═══════════════════════════════════════════
        function bindPanelHandlers(panel) {
            panel.querySelectorAll('.section-toggle').forEach(function (cb) {
                cb.addEventListener('change', function () {
                    var sec = document.getElementById(this.getAttribute('data-target'));
                    if (!sec) return;
                    if (this.checked) {
                        sec.classList.add('open');
                    } else {
                        sec.classList.remove('open');
                        clearFieldsInside(sec);
                    }
                });
            });

            panel.querySelectorAll('.eden-yn-trigger').forEach(function (el) {
                el.addEventListener('change', function () { handleYNTrigger(this); });
            });

            panel.querySelectorAll('.eden-qty-trigger').forEach(function (el) {
                el.addEventListener('input', function () { generateDynamicRows(this); });
            });
        }

        // ═══════════════════════════════════════════
        // PROGRESS BAR — CLICK TO NAVIGATE
        // ═══════════════════════════════════════════
        document.querySelectorAll('.progress-step').forEach(function (stepEl) {
            stepEl.style.cursor = 'pointer';
            stepEl.addEventListener('click', function () {
                var targetStep = parseInt(this.getAttribute('data-step'));
                if (!targetStep || targetStep === currentStep) return;

                // ─── Going BACKWARD: always allowed (no validation needed) ───
                if (targetStep < currentStep) {
                    showStep(targetStep);
                    return;
                }

                // ─── Going FORWARD: validate each step in between ───
                // Run hard validation on current step first
                if (!validateStep(currentStep)) return;

                // Check soft warnings for current step
                var warnings = collectStepWarnings(currentStep);
                if (warnings.length > 0) {
                    showEdenModal({
                        title: 'Some information is missing',
                        subtitle: 'You can go back and complete it, or skip ahead.',
                        warnings: warnings,
                        cancelText: 'Go Back & Complete',
                        confirmText: 'Skip Anyway',
                        icon: 'fa-triangle-exclamation'
                    }).then(function (proceed) {
                        if (proceed) {
                            showStep(targetStep);
                            autoSave();
                        }
                    });
                } else {
                    showStep(targetStep);
                    autoSave();
                }
            });
        });

        // ═══════════════════════════════════════════
        // 3. DYNAMIC QUANTITY ROW GENERATOR
        // ═══════════════════════════════════════════
        function generateDynamicRows(input) {
            var count = Math.min(50, Math.max(0, parseInt(input.value) || 0));
            var containerId = input.getAttribute('data-container');
            var tpl = input.getAttribute('data-tpl');
            var prefix = input.getAttribute('data-prefix');
            var customLabel = input.getAttribute('data-label'); // NEW: optional custom label
            var container = document.getElementById(containerId);
            if (!container) return;

            var saved = {};
            container.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (f.name) saved[f.name] = f.value;
                // Append "Apply Row 1 to all" button AFTER all rows are rendered
                if (count >= 2) {
                    var applyBtn = document.createElement('button');
                    applyBtn.type = 'button';
                    applyBtn.className = 'btn-apply-to-all';
                    applyBtn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Apply Row 1 values to all ' + count + ' rows';
                    applyBtn.setAttribute('data-container', containerId);
                    container.appendChild(applyBtn);
                }
            });


            container.innerHTML = '';
            if (count === 0) return;
            // Add "Apply to all" button when count >= 2
            if (count >= 2) {
                var applyBtn = document.createElement('button');
                applyBtn.type = 'button';
                applyBtn.className = 'btn-apply-to-all';
                applyBtn.innerHTML = '<i class="fa-solid fa-wand-magic-sparkles"></i> Apply Row 1 values to all ' + count + ' rows';
                applyBtn.setAttribute('data-container', containerId);
                container.appendChild(applyBtn);
            }

            for (var i = 1; i <= count; i++) {
                var row = document.createElement('div');
                row.className = 'dynamic-row';
                var p = prefix + '_' + i;
                var label = getRowLabel(tpl, i, customLabel);

                if (tpl === 'internet') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-3">' +
                        '<div class="form-group"><label>ISP Name</label><input type="text" name="' + p + '_isp" placeholder="e.g. Airtel"></div>' +
                        '<div class="form-group"><label>Bandwidth</label><input type="text" name="' + p + '_bw" placeholder="e.g. 100 Mbps"></div>' +
                        '<div class="form-group"><label>Type</label><select name="' + p + '_type"><option value="">Select</option><option value="Broadband">Broadband</option><option value="ILL">ILL</option><option value="MPLS">MPLS</option></select></div>' +
                        '</div>';
                } else if (tpl === 'p2p') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-3">' +
                        '<div class="form-group"><label>Point A</label><input type="text" name="' + p + '_point_a" placeholder="e.g. Mumbai"></div>' +
                        '<div class="form-group"><label>Point B</label><input type="text" name="' + p + '_point_b" placeholder="e.g. Delhi"></div>' +
                        '<div class="form-group"><label>Bandwidth</label><input type="text" name="' + p + '_bw" placeholder="e.g. 10 Mbps"></div>' +
                        '</div>';
                } else if (tpl === 'leased') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-3">' +
                        '<div class="form-group"><label>Bandwidth</label><input type="text" name="' + p + '_bw" placeholder="e.g. 10 Mbps"></div>' +
                        '<div class="form-group"><label>Details</label><input type="text" name="' + p + '_details" placeholder="Point A to B"></div>' +
                        '<div class="form-group"><label>SP Router</label><select name="' + p + '_sp_router"><option value="">Select</option><option value="yes">Yes</option><option value="no">No</option></select></div>' +
                        '</div>';
                } else if (tpl === 'rack') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-3">' +
                        '<div class="form-group"><label>Dimensions</label><input type="text" name="' + p + '_dim" placeholder="600x500 / 600x1000 / 800x1000"></div>' +
                        '<div class="form-group"><label>Patch Panels (24-port)</label><input type="number" name="' + p + '_pp24" min="0" placeholder="0"></div>' +
                        '<div class="form-group"><label>Patch Panels (48-port)</label><input type="number" name="' + p + '_pp48" min="0" placeholder="0"></div>' +
                        '</div>';
                } else if (tpl === 'sandrive') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-2">' +
                        '<div class="form-group"><label>Drive Type</label><select name="' + p + '_type"><option value="">Select</option><option value="SSD">SSD</option><option value="SAS">SAS</option><option value="SATA">SATA</option><option value="NVMe">NVMe</option><option value="HDD">HDD</option></select></div>' +
                        '<div class="form-group"><label>Capacity per Drive</label><input type="text" name="' + p + '_capacity" placeholder="e.g. 2 TB"></div>' +
                        '</div>';
                } else if (tpl === 'extinguisher') {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-3">' +
                        '<div class="form-group"><label>Type</label><select name="' + p + '_type"><option value="">Select</option><option value="ABC Dry Powder">ABC Dry Powder</option><option value="CO2">CO2</option><option value="Foam">Foam</option><option value="Water">Water</option><option value="Wet Chemical">Wet Chemical</option></select></div>' +
                        '<div class="form-group"><label>Make</label><input type="text" name="' + p + '_make" placeholder="e.g. Ceasefire"></div>' +
                        '<div class="form-group"><label>Model</label><input type="text" name="' + p + '_model" placeholder="e.g. ABC-6KG"></div>' +
                        '</div>';
                } else {
                    row.innerHTML = '<div class="dynamic-row-label">' + label + '</div>' +
                        '<div class="form-grid cols-2">' +
                        '<div class="form-group"><label>Make</label><input type="text" name="' + p + '_make" placeholder="Make"></div>' +
                        '<div class="form-group"><label>Model</label><input type="text" name="' + p + '_model" placeholder="Model"></div>' +
                        '</div>';
                }

                container.appendChild(row);
            }

            container.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (f.name && saved[f.name] !== undefined) f.value = saved[f.name];
            });
        }

        function getRowLabel(tpl, i, customLabel) {
            if (customLabel && customLabel.trim() !== '') {
                return customLabel.trim() + ' ' + i;
            }
            var labels = {
                internet: 'Connection ', p2p: 'P2P Line ',
                leased: 'Leased Line ', rack: 'Rack ',
                makemodel: 'Unit ',
                sandrive: 'Drive ',
                extinguisher: 'Extinguisher '
            };
            return (labels[tpl] || 'Item ') + i;
        }
        // ═══════════════════════════════════════════
        // 4. Y/N CONDITIONAL TRIGGER
        // ═══════════════════════════════════════════
        function handleYNTrigger(el) {
            var targetId = el.getAttribute('data-target');
            var target = document.getElementById(targetId);
            if (!target) return;

            var show = false;

            if (el.type === 'checkbox') {
                show = el.checked;
            } else if (el.type === 'radio') {
                // Find which radio in the same name group is currently checked
                var checkedRadio = document.querySelector('input[type="radio"][name="' + el.name + '"]:checked');
                if (!checkedRadio) {
                    show = false;
                } else {
                    // Only consider checked radios that point to THIS target
                    if (checkedRadio.getAttribute('data-target') === targetId) {
                        // Use data-show-value if specified, otherwise default to "yes"
                        var requiredValue = checkedRadio.getAttribute('data-show-value') || 'yes';
                        show = (checkedRadio.value === requiredValue);
                    } else {
                        show = false;
                    }
                }
            }

            target.style.display = show ? '' : 'none';
            if (!show) clearFieldsInside(target);
        }

        function clearFieldsInside(container) {
            container.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], input[type="tel"], input[type="url"], textarea').forEach(function (f) { f.value = ''; });
            container.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(function (f) { f.checked = false; });
            container.querySelectorAll('select').forEach(function (f) { f.selectedIndex = 0; });
            container.querySelectorAll('.dynamic-rows').forEach(function (f) { f.innerHTML = ''; });
        }

        // Global Y/N triggers (Step 1 and Step 3)
        document.querySelectorAll('.eden-yn-trigger').forEach(function (el) {
            el.addEventListener('change', function () { handleYNTrigger(this); });
        });

        // Global section toggles (Step 3)
        document.querySelectorAll('.section-toggle').forEach(function (cb) {
            cb.addEventListener('change', function () {
                var sec = document.getElementById(this.getAttribute('data-target'));
                if (!sec) return;
                if (this.checked) { sec.classList.add('open'); }
                else { sec.classList.remove('open'); clearFieldsInside(sec); }
            });
        });

        // ═══════════════════════════════════════════
        // 5. MULTI-STEP WIZARD
        // ═══════════════════════════════════════════
        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(function (el) {
                el.classList.remove('active');
            });
            var target = document.querySelector('.form-step[data-step="' + step + '"]');
            if (target) target.classList.add('active');
            updateProgressBar(step);
            if (formSection) {
                window.scrollTo({ top: formSection.offsetTop - 30, behavior: 'smooth' });
            }
            currentStep = step;

            if (step === 2) {
                var val = parseInt(numLocInput.value) || 1;
                buildLocationTabs(val);
            }
            if (step === 4) {
                generateReview();
            }
        }

        function updateProgressBar(step) {
            // Each step circle is centered within its (100/TOTAL_STEPS)% segment.
            // Step N's circle center is at: ((2N - 1) / (2 * TOTAL_STEPS)) * 100%
            // Example for 4 steps: Step 1 → 12.5%, Step 2 → 37.5%, Step 3 → 62.5%, Step 4 → 87.5%
            var percent = ((2 * step - 1) / (2 * TOTAL_STEPS)) * 100;
            if (progressFill) progressFill.style.width = percent + '%';

            document.querySelectorAll('.progress-step').forEach(function (el) {
                var s = parseInt(el.getAttribute('data-step'));
                el.classList.remove('active', 'completed');
                if (s < step) el.classList.add('completed');
                if (s === step) el.classList.add('active');
            });
        }

        // ═══════════════════════════════════════════
        // 6A. CUSTOM CONFIRM MODAL (replaces native confirm/alert)
        // ═══════════════════════════════════════════
        function showEdenModal(opts) {
            return new Promise(function (resolve) {
                // Remove any existing modal
                var existing = document.getElementById('edenConfirmModal');
                if (existing) existing.remove();

                var overlay = document.createElement('div');
                overlay.id = 'edenConfirmModal';
                overlay.className = 'eden-modal-overlay';

                var iconClass = opts.icon || 'fa-triangle-exclamation';
                var variantClass = opts.variant === 'info' ? 'info' : '';

                var bodyHtml = '';
                if (opts.warnings && opts.warnings.length > 0) {
                    bodyHtml = '<ul class="eden-modal-warning-list">';
                    opts.warnings.forEach(function (w) {
                        if (typeof w === 'string') {
                            bodyHtml += '<li><span>' + w + '</span></li>';
                        } else if (w && w.title) {
                            bodyHtml += '<li><div><strong>' + w.title + '</strong>';
                            if (w.items && w.items.length) {
                                bodyHtml += '<ul class="sub-list">';
                                w.items.forEach(function (it) {
                                    bodyHtml += '<li>' + it + '</li>';
                                });
                                bodyHtml += '</ul>';
                            }
                            bodyHtml += '</div></li>';
                        }
                    });
                    bodyHtml += '</ul>';
                } else if (opts.bodyText) {
                    bodyHtml = '<p style="color:var(--text-muted);font-size:0.92rem;line-height:1.6;margin:0;">' + opts.bodyText + '</p>';
                }

                overlay.innerHTML =
                    '<div class="eden-modal ' + variantClass + '" role="dialog" aria-modal="true">' +
                    '<div class="eden-modal-header">' +
                    '<div class="eden-modal-icon"><i class="fa-solid ' + iconClass + '"></i></div>' +
                    '<div class="eden-modal-title">' +
                    '<h3>' + (opts.title || 'Please Confirm') + '</h3>' +
                    (opts.subtitle ? '<p>' + opts.subtitle + '</p>' : '') +
                    '</div>' +
                    '</div>' +
                    '<div class="eden-modal-body">' + bodyHtml + '</div>' +
                    '<div class="eden-modal-footer">' +
                    '<button type="button" class="eden-modal-btn eden-modal-btn-cancel"><i class="fa-solid fa-pen-to-square"></i> ' + (opts.cancelText || 'Go Back & Edit') + '</button>' +
                    '<button type="button" class="eden-modal-btn eden-modal-btn-confirm">' + (opts.confirmText || 'Proceed Anyway') + ' <i class="fa-solid fa-arrow-right"></i></button>' +
                    '</div>' +
                    '</div>';

                document.body.appendChild(overlay);
                requestAnimationFrame(function () { overlay.classList.add('active'); });

                function close(result) {
                    overlay.classList.remove('active');
                    setTimeout(function () { if (overlay.parentNode) overlay.remove(); }, 250);
                    resolve(result);
                }

                overlay.querySelector('.eden-modal-btn-cancel').addEventListener('click', function () { close(false); });
                overlay.querySelector('.eden-modal-btn-confirm').addEventListener('click', function () { close(true); });
                overlay.addEventListener('click', function (e) { if (e.target === overlay) close(false); });
                document.addEventListener('keydown', function escHandler(e) {
                    if (e.key === 'Escape') { close(false); document.removeEventListener('keydown', escHandler); }
                });
            });
        }

        // ═══════════════════════════════════════════
        // 6B. HARD VALIDATION (required fields only)
        // ═══════════════════════════════════════════
        function validateStep(step) {
            var isValid = true;
            var stepEl = document.querySelector('.form-step[data-step="' + step + '"]');
            if (!stepEl) return true;
            stepEl.querySelectorAll('.field-error').forEach(function (el) { el.textContent = ''; });
            stepEl.querySelectorAll('.form-group').forEach(function (el) { el.classList.remove('has-error'); });

            if (step === 1) {
                var name = (document.getElementById('client_name').value || '').trim();
                if (!name) { setFieldError('client_name', 'Organization name is required.'); isValid = false; }
                var email = (document.getElementById('contact_email').value || '').trim();
                if (!email) { setFieldError('contact_email', 'Email is required.'); isValid = false; }
                else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { setFieldError('contact_email', 'Enter a valid email.'); isValid = false; }
                var phone = (document.getElementById('contact_phone').value || '').trim();
                if (!phone) { setFieldError('contact_phone', 'Phone is required.'); isValid = false; }
                var locs = (document.getElementById('num_locations').value || '').trim();
                if (!locs || parseInt(locs) < 1) { setFieldError('num_locations', 'At least 1 location required.'); isValid = false; }
            }

            if (step === 4) {
                var consent = document.getElementById('consent_checkbox');
                if (consent && !consent.checked) {
                    var ce = document.getElementById('consent-error');
                    if (ce) ce.textContent = 'You must agree to the privacy policy.';
                    isValid = false;
                }
            }

            if (!isValid) {
                var firstErr = stepEl.querySelector('.has-error');
                if (firstErr) window.scrollTo({ top: firstErr.offsetTop - 100, behavior: 'smooth' });
            }
            return isValid;
        }

        function setFieldError(id, message) {
            var input = document.getElementById(id);
            if (!input) return;
            var group = input.closest('.form-group');
            if (group) {
                group.classList.add('has-error');
                var err = group.querySelector('.field-error');
                if (err) err.textContent = message;
            }
        }

        // ═══════════════════════════════════════════
        // 6C. SOFT VALIDATION (warnings → custom modal)
        // ═══════════════════════════════════════════
        function collectStepWarnings(step) {
            var warnings = [];

            // ─── STEP 2: Locations + open sections ───
            if (step === 2) {
                var locCount = parseInt((numLocInput && numLocInput.value) || '1') || 1;
                var emptyLocs = [];
                var partialLocs = [];

                for (var i = 0; i < locCount; i++) {
                    var panel = locContents.querySelector('.location-panel[data-loc="' + i + '"]');
                    if (!panel) continue;

                    // Check ALL inputs outside toggle-sections (basic location fields)
                    var hasBasicData = false;
                    panel.querySelectorAll('input, select, textarea').forEach(function (f) {
                        if (f.closest('.toggle-section')) return; // skip toggle contents here
                        if (f.type === 'checkbox' || f.type === 'radio') {
                            if (f.checked && !f.classList.contains('section-toggle')) hasBasicData = true;
                        } else if (f.value && f.value.trim() !== '') {
                            hasBasicData = true;
                        }
                    });

                    // Check open toggle sections
                    var openEmptySections = [];
                    panel.querySelectorAll('.section-toggle:checked').forEach(function (toggle) {
                        var targetId = toggle.getAttribute('data-target');
                        var section = document.getElementById(targetId);
                        if (!section) return;
                        var hasData = false;
                        section.querySelectorAll('input, select, textarea').forEach(function (f) {
                            if (f.type === 'checkbox' || f.type === 'radio') {
                                if (f.checked) hasData = true;
                            } else if (f.value && f.value.trim() !== '') {
                                hasData = true;
                            }
                        });
                        if (!hasData) {
                            var labelEl = toggle.parentElement;
                            var label = labelEl ? labelEl.textContent.trim() : 'Section';
                            openEmptySections.push(label);
                        }
                        if (hasData) hasBasicData = true; // location has at least some data
                    });

                    var locLabel = 'Location ' + (i + 1);
                    if (!hasBasicData) {
                        emptyLocs.push(locLabel);
                    } else if (openEmptySections.length > 0) {
                        partialLocs.push({ title: locLabel + ' has empty toggled sections:', items: openEmptySections });
                    }
                }

                if (emptyLocs.length > 0) {
                    warnings.push({
                        title: 'No information entered for: ' + emptyLocs.join(', '),
                        items: ['You declared ' + locCount + ' location(s) but some are completely blank.']
                    });
                }
                partialLocs.forEach(function (p) { warnings.push(p); });
            }

            // ─── STEP 3: Empty section cards ───
            if (step === 3) {
                var stepEl = document.querySelector('.form-step[data-step="3"]');
                if (stepEl) {
                    var emptyCards = [];
                    stepEl.querySelectorAll('.section-card').forEach(function (card) {
                        var hasData = false;
                        card.querySelectorAll('input, select, textarea').forEach(function (f) {
                            if (f.type === 'checkbox' || f.type === 'radio') {
                                if (f.checked) hasData = true;
                            } else if (f.value && f.value.trim() !== '') {
                                hasData = true;
                            }
                        });
                        if (!hasData) {
                            var h = card.querySelector('.section-card-header h3');
                            emptyCards.push(h ? h.textContent.trim() : 'Untitled section');
                        }
                    });
                    if (emptyCards.length > 0) {
                        warnings.push({
                            title: 'These sections have no data entered:',
                            items: emptyCards
                        });
                    }
                }
            }

            return warnings;
        }

        // ═══════════════════════════════════════════
        // 6D. NEXT / PREV CLICK HANDLER (with modal)
        // ═══════════════════════════════════════════
        document.addEventListener('click', function (e) {
            if (e.target.closest('.btn-next')) {
                if (!validateStep(currentStep)) return;
                var warnings = collectStepWarnings(currentStep);
                if (warnings.length > 0) {
                    showEdenModal({
                        title: 'Some information is missing',
                        subtitle: 'You can go back and complete it, or proceed if this is intentional.',
                        warnings: warnings,
                        cancelText: 'Go Back & Complete',
                        confirmText: 'Proceed Anyway',
                        icon: 'fa-triangle-exclamation'
                    }).then(function (proceed) {
                        if (proceed) {
                            showStep(currentStep + 1);
                            autoSave();
                        }
                    });
                } else {
                    showStep(currentStep + 1);
                    autoSave();
                }
            }
            if (e.target.closest('.btn-prev')) {
                showStep(currentStep - 1);
            }
        });

        assessForm.addEventListener('input', function (e) {
            var g = e.target.closest('.form-group');
            if (g) { g.classList.remove('has-error'); var err = g.querySelector('.field-error'); if (err) err.textContent = ''; }
        });
        assessForm.addEventListener('change', function (e) {
            if (e.target.id === 'consent_checkbox') {
                var ce = document.getElementById('consent-error'); if (ce) ce.textContent = '';
            }
            var g = e.target.closest('.form-group');
            if (g) { g.classList.remove('has-error'); var err = g.querySelector('.field-error'); if (err) err.textContent = ''; }
        });


        // ═══════════════════════════════════════════
        // 6E. REVIEW STEP — STRUCTURE-AWARE SUMMARY
        // ═══════════════════════════════════════════
        function generateReview() {
            var container = document.getElementById('reviewContainer');
            if (!container) return;

            var html = '';
            html += renderStep1Review();

            var locCount = parseInt(numLocInput.value) || 1;
            for (var i = 0; i < locCount; i++) {
                html += renderLocationReview(i);
            }

            html += renderStep3Review();

            container.innerHTML = html;

            // Bind edit buttons
            container.querySelectorAll('.review-edit-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var jumpTo = parseInt(this.getAttribute('data-jump'));
                    var jumpLoc = this.getAttribute('data-loc');
                    showStep(jumpTo);
                    if (jumpLoc !== null && jumpLoc !== undefined && jumpLoc !== '') {
                        setTimeout(function () { switchLocTab(parseInt(jumpLoc)); }, 100);
                    }
                });
            });
        }

        // ─── STEP 1 ───
        function renderStep1Review() {
            var groups = [
                {
                    title: 'Contact Information', icon: 'fa-id-card', fields: [
                        { name: 'client_name', label: 'Organization Name' },
                        { name: 'contact_email', label: 'Contact Email' },
                        { name: 'contact_phone', label: 'Contact Phone' },
                        { name: 'designation', label: 'Designation' }
                    ]
                },
                {
                    title: 'Organization Size', icon: 'fa-users', fields: [
                        { name: 'org_size', label: 'Organization Size' },
                        { name: 'num_employees', label: 'No. of Employees' },
                        { name: 'total_employees', label: 'Total Employees (All Locations)' },
                        { name: 'num_locations', label: 'No. of Locations' },
                        { name: 'work_days', label: 'Work Days per Week' },
                        { name: 'total_working_hours', label: 'Total Working Hours/Day' }
                    ]
                },
                {
                    title: 'Departments & Vendors', icon: 'fa-sitemap', fields: [
                        { name: 'num_departments', label: 'No. of Departments' },
                        { name: 'departments_list', label: 'Departments List' },
                        { name: 'num_vendors', label: 'No. of Vendors' },
                        { name: 'vendors_list', label: 'Vendors List' }
                    ]
                },
                {
                    title: 'IT Support', icon: 'fa-headset', fields: [
                        { name: 'inhouse_it_support', label: 'Inhouse IT Support' },
                        { name: 'num_it_support_staff', label: 'IT Team Strength' }
                    ]
                }
            ];

            var bodyHtml = '';
            groups.forEach(function (g) {
                var rows = '';
                g.fields.forEach(function (f) {
                    var val = getFieldValue(f.name);
                    if (val !== '' && val !== null && val !== undefined && !(Array.isArray(val) && val.length === 0)) {
                        rows += '<div class="review-row"><span class="review-label">' + f.label + '</span><span class="review-value">' + formatValue(val) + '</span></div>';
                    }
                });
                if (rows) {
                    bodyHtml += '<div class="review-subsection">' +
                        '<div class="review-subsection-title"><i class="fa-solid ' + g.icon + '"></i> ' + g.title + '</div>' +
                        '<div class="review-grid">' + rows + '</div>' +
                        '</div>';
                }
            });

            if (!bodyHtml) return '';
            return wrapReviewSection({ title: 'Organization Details', icon: 'fa-building', jumpStep: 1 }, bodyHtml);
        }

        // ─── STEP 2 (LOCATION) — FIXED ───
        function renderLocationReview(idx) {
            var num = idx + 1;
            var panel = locContents.querySelector('.location-panel[data-loc="' + idx + '"]');
            if (!panel) return '';

            var bodyHtml = '';

            // 1. BASIC INFO — every field NOT inside a toggle-section / section-toggles-grid
            var basicRows = '';
            panel.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (!f.name) return;
                if (f.closest('.toggle-section')) return;          // skip stuff inside open toggle sections
                if (f.closest('.section-toggles-grid')) return;     // skip the toggle selector checkboxes
                if (f.classList.contains('section-toggle')) return; // double safety

                var val;
                if (f.type === 'checkbox') {
                    if (!f.checked) return;
                    val = f.value || 'yes';
                } else if (f.type === 'radio') {
                    if (!f.checked) return;
                    val = f.value;
                } else {
                    val = f.value;
                    if (!val || val.trim() === '') return;
                }

                var lbl = getFieldLabel(f) || f.name;
                lbl = lbl.replace(/\*$/, '').replace(/\s+/g, ' ').trim();
                basicRows += '<div class="review-row"><span class="review-label">' + lbl + '</span><span class="review-value">' + formatValue(val) + '</span></div>';
            });

            if (basicRows) {
                bodyHtml += '<div class="review-subsection">' +
                    '<div class="review-subsection-title"><i class="fa-solid fa-info-circle"></i> Basic Information</div>' +
                    '<div class="review-grid">' + basicRows + '</div>' +
                    '</div>';
            }

            // 2. Each OPEN toggle section → subsection
            panel.querySelectorAll('.section-toggle:checked').forEach(function (toggle) {
                var targetId = toggle.getAttribute('data-target');
                var section = document.getElementById(targetId);
                if (!section) return;

                var toggleCard = toggle.closest('.section-toggle-card');
                var labelInfo = extractLabelInfo(toggleCard);

                // Try structured render first, fall back to flat extraction
                var sectionContent = renderStructuredContent(section);
                if (!sectionContent) {
                    // Fallback: just extract all fields flat
                    var flatRows = extractAllFieldsFlat(section);
                    if (flatRows) {
                        sectionContent = '<div class="review-grid">' + flatRows + '</div>';
                    }
                }

                if (sectionContent) {
                    bodyHtml += '<div class="review-subsection">' +
                        '<div class="review-subsection-title"><i class="' + labelInfo.iconClass + '"></i> ' + labelInfo.text + '</div>' +
                        sectionContent +
                        '</div>';
                }
            });

            if (!bodyHtml) {
                bodyHtml = '<div class="review-empty-state"><i class="fa-solid fa-circle-info"></i> No information entered for this location.</div>';
            }

            return wrapReviewSection({
                title: 'Location ' + num,
                icon: 'fa-location-dot',
                jumpStep: 2,
                jumpLoc: idx,
                isLocation: true
            }, bodyHtml);
        }


        // ─── STEP 3 ───
        function renderStep3Review() {
            var step3 = document.querySelector('.form-step[data-step="3"]');
            if (!step3) return '';

            var html = '';
            step3.querySelectorAll('.section-card').forEach(function (card) {
                var headerH3 = card.querySelector('.section-card-header h3');
                var iconEl = card.querySelector('.section-card-icon i');
                var title = headerH3 ? headerH3.textContent.trim() : 'Section';
                var iconClass = iconEl ? iconEl.className : 'fa-solid fa-folder';

                var content = renderStructuredContent(card);
                if (content) {
                    html += wrapReviewSection({ title: title, icon: iconClass.replace('fa-solid ', ''), jumpStep: 3 }, content);
                }
            });
            return html;
        }

        // ─── RECURSIVE CONTENT WALKER ───
        // Walks a container, groups items by subsection-labels, and handles dynamic-rows + conditional-fields
        // ─── STRUCTURED CONTENT WALKER — FIXED ───
        function renderStructuredContent(container) {
            var groups = [];
            var currentGroup = { label: null, rowsHtml: '', dynamicHtml: '', specialHtml: '' };
            var processedFields = new WeakSet();

            function flush() {
                if (currentGroup.rowsHtml || currentGroup.dynamicHtml || currentGroup.specialHtml) {
                    groups.push(currentGroup);
                }
                currentGroup = { label: null, rowsHtml: '', dynamicHtml: '', specialHtml: '' };
            }

            function walk(node) {
                Array.from(node.children).forEach(function (child) {
                    if (child.classList.contains('section-card-header')) return;

                    // Subsection label → start a new group
                    if (child.classList.contains('subsection-label')) {
                        flush();
                        currentGroup.label = child.textContent.trim();
                        return;
                    }

                    // Dynamic rows container
                    if (child.classList.contains('dynamic-rows') ||
                        (child.id && (child.id.indexOf('-rows-') > -1 || child.id.indexOf('-drives-') > -1))) {
                        Array.from(child.children).forEach(function (dynRow) {
                            var rowLabelEl = dynRow.querySelector('.dynamic-row-label');
                            var rowTitle = rowLabelEl ? rowLabelEl.textContent.trim() : 'Item';
                            var rowFields = extractFieldsAsRows(dynRow);
                            // Mark inputs inside dynamic rows as processed
                            dynRow.querySelectorAll('input, select, textarea').forEach(function (f) { processedFields.add(f); });
                            if (rowFields) {
                                currentGroup.dynamicHtml +=
                                    '<div class="review-dynamic-row">' +
                                    '<div class="review-dynamic-title"><i class="fa-solid fa-angle-right"></i> ' + rowTitle + '</div>' +
                                    '<div class="review-grid review-grid-tight">' + rowFields + '</div>' +
                                    '</div>';
                            }
                        });
                        return;
                    }

                    // Security table
                    if (child.querySelector && child.querySelector('.security-table')) {
                        var tableHtml = renderSecurityTable(child);
                        child.querySelectorAll('input, select, textarea').forEach(function (f) { processedFields.add(f); });
                        if (tableHtml) currentGroup.specialHtml += tableHtml;
                        return;
                    }

                    // Conditional fields → recurse into them
                    if (child.classList.contains('conditional-field')) {
                        walk(child);
                        return;
                    }

                    // Skip nested toggle sections / section cards
                    if (child.classList.contains('toggle-section') || child.classList.contains('section-card')) {
                        return;
                    }

                    // Regular field-bearing element — extract any inputs
                    var rows = extractFieldsAsRows(child);
                    child.querySelectorAll('input, select, textarea').forEach(function (f) { processedFields.add(f); });
                    currentGroup.rowsHtml += rows;
                });
            }

            walk(container);
            flush();

            // Catch any inputs that weren't picked up by structured walk (safety net)
            var leftoverRows = '';
            container.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (processedFields.has(f)) return;
                if (!f.name) return;
                if (f.closest('.security-table')) return;
                if (f.classList.contains('section-toggle')) return;

                var val;
                if (f.type === 'checkbox') {
                    if (!f.checked) return;
                    val = f.value || 'yes';
                } else if (f.type === 'radio') {
                    if (!f.checked) return;
                    val = f.value;
                } else {
                    val = f.value;
                    if (!val || val.trim() === '') return;
                }
                var lbl = getFieldLabel(f) || f.name;
                lbl = lbl.replace(/\*$/, '').replace(/\s+/g, ' ').trim();
                leftoverRows += '<div class="review-row"><span class="review-label">' + lbl + '</span><span class="review-value">' + formatValue(val) + '</span></div>';
            });
            if (leftoverRows) {
                groups.push({ label: null, rowsHtml: leftoverRows, dynamicHtml: '', specialHtml: '' });
            }

            var html = '';
            groups.forEach(function (g) {
                if (!g.rowsHtml && !g.dynamicHtml && !g.specialHtml) return;
                var inner = '';
                if (g.rowsHtml) inner += '<div class="review-grid">' + g.rowsHtml + '</div>';
                if (g.dynamicHtml) inner += '<div class="review-dynamic-wrap">' + g.dynamicHtml + '</div>';
                if (g.specialHtml) inner += g.specialHtml;

                if (g.label) {
                    html += '<div class="review-nested">' +
                        '<div class="review-nested-title">' + g.label + '</div>' +
                        inner +
                        '</div>';
                } else {
                    html += inner;
                }
            });
            return html;
        }


        // ─── SECURITY TABLE RENDERER ───
        function renderSecurityTable(container) {
            var table = container.querySelector('.security-table');
            if (!table) return '';

            // ─── Detect if this is a DEVICE TABLE (Qty + OEM) vs SECURITY TABLE (Y/N + Remarks) ───
            var isDeviceTable = table.classList.contains('eden-device-table');

            if (isDeviceTable) {
                return renderDeviceTable(table);
            }

            return renderEndpointSecurityTable(table);
        }

        // ─── Original endpoint security renderer (Feature / Status / Remarks) ───
        function renderEndpointSecurityTable(table) {
            var rows = '';
            table.querySelectorAll('tbody tr').forEach(function (tr) {
                var firstTd = tr.querySelector('td:first-child');
                if (!firstTd) return;
                var feature = firstTd.textContent.trim();
                var radio = tr.querySelector('input[type="radio"]:checked');
                var remarksInput = tr.querySelector('input[type="text"]');
                var status = radio ? radio.value : '';
                var remarks = remarksInput ? (remarksInput.value || '').trim() : '';
                if (!status && !remarks) return;
                var badge = status === 'yes'
                    ? '<span class="review-badge review-badge-yes"><i class="fa-solid fa-check"></i> Yes</span>'
                    : (status === 'no' ? '<span class="review-badge review-badge-no"><i class="fa-solid fa-xmark"></i> No</span>' : '<span class="review-badge review-badge-na">—</span>');
                rows += '<tr><td>' + feature + '</td><td>' + badge + '</td><td>' + (remarks || '<span class="review-empty">—</span>') + '</td></tr>';
            });
            if (!rows) return '';
            return '<div class="review-table-wrap"><table class="review-table"><thead><tr><th>Feature</th><th style="width:100px;">Status</th><th>Remarks</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
        }

        // ─── NEW: Device table renderer (Device / Quantity / OEM) ───
        function renderDeviceTable(table) {
            var rows = '';
            table.querySelectorAll('tbody tr').forEach(function (tr) {
                var firstTd = tr.querySelector('td:first-child');
                if (!firstTd) return;

                // Clean device name (remove icon span text artifacts)
                var clone = firstTd.cloneNode(true);
                var icon = clone.querySelector('i');
                if (icon) icon.remove();
                var device = clone.textContent.trim();

                // Find qty (number input) and OEM (text input)
                var qtyInput = tr.querySelector('input[type="number"]');
                var oemInput = tr.querySelector('input[type="text"]');

                var qty = qtyInput ? (qtyInput.value || '').trim() : '';
                var oem = oemInput ? (oemInput.value || '').trim() : '';

                // Skip rows where neither qty nor OEM has data
                if ((!qty || qty === '0') && !oem) return;

                var qtyDisplay = (qty && qty !== '0')
                    ? '<span class="review-qty-badge">' + qty + '</span>'
                    : '<span class="review-empty">—</span>';
                var oemDisplay = oem || '<span class="review-empty">—</span>';

                rows += '<tr><td>' + device + '</td><td>' + qtyDisplay + '</td><td>' + oemDisplay + '</td></tr>';
            });

            if (!rows) return '';
            return '<div class="review-table-wrap"><table class="review-table"><thead><tr><th>Device</th><th style="width:100px;">Quantity</th><th>OEM / Vendor</th></tr></thead><tbody>' + rows + '</tbody></table></div>';
        }

        // ─── HELPERS ───
        function extractFieldsAsRows(element) {
            var rows = '';
            if (!element || !element.querySelectorAll) return '';

            // Skip security-table fields (handled separately)
            if (element.closest && element.closest('.security-table')) return '';

            element.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (!f.name) return;
                if (f.closest('.security-table')) return; // handled separately
                if (f.classList.contains('section-toggle')) return; // skip the toggle checkbox itself

                var val;
                if (f.type === 'checkbox') {
                    if (!f.checked) return;
                    val = f.value || 'yes';
                } else if (f.type === 'radio') {
                    if (!f.checked) return;
                    val = f.value;
                } else {
                    val = f.value;
                    if (!val || val.trim() === '') return;
                }

                var lbl = getFieldLabel(f);
                if (!lbl) lbl = f.name;
                lbl = lbl.replace(/\*$/, '').replace(/\s+/g, ' ').trim();

                // For grouped checkboxes (name="xxx[]"), prefix with parent label + value
                if (f.type === 'checkbox' && f.name.indexOf('[]') > -1) {
                    // We aggregate these later — for now render each as a tag
                    rows += '<div class="review-row review-row-tag"><span class="review-label">' + lbl + '</span><span class="review-value"><span class="review-tag">' + f.value + '</span></span></div>';
                    return;
                }

                rows += '<div class="review-row"><span class="review-label">' + lbl + '</span><span class="review-value">' + formatValue(val) + '</span></div>';
            });
            return rows;
        }
        // ─── FLAT FALLBACK — extracts ALL fields, ignores structure ───
        function extractAllFieldsFlat(container) {
            var rows = '';
            container.querySelectorAll('input, select, textarea').forEach(function (f) {
                if (!f.name) return;
                if (f.closest('.security-table')) return;
                if (f.classList.contains('section-toggle')) return;

                var val;
                if (f.type === 'checkbox') {
                    if (!f.checked) return;
                    val = f.value || 'yes';
                } else if (f.type === 'radio') {
                    if (!f.checked) return;
                    val = f.value;
                } else {
                    val = f.value;
                    if (!val || val.trim() === '') return;
                }
                var lbl = getFieldLabel(f) || f.name;
                lbl = lbl.replace(/\*$/, '').replace(/\s+/g, ' ').trim();
                rows += '<div class="review-row"><span class="review-label">' + lbl + '</span><span class="review-value">' + formatValue(val) + '</span></div>';
            });
            return rows;
        }
        function getFieldLabel(f) {
            // Radio in yn-row → use yn-label
            if (f.type === 'radio') {
                var ynRow = f.closest('.yn-row');
                if (ynRow) {
                    var ynLabel = ynRow.querySelector('.yn-label');
                    if (ynLabel) return ynLabel.textContent.trim();
                }
            }
            // Form-group's main label (not the radio/checkbox-label children)
            var fg = f.closest('.form-group');
            if (fg) {
                var labels = fg.querySelectorAll(':scope > label');
                for (var i = 0; i < labels.length; i++) {
                    if (!labels[i].classList.contains('radio-label') && !labels[i].classList.contains('checkbox-label')) {
                        return labels[i].textContent.trim();
                    }
                }
            }
            // Dynamic row context
            var dr = f.closest('.dynamic-row');
            if (dr) {
                var inner = f.closest('.form-group');
                if (inner) {
                    var lbl = inner.querySelector('label');
                    if (lbl) return lbl.textContent.trim();
                }
            }
            return '';
        }

        function extractLabelInfo(toggleCard) {
            var info = { text: 'Section', iconClass: 'fa-solid fa-folder' };
            if (!toggleCard) return info;
            var clone = toggleCard.cloneNode(true);
            var cb = clone.querySelector('input');
            if (cb) cb.remove();
            var iconEl = clone.querySelector('i');
            if (iconEl) {
                info.iconClass = iconEl.className;
                iconEl.remove();
            }
            info.text = clone.textContent.trim();
            return info;
        }

        function wrapReviewSection(opts, body) {
            var locAttr = (opts.jumpLoc !== undefined && opts.jumpLoc !== null) ? ' data-loc="' + opts.jumpLoc + '"' : '';
            var locClass = opts.isLocation ? ' review-location' : '';
            var iconFull = opts.icon && opts.icon.indexOf('fa-') === 0 ? 'fa-solid ' + opts.icon : (opts.icon || 'fa-solid fa-folder');
            return '<div class="review-section' + locClass + '">' +
                '<div class="review-section-header">' +
                '<div class="review-section-title">' +
                '<div class="review-section-icon"><i class="' + iconFull + '"></i></div>' +
                '<h3>' + opts.title + '</h3>' +
                '</div>' +
                '<button type="button" class="review-edit-btn" data-jump="' + opts.jumpStep + '"' + locAttr + '>' +
                '<i class="fa-solid fa-pen-to-square"></i> Edit' +
                '</button>' +
                '</div>' +
                '<div class="review-section-body">' + body + '</div>' +
                '</div>';
        }

        function getFieldValue(name) {
            var radio = assessForm.querySelector('input[type="radio"][name="' + name + '"]:checked');
            if (radio) return radio.value;
            var checkboxes = assessForm.querySelectorAll('input[type="checkbox"][name="' + name + '[]"]:checked');
            if (checkboxes.length) {
                var arr = [];
                checkboxes.forEach(function (c) { arr.push(c.value); });
                return arr;
            }
            var field = assessForm.querySelector('[name="' + name + '"]');
            if (field) {
                if (field.type === 'checkbox') return field.checked ? 'yes' : '';
                return field.value || '';
            }
            return '';
        }

        function formatValue(val) {
            if (Array.isArray(val)) return val.map(function (v) { return '<span class="review-tag">' + v + '</span>'; }).join(' ');
            if (val === 'yes') return '<span class="review-badge review-badge-yes"><i class="fa-solid fa-check"></i> Yes</span>';
            if (val === 'no') return '<span class="review-badge review-badge-no"><i class="fa-solid fa-xmark"></i> No</span>';
            return String(val);
        }
        // ═══════════════════════════════════════════
        // 7. COLLECT FORM DATA
        // ═══════════════════════════════════════════
        function collectFormData() {
            var data = {};

            // Text/number/email/tel/url/textarea/select
            assessForm.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], input[type="tel"], input[type="url"], textarea, select').forEach(function (el) {
                if (el.name) data[el.name] = el.value;
            });

            // Checked radios
            assessForm.querySelectorAll('input[type="radio"]:checked').forEach(function (el) {
                if (el.name) data[el.name] = el.value;
            });

            // Checkboxes — collect ALL (checked AND unchecked) for arrays, plus single checkboxes
            var cbGroups = {};
            var seenGroupNames = {};

            assessForm.querySelectorAll('input[type="checkbox"]').forEach(function (el) {
                if (!el.name) return;

                if (el.name.indexOf('[]') > -1) {
                    var clean = el.name.replace('[]', '');
                    seenGroupNames[clean] = true;
                    if (!cbGroups[clean]) cbGroups[clean] = [];
                    if (el.checked) cbGroups[clean].push(el.value);
                } else {
                    data[el.name] = el.checked ? (el.value || 'yes') : '';
                }
            });

            for (var key in seenGroupNames) {
                data[key] = cbGroups[key] || [];
            }

            // ─── NEW: Save section toggle states by their data-target ───
            // This handles checkboxes that don't have name attributes (.section-toggle)
            var sectionToggles = {};
            assessForm.querySelectorAll('.section-toggle').forEach(function (cb) {
                var target = cb.getAttribute('data-target');
                if (target) sectionToggles[target] = cb.checked;
            });
            data._section_toggles = sectionToggles;

            // ─── NEW: Save Y/N conditional trigger states (radios that reveal sections) ───
            // These are already saved via radio name, but we also save which conditional fields were visible
            var conditionalStates = {};
            assessForm.querySelectorAll('.conditional-field').forEach(function (cf) {
                if (cf.id) conditionalStates[cf.id] = (cf.style.display !== 'none');
            });
            data._conditional_states = conditionalStates;

            data._loc_count = parseInt(numLocInput.value) || 1;
            return data;
        }
        // ═══════════════════════════════════════════
        // 8. FORM SUBMISSION (AJAX)
        // ═══════════════════════════════════════════
        assessForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!validateStep(currentStep)) return;

            var formData = collectFormData();
            var submitBtn = document.getElementById('submitBtn');
            var btnText = submitBtn.querySelector('.btn-text');
            var btnLoading = submitBtn.querySelector('.btn-loading');

            if (btnText) btnText.style.display = 'none';
            if (btnLoading) btnLoading.style.display = 'inline-flex';
            submitBtn.disabled = true;

            var params = new URLSearchParams();
            params.append('action', 'eden_submit_assessment');
            params.append('nonce', edenAjax.nonce);

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
                .then(function (r) { return r.json(); })
                .then(function (response) {
                    if (btnText) btnText.style.display = '';
                    if (btnLoading) btnLoading.style.display = 'none';
                    submitBtn.disabled = false;

                    if (response.success) {
                        clearSavedDraft();
                        formSection.style.display = 'none';
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
                .catch(function () {
                    if (btnText) btnText.style.display = '';
                    if (btnLoading) btnLoading.style.display = 'none';
                    submitBtn.disabled = false;
                    alert('Network error. Please check your connection and try again.');
                });
        });

        // ═══════════════════════════════════════════
        // 9. DISPLAY RESULTS & SCORE ANIMATION
        // ═══════════════════════════════════════════
        function displayResults(data) {
            setText('resultClientName', data.client_name || document.getElementById('client_name').value);
        }

        function setText(id, val) { var el = document.getElementById(id); if (el) el.textContent = val; }





        // ═══════════════════════════════════════════
        // 10. SAVE & RESTORE DRAFT (HARDENED)
        // ═══════════════════════════════════════════

        // Save throttling — prevents rapid hits on every keystroke
        var autoSaveTimer = null;
        var lastSavedAt = 0;

        function autoSave(showFeedback) {
            try {
                var formData = collectFormData();
                var payload = {
                    step: currentStep,
                    locCount: parseInt(numLocInput.value) || 1,
                    data: formData,
                    timestamp: new Date().toISOString(),
                    version: 2  // bump version if schema changes
                };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
                lastSavedAt = Date.now();

                if (showFeedback) {
                    showSaveToast('Progress saved successfully', 'success');
                }
            } catch (e) {
                if (showFeedback) {
                    showSaveToast('Could not save — storage may be full', 'error');
                }
                console.warn('autoSave failed:', e);
            }
        }

        // Debounced auto-save while typing (fires 1.5s after user stops typing)
        function debouncedAutoSave() {
            if (autoSaveTimer) clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function () { autoSave(false); }, 1500);
        }

        // Hook auto-save into every form change/input
        assessForm.addEventListener('input', debouncedAutoSave);
        assessForm.addEventListener('change', debouncedAutoSave);

        // Manual save button
        var saveBtn = document.getElementById('saveProgressBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', function () {
                autoSave(true);
            });
        }

        // ─── TOAST NOTIFICATION ───
        function showSaveToast(msg, type) {
            var existing = document.getElementById('edenSaveToast');
            if (existing) existing.remove();

            var toast = document.createElement('div');
            toast.id = 'edenSaveToast';
            toast.className = 'eden-save-toast eden-save-toast-' + (type || 'success');
            var icon = type === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check';
            toast.innerHTML = '<i class="fa-solid ' + icon + '"></i> <span>' + msg + '</span>';
            document.body.appendChild(toast);

            requestAnimationFrame(function () { toast.classList.add('show'); });
            setTimeout(function () {
                toast.classList.remove('show');
                setTimeout(function () { if (toast.parentNode) toast.remove(); }, 350);
            }, 2800);
        }

        // ─── DRAFT RESTORE FLOW ───
        function tryRestoreDraft() {
            try {
                var saved = localStorage.getItem(STORAGE_KEY);
                if (!saved) return;
                var obj = JSON.parse(saved);
                if (!obj || !obj.data) return;

                var savedDate = new Date(obj.timestamp);
                var diffDays = (new Date() - savedDate) / (1000 * 60 * 60 * 24);
                if (diffDays > 7) { clearSavedDraft(); return; }

                // Count how many fields have data (so we can show summary)
                var filledCount = 0;
                for (var k in obj.data) {
                    if (k.charAt(0) === '_') continue;
                    var v = obj.data[k];
                    if (Array.isArray(v) ? v.length : (v && String(v).trim() !== '')) filledCount++;
                }

                // Format friendly date
                var dateStr = savedDate.toLocaleDateString(undefined, { day: 'numeric', month: 'short', year: 'numeric' });
                var timeStr = savedDate.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' });

                showDraftModal({
                    dateStr: dateStr,
                    timeStr: timeStr,
                    step: obj.step || 1,
                    locCount: obj.locCount || 1,
                    filledCount: filledCount,
                    onContinue: function () { restoreDraft(obj); },
                    onDiscard: function () { clearSavedDraft(); }
                });
            } catch (e) {
                console.warn('Restore draft failed:', e);
            }
        }

        function restoreDraft(obj) {
            var data = obj.data;

            // 1. Rebuild location tabs FIRST (so panels exist)
            if (obj.locCount && numLocInput) {
                numLocInput.value = obj.locCount;
                buildLocationTabs(obj.locCount);
            }

            // 2. ─── RESTORE SECTION TOGGLES FIRST ─── (so sections open and reveal their fields)
            if (data._section_toggles) {
                for (var target in data._section_toggles) {
                    if (!data._section_toggles[target]) continue;
                    var toggleCb = assessForm.querySelector('.section-toggle[data-target="' + target + '"]');
                    if (toggleCb) {
                        toggleCb.checked = true;
                        // Manually add open class instead of relying on change event (which would clear fields if unchecked)
                        var sec = document.getElementById(target);
                        if (sec) sec.classList.add('open');
                    }
                }
            }

            // 3. Populate text/number/email/textarea/select fields
            for (var key in data) {
                if (key.charAt(0) === '_') continue;
                var val = data[key];
                if (Array.isArray(val)) continue;
                var field = assessForm.querySelector('[name="' + key + '"]');
                if (!field) continue;
                if (field.type === 'radio' || field.type === 'checkbox') continue;
                field.value = val;
            }

            // 4. Restore radios — fire change event so Y/N conditionals reveal
            for (var key2 in data) {
                if (key2.charAt(0) === '_') continue;
                var val2 = data[key2];
                if (Array.isArray(val2)) continue;
                var radio = assessForm.querySelector('input[type="radio"][name="' + key2 + '"][value="' + val2 + '"]');
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }

            // 5. Restore single checkboxes (consent, individual Y/N checkboxes)
            for (var key3 in data) {
                if (key3.charAt(0) === '_') continue;
                var val3 = data[key3];
                if (Array.isArray(val3)) continue;
                var cb = assessForm.querySelector('input[type="checkbox"][name="' + key3 + '"]');
                if (!cb) continue;
                if (cb.classList.contains('section-toggle')) continue; // already handled in step 2
                if (val3 === 'yes' || val3 === 'on' || val3 === cb.value) {
                    cb.checked = true;
                    cb.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }

            // 6. Restore grouped checkboxes (name="xxx[]")
            for (var key4 in data) {
                if (key4.charAt(0) === '_') continue;
                var val4 = data[key4];
                if (!Array.isArray(val4)) continue;
                val4.forEach(function (v) {
                    var box = assessForm.querySelector('input[type="checkbox"][name="' + key4 + '[]"][value="' + v + '"]');
                    if (box) {
                        box.checked = true;
                        box.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
            }

            // 7. ─── RESTORE CONDITIONAL FIELD VISIBILITY ─── (extra safety for Y/N triggered sections)
            if (data._conditional_states) {
                for (var cfId in data._conditional_states) {
                    if (!data._conditional_states[cfId]) continue;
                    var cf = document.getElementById(cfId);
                    if (cf) cf.style.display = '';
                }
            }

            // 8. Trigger qty inputs to generate dynamic rows
            assessForm.querySelectorAll('.eden-qty-trigger').forEach(function (f) {
                if (f.value && parseInt(f.value) > 0) {
                    f.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });

            // 9. After dynamic rows generate, fill their child values (2 passes for reliability)
            requestAnimationFrame(function () {
                setTimeout(function () { fillDynamicRowValues(data); }, 50);
                setTimeout(function () { fillDynamicRowValues(data); }, 250);
                setTimeout(function () { fillDynamicRowValues(data); }, 600);
            });

            // 10. Jump to saved step
            if (obj.step && obj.step > 1 && obj.step <= TOTAL_STEPS) {
                setTimeout(function () { showStep(obj.step); }, 400);
            }

            showSaveToast('Draft restored successfully — continuing from step ' + (obj.step || 1), 'success');
        }

        function fillDynamicRowValues(data) {
            for (var key in data) {
                if (key.charAt(0) === '_') continue;
                var val = data[key];
                if (Array.isArray(val)) continue;
                var field = assessForm.querySelector('[name="' + key + '"]');
                if (!field) continue;
                if (field.type === 'radio' || field.type === 'checkbox') continue;
                if (!field.value || field.value !== String(val)) {
                    field.value = val;
                }
            }
            // Re-restore selects inside dynamic rows
            for (var key2 in data) {
                if (key2.charAt(0) === '_') continue;
                var val2 = data[key2];
                if (Array.isArray(val2)) continue;
                var sel = assessForm.querySelector('select[name="' + key2 + '"]');
                if (sel && sel.value !== String(val2)) sel.value = val2;
            }
        }

        function clearSavedDraft() {
            try { localStorage.removeItem(STORAGE_KEY); } catch (e) { }
        }

        // ─── CUSTOM DRAFT MODAL ───
        function showDraftModal(opts) {
            var existing = document.getElementById('edenDraftModal');
            if (existing) existing.remove();

            var overlay = document.createElement('div');
            overlay.id = 'edenDraftModal';
            overlay.className = 'eden-modal-overlay';

            overlay.innerHTML =
                '<div class="eden-modal eden-draft-modal" role="dialog" aria-modal="true">' +
                '<div class="eden-modal-header">' +
                '<div class="eden-modal-icon eden-draft-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>' +
                '<div class="eden-modal-title">' +
                '<h3>Welcome Back! 👋</h3>' +
                '<p>We found a saved draft from your previous session.</p>' +
                '</div>' +
                '</div>' +
                '<div class="eden-modal-body">' +
                '<div class="eden-draft-stats">' +
                '<div class="eden-draft-stat"><i class="fa-solid fa-calendar-days"></i><div><span class="stat-label">Saved on</span><span class="stat-value">' + opts.dateStr + ' at ' + opts.timeStr + '</span></div></div>' +
                '<div class="eden-draft-stat"><i class="fa-solid fa-layer-group"></i><div><span class="stat-label">You were on</span><span class="stat-value">Step ' + opts.step + ' of ' + TOTAL_STEPS + '</span></div></div>' +
                '<div class="eden-draft-stat"><i class="fa-solid fa-location-dot"></i><div><span class="stat-label">Locations</span><span class="stat-value">' + opts.locCount + ' configured</span></div></div>' +
                '<div class="eden-draft-stat"><i class="fa-solid fa-pen-fancy"></i><div><span class="stat-label">Fields filled</span><span class="stat-value">' + opts.filledCount + ' entries</span></div></div>' +
                '</div>' +
                '<p class="eden-draft-hint"><i class="fa-solid fa-circle-info"></i> You can continue where you left off, or start fresh.</p>' +
                '</div>' +
                '<div class="eden-modal-footer">' +
                '<button type="button" class="eden-modal-btn eden-modal-btn-cancel" id="edenDraftDiscard"><i class="fa-solid fa-trash-can"></i> Start Fresh</button>' +
                '<button type="button" class="eden-modal-btn eden-modal-btn-confirm" id="edenDraftContinue"><i class="fa-solid fa-arrow-rotate-right"></i> Continue Draft</button>' +
                '</div>' +
                '</div>';

            document.body.appendChild(overlay);
            requestAnimationFrame(function () { overlay.classList.add('active'); });

            function close() {
                overlay.classList.remove('active');
                setTimeout(function () { if (overlay.parentNode) overlay.remove(); }, 250);
            }

            document.getElementById('edenDraftContinue').addEventListener('click', function () {
                close();
                opts.onContinue();
            });
            document.getElementById('edenDraftDiscard').addEventListener('click', function () {
                if (confirm('Are you sure? Your saved progress will be permanently deleted.')) {
                    close();
                    opts.onDiscard();
                }
            });
        }


        // ═══════════════════════════════════════════
        // 12. KEYBOARD: Enter → Next Step
        // ═══════════════════════════════════════════
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
    /* ============ CAREERS PAGE ============ */
    window.openJobModal = function (id) {
        var src = document.getElementById('job-data-' + id);
        if (!src) return;
        document.getElementById('jobModalBody').innerHTML = src.innerHTML;
        document.getElementById('jobModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    window.closeJobModal = function () {
        var m = document.getElementById('jobModal');
        if (m) m.classList.remove('active');
        document.body.style.overflow = '';
    };
    window.openApplyForm = function (id, title) {
        window.closeJobModal();
        document.getElementById('applyJobId').value = id;
        document.getElementById('applyJobTitle').textContent = title;
        document.getElementById('applyModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    window.closeApplyForm = function () {
        var m = document.getElementById('applyModal');
        if (m) m.classList.remove('active');
        document.body.style.overflow = '';
    };

    // Close on background click
    document.addEventListener('click', function (e) {
        if (e.target.classList && e.target.classList.contains('job-modal')) {
            e.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Filters (NO nested DOMContentLoaded)
    var jobSearch = document.getElementById('jobSearch');
    if (jobSearch) {
        var dept = document.getElementById('filterDept');
        var type = document.getElementById('filterType');
        var cards = document.querySelectorAll('.job-card');
        var noRes = document.getElementById('noResults');

        function filterJobs() {
            var q = (jobSearch.value || '').toLowerCase().trim();
            var d = dept ? dept.value : '';
            var t = type ? type.value : '';
            var visible = 0;

            cards.forEach(function (card) {
                // Build searchable text from data-search OR fallback to card's visible text
                var searchSource = card.dataset.search || card.textContent || '';
                searchSource = searchSource.toLowerCase();

                var matchSearch = !q || searchSource.indexOf(q) !== -1;
                var matchDept = !d || card.dataset.dept === d;
                var matchType = !t || card.dataset.type === t;

                var show = matchSearch && matchDept && matchType;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (noRes) noRes.style.display = (visible === 0) ? 'block' : 'none';
        }

        jobSearch.addEventListener('input', filterJobs);
        if (dept) dept.addEventListener('change', filterJobs);
        if (type) type.addEventListener('change', filterJobs);
    }

});



