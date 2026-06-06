<?php
/*
Template Name: About Page
*/
if (!defined('ABSPATH'))
    exit;
get_header();

$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
$assess_url = eden_get_page_url('assessment', home_url('/assessment/'));
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="section-label">ABOUT US</span>
        <h1>The People &amp; Purpose Behind Eden Infosol</h1>
        <p>A company built on trust, expertise, and an unwavering commitment to our clients' long-term success.</p>
    </div>
</section>

<!-- ===== OUR STORY - TWO COLUMN WITH COMPANY PHOTO ===== -->
<section class="story-section">
    <div class="container">
        <div class="about-grid">

            <div class="about-text fade-in">
                <span class="section-label">OUR STORY</span>
                <h2 class="section-title">From a Vision to a Trusted Partner</h2>
                <p>Eden Infosol was founded with a singular purpose, to create a technology partner that businesses can
                    genuinely trust. A partner that takes full ownership of your technology challenges and delivers
                    outcomes that genuinely matter to your business.</p>
                <p>What began as a focused IT infrastructure consultancy has grown over 15 years into a comprehensive
                    full-stack technology company. We've built deep partnerships with the world's leading technology
                    vendors, earned industry certifications across every major domain, and assembled a team of engineers
                    and consultants who bring both technical depth and business understanding to every engagement.</p>
                <p>Today, Eden Infosol serves enterprises, mid-market businesses and SMEs across India, covering
                    everything from hardware procurement and infrastructure deployment to cloud migration, managed
                    security operations and compliance audits. One partner. End-to-end capability.</p>
            </div>

            <div class="about-image fade-in">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/Eden_Family.jpg'); ?>"
                    alt="Eden Infosol Team">
            </div>

        </div>
    </div>
</section>

<!-- ===== FOUNDERS - BLUR REVEAL CARDS ===== -->
<section class="founders-section" id="founders">
    <div class="container">
        <div class="section-header center fade-in">
            <span class="section-label">OUR FOUNDERS</span>
            <h2 class="section-title">Leadership that Leads by Example</h2>
        </div>

        <div class="founders-reveal-grid">



            <!-- Founder 2: Hiren -->
            <div class="founder-reveal-card fade-in">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hiren-sheth.png'); ?>"
                    alt="Hiren Sheth" class="founder-reveal-photo">

                <div class="founder-reveal-overlay"></div>

                <div class="founder-reveal-info">
                    <h3>Hiren Sheth</h3>
                    <span>Co-Founder & Director</span>
                </div>

                <div class="founder-reveal-details">
                    <div class="founder-reveal-details-inner">
                        <h3>Hiren Sheth</h3>
                        <div class="founder-reveal-title">Co-Founder & Director</div>
                        <p>Hiren co-founded Eden Infosol with a conviction that clients deserve a technology partner
                            they can rely on completely. With over 25 years of experience in IT infrastructure, hardware
                            ecosystems and client business management, he is the force that keeps Eden grounded in what
                            matters most, execution. His ability to understand what clients need and turn that into
                            lasting partnerships is what drives Eden's sales engine. His operational rigour, commercial
                            sharpness and unwavering accountability have been central to Eden's exceptional client
                            retention and reputation.</p>
                        <a href="mailto:hiren.sheth@edeninfosol.com" class="founder-reveal-email"><i
                                class="fas fa-envelope"></i> hiren.sheth@edeninfosol.com</a>
                    </div>
                </div>
            </div>

            <!-- Founder 1: Romil -->
            <div class="founder-reveal-card fade-in">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/romil.png'); ?>"
                    alt="Romil Sheth" class="founder-reveal-photo">

                <div class="founder-reveal-overlay"></div>

                <div class="founder-reveal-info">
                    <h3>Romil Sheth</h3>
                    <span>Co-Founder & Director</span>
                </div>

                <div class="founder-reveal-details">
                    <div class="founder-reveal-details-inner">
                        <h3>Romil Sheth</h3>
                        <div class="founder-reveal-title">Co-Founder & Director</div>
                        <p>
                            With over 25 years of entrepreneurial experience, Romil brings a powerful combination of
                            deep technical expertise, sharp analytical thinking, and strong business acumen to every
                            challenge. His hands-on understanding of enterprise IT spanning infrastructure,
                            cybersecurity, cloud ecosystems, and managed services, enables him to architect solutions
                            that solve real business problems and deliver measurable outcomes. Romil's consultative
                            approach, commitment to building lasting client relationships, and relentless focus on value
                            creation have been the driving force behind Eden's sustained growth, strong client
                            retention, and reputation as a trusted technology partner.
                        </p>
                        <a href="mailto:romil.sheth@edeninfosol.com" class="founder-reveal-email"><i
                                class="fas fa-envelope"></i> romil.sheth@edeninfosol.com</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== VISION & MISSION ===== -->
