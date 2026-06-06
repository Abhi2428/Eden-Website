<?php
/**
 * Template Name: Eden Bytes
 */
if (!defined('ABSPATH'))
    exit;
get_header();

$home_url = home_url('/');
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
?>


<section class="coming-soon-section">
    <div class="container">
        <div class="coming-soon-card">
            <div class="coming-soon-icon">
                <i class="fas fa-rocket"></i>
            </div>
            <div class="coming-soon-badge">COMING SOON</div>
            <h2 class="coming-soon-title">We're Preparing Something Special</h2>
            <p class="coming-soon-text">Our team is currently documenting real-world case studies from across industries
                — detailed breakdowns of the challenges our clients faced and exactly how Eden Infosol solved them.</p>

            <p class="coming-soon-subtext">Stay tuned — this page will be live shortly </p>
            <div class="coming-soon-buttons">
                <a href="<?php echo esc_url($home_url); ?>" class="btn btn-primary"><i class="fas fa-home"></i> Back to
                    Home</a>

            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>