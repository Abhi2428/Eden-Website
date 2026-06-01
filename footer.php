<?php if (!defined('ABSPATH')) exit; ?>
<?php
$home_url     = home_url('/');
$products_url = eden_get_page_url('products', home_url('/products/'));
$about_url    = eden_get_page_url('about', home_url('/about/'));
?>

<footer class="footer" id="contact">
    <div class="container">
        <div class="footer-contact-strip">
            <div class="footer-contact-item">
                <i class="fas fa-phone"></i>
                <span>+91-XXXX-XXXXXX</span>
            </div>
            <div class="footer-contact-item">
                <i class="fas fa-envelope"></i>
                <span>info@edeninfosol.com</span>
            </div>
            <div class="footer-contact-item">
                <i class="fas fa-location-dot"></i>
                <span>India</span>
            </div>
        </div>

        <div class="footer-grid">
            <div class="footer-col footer-about">
                <h4><span style="color: var(--accent-light);">EDEN</span>INFOSOL</h4>
                <p>A full-spectrum technology solutions company serving enterprises, mid-market businesses and SMEs. One trusted partner. End-to-end capability.</p>
            </div>

            <div class="footer-col">
                <h4>Products &amp; Services</h4>
                <ul>
                    <li><a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>">IT Infrastructure</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>">Cloud &amp; Data Center</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>">Cybersecurity</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#managed-services'); ?>">Managed Services</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#connectivity-voice'); ?>">Connectivity &amp; Voice</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#audits-compliance'); ?>">Audits &amp; Compliance</a></li>
                    <li><a href="<?php echo esc_url($products_url . '#digital-solutions'); ?>">Digital Solutions</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="<?php echo esc_url($about_url); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#vision-mission'); ?>">Vision &amp; Mission</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#founders'); ?>">Our Founders</a></li>
                    <li><a href="<?php echo esc_url($about_url . '#why-us'); ?>">Why Choose Us</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo esc_url($home_url . '#contact'); ?>">Contact Us</a></li>
                    <li><a href="<?php echo esc_url($home_url . '#contact'); ?>">Free Assessment</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; <?php echo date('Y'); ?> Eden Infosol. All rights reserved.
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
``