<section class="vm-section section-light" id="vision-mission">
    <div class="container">
        <div class="section-header center fade-in">
            <span class="section-label">OUR DIRECTION</span>
            <h2 class="section-title">Vision &amp; Mission</h2>
        </div>

        <div class="vm-grid">
            <div class="vm-card fade-in">
                <h3>Our Vision</h3>
                <div class="vm-tagline">To be the most trusted technology partner for businesses navigating the digital
                    era.</div>
                <p>We envision a future where every organisation, regardless of size, has access to world-class IT
                    capabilities that enable them to compete, innovate and grow with confidence.</p>
            </div>

            <div class="vm-card fade-in">
                <h3>Our Mission</h3>
                <div class="vm-tagline">Delivering technology solutions that are secure, scalable, and aligned to
                    business outcomes.</div>
                <p>We are committed to understanding our clients' unique challenges and providing honest, expert
                    guidance that translates complex technology into measurable business value, with clarity, honesty
                    and a focus on long-term value.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== WHY CLIENTS TRUST US ===== -->
<section class="trust-section" id="why-us">
    <div class="container">
        <div class="section-header center fade-in">
            <span class="section-label">WHY CHOOSE EDEN INFOSOL</span>
            <h2 class="section-title">Why Clients Trust Us</h2>
        </div>

        <div class="trust-grid">
            <div class="trust-card fade-in">
                <div class="trust-number">01</div>
                <div class="trust-card-content">
                    <h4>Vendor-Agnostic Expertise</h4>
                    <p>We recommend what's right for your business, not what's most profitable for us, always and
                        without exception.</p>
                </div>
            </div>
            <div class="trust-card fade-in">
                <div class="trust-number">02</div>
                <div class="trust-card-content">
                    <h4>End-to-End Accountability</h4>
                    <p>From design through implementation to ongoing support, we own the entire journey alongside you.
                    </p>
                </div>
            </div>
            <div class="trust-card fade-in">
                <div class="trust-number">03</div>
                <div class="trust-card-content">
                    <h4>Certified Deep Expertise</h4>
                    <p>Our engineers hold industry certifications across every major platform and technology domain we
                        operate in.</p>
                </div>
            </div>
            <div class="trust-card fade-in">
                <div class="trust-number">04</div>
                <div class="trust-card-content">
                    <h4>Proven Track Record</h4>
                    <p>16 years in business. A client retention record that speaks louder than any claim.</p>
                </div>
            </div>
            <div class="trust-card fade-in">
                <div class="trust-number">05</div>
                <div class="trust-card-content">
                    <h4>SLA-Backed Commitments</h4>
                    <p>Every engagement comes with clear SLAs and a support structure built around genuine
                        accountability.</p>
                </div>
            </div>
            <div class="trust-card fade-in">
                <div class="trust-number">06</div>
                <div class="trust-card-content">
                    <h4>Local Presence, Global Standards</h4>
                    <p>Mumbai-based with regional reach, combining on-ground responsiveness with international best
                        practices.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content fade-in">
            <h2>Ready to Transform Your IT?</h2>
            <p>Let's discuss how Eden Infosol can help you build, secure and manage your technology environment end to
                end.</p>
            <a href="<?php echo esc_url($assess_url); ?>" class="btn btn-primary">Get Your Assessment</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>