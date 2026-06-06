<?php
$home_url = home_url('/');
$products_url = eden_get_page_url('products', home_url('/products/'));
$about_url = eden_get_page_url('about', home_url('/about/'));
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
$bytes_url = eden_get_page_url('eden-bytes', home_url('/eden-bytes/'));
$assess_url = eden_get_page_url('assessment', home_url('/assessment/'));
?>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">

            <!-- Column 1: About + Contact Details -->
            <div class="footer-col footer-about">
                <p class="footer-heading">EDEN INFOSOL PRIVATE LIMITED</p>
                <p>A full-spectrum technology solutions company serving Small and Medium Businesses
                    to Enterprises. One
                    trusted partner. End-to-end capability.</p>

                <div class="footer-contact-details">
                    <div class="footer-detail-item">
                        <a href="https://maps.google.com/?q=3rd+Floor+Hari+Om+Plaza+319+311+Mahatma+Gandhi+Rd+Borivali+East+Mumbai+400066"
                            target="_blank" rel="noopener noreferrer" class="footer-detail-link">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                        <a href="https://maps.google.com/?q=3rd+Floor+Hari+Om+Plaza+319+311+Mahatma+Gandhi+Rd+Borivali+East+Mumbai+400066"
                            target="_blank" rel="noopener noreferrer" class="footer-detail-link">
                            319, HariOm Plaza, 3rd Floor, M.G. Road, Opp. National Park, Borivali East, Mumbai,
                            Maharashtra 400066
                        </a>
                    </div>

                    <div class="footer-detail-item">
                        <a href="tel:+919029055464" class="footer-detail-link">
                            <i class="fas fa-phone"></i>
                        </a>
                        <a href="tel:+919029055464" class="footer-detail-link">
                            Tel: +91 90290 55464
                        </a>
                    </div>

                    <div class="footer-detail-item">
                        <a href="mailto:info@edeninfosol.com" class="footer-detail-link">
                            <i class="fas fa-envelope"></i>
                        </a>
                        <a href="mailto:info@edeninfosol.com" class="footer-detail-link">
                            info@edeninfosol.com
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Products & Services -->
            <div class="footer-col">
                <p class="footer-heading">Products & Services</p>
                <ul>
                    <li><a href="<?php echo esc_url($products_url . '#digital-connectivity'); ?>">Connectivity & Digital
                            Transformation
                        </a></li>
                    <li><a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>">IT Infrastructure</a>
                    </li>
                    <li><a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>">Cybersecurity</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>">Cloud & Data Center</a>
                    </li>

                    <li><a href="<?php echo esc_url($products_url . '#managed-services'); ?>">Professional Services</a>
                    </li>

                </ul>
            </div>

            <!-- Column 3: Company -->
            <div class="footer-col">
                <p class="footer-heading">Company</p>
                <ul>
                    <li><a href="<?php echo esc_url($about_url); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#vision-mission'); ?>">Vision & Mission</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#founders'); ?>">Our Founders</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#why-us'); ?>">Why Choose Us</a></li>
                </ul>
            </div>

            <!-- Column 4: Quick Links -->
            <div class="footer-col">
                <p class="footer-heading">Quick Links</p>

                <ul>
                    <li><a href="<?php echo esc_url($bytes_url); ?>">Eden Bytes</a></li>
                    <li><a href="<?php echo esc_url($contact_url); ?>">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            &copy; <?php echo date('Y'); ?> Eden Infosol Pvt. Ltd. All rights reserved.
        </div>
    </div>
</footer>

<script>
    (function () {
        var track = document.querySelector('.trust-track');
        if (!track) return;

        var screenCenter = window.innerWidth / 2;

        window.addEventListener('resize', function () {
            screenCenter = window.innerWidth / 2;
        });

        function tick() {
            var items = track.querySelectorAll('.trust-item-logo');
            var best = null;
            var bestDist = 99999;

            for (var i = 0; i < items.length; i++) {
                var box = items[i].getBoundingClientRect();
                var mid = box.left + box.width / 2;
                var d = Math.abs(mid - screenCenter);

                if (d < bestDist) {
                    bestDist = d;
                    best = items[i];
                }

                items[i].classList.remove('center-active');
            }

            if (best) {
                best.classList.add('center-active');
            }

            requestAnimationFrame(tick);
        }

        requestAnimationFrame(tick);
    })();
</script>

<?php wp_footer(); ?>
</body>

</html>