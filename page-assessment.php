<?php
/**
 * Template Name: Assessment
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
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="coming-soon-badge">COMING SOON</div>
            <h2 class="coming-soon-title">Our Assessment Portal is Being Built</h2>
            <p class="coming-soon-text">We're building a self-service portal where you can request a free, no-obligation
                IT assessment. Our team will evaluate your infrastructure, security posture, cloud readiness, and
                operational efficiency — and deliver a detailed report with actionable recommendations.</p>
            <div class="coming-soon-features">
                <div class="cs-feature">
                    <i class="fas fa-server"></i>
                    <span>Infrastructure Review</span>
                </div>
                <div class="cs-feature">
                    <i class="fas fa-shield-halved"></i>
                    <span>Security Assessment</span>
                </div>
                <div class="cs-feature">
                    <i class="fas fa-cloud"></i>
                    <span>Cloud Readiness</span>
                </div>
            </div>
            <p class="coming-soon-subtext">In the meantime, you can reach out to us directly and we'll schedule your
                assessment personally.</p>
            <div class="coming-soon-buttons">
                <a href="<?php echo esc_url($home_url); ?>" class="btn btn-primary">Back to Home</a>
                <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>