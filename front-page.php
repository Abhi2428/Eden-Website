<?php
/*
Template Name: Front Page
*/
if (!defined('ABSPATH'))
    exit;
get_header();

$products_url = eden_get_page_url('products', home_url('/products/'));
$about_url = eden_get_page_url('about', home_url('/about/'));
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
$bytes_url = eden_get_page_url('eden-bytes', home_url('/eden-bytes/'));
$assess_url = eden_get_page_url('assessment', home_url('/assessment/'));
$founded = new DateTime('2011-01-01');
$now = new DateTime();
?>

<!-- ===== HERO WITH OPTIMIZED VIDEO ===== -->
<section class="hero hero-video-section" id="edenHero">


    <div class="hero-video-wrap" id="hero-video-wrap">
        <!-- Poster loads instantly — video injected by JS after page load -->
        <picture class="hero-poster-picture">
            <source media="(max-width: 768px)"
                srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-poster-mobile.webp"
                type="image/webp">
            <source srcset="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-poster.webp"
                type="image/webp">
            <img class="hero-poster"
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-poster.jpg"
                alt="Eden Infosol IT Infrastructure & Cybersecurity Solutions" width="1920" height="1080"
                fetchpriority="high" decoding="async">
        </picture>
        <div class="hero-video-overlay"></div>
    </div>

    <div class="hero-content">
        <h1>Transforming Vision Into <span class="highlight">Solutions</span></h1>
        <p>From infrastructure and connectivity to cloud, through cybersecurity and managed services,
            We help businesses design, deploy, secure and manage their entire IT environment. One trusted partner.
            End-to-end capability.</p>
        <div class="hero-buttons">
            <a href="<?php echo esc_url($contact_url . '?interest=consultation'); ?>" class="btn btn-primary">Book a
                Free Consultation</a>
            <a href="<?php echo esc_url($products_url); ?>" class="btn btn-secondary">Explore Our Services</a>
        </div>
    </div>
</section>
<section class="section section-white" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-text anim anim-left">
                <span class="section-label">THE EDEN STORY</span>
                <h2 class="section-title">Who We Are</h2>
                <p>Eden Infosol is a full-spectrum technology solutions company serving
                    enterprises, mid-market businesses, and SMEs across industries.</p>
                <p>We go beyond selling hardware. From servers, networking, storage, and end-user devices to complete IT
                    environment design, we combine the dependability of a trusted technology vendor with the strategic
                    depth of a solutions partner.</p>
                <p>Whether you're modernising your infrastructure, migrating to the cloud, strengthening your
                    cybersecurity posture, or looking for a partner to manage it all, Eden brings the expertise, OEM
                    partnerships, and delivery muscle to make it happen and keep it running.</p>
                <p>We work with the people who make the decisions: CIOs, CISOs, IT Managers, Procurement Heads, and
                    Compliance Officers. Leaders who need a partner they can rely on for both everyday technology
                    procurement and their most mission-critical IT investments.</p>
            </div>
            <div class="about-image anim anim-right">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/leaders.png'); ?>"
                    alt="Eden Infosol Leadership Team">
            </div>
        </div>

        <div class="stats-grid stagger-children">
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-number" data-target="<?php
                $founded = new DateTime('2010-05-08');
                $now = new DateTime();
                echo $now->diff($founded)->y . '+';
                ?>+">
                    <?php
                    $founded = new DateTime('2010-05-08');
                    $now = new DateTime();
                    echo $now->diff($founded)->y . '+';
                    ?>
                </div>
                <div class="stat-label">Years of Experience</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-handshake"></i></div>
                <div class="stat-number" data-target="500+">1000+</div>
                <div class="stat-label">Clients Served</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-certificate"></i></div>
                <div class="stat-number" data-target="10+">20+</div>
                <div class="stat-label">Technology Partners</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number" data-target="1000+">45+</div>
                <div class="stat-label">Team Members</div>
            </div>
        </div>
    </div>
</section>

<section class="trust-bar section-light">
    <div class="container">
        <div class="section-header center anim anim-up">
            <span class="section-label">WHO WE WORK WITH</span>
            <h2 class="section-title">Backed by the World's Leading Technology Brands</h2>
            <p class="section-subtitle">We are certified partners and authorised resellers for industry-leading OEMs,
                Cloud platforms and Cybersecurity vendors.</p>
        </div>
    </div>
    <div class="trust-track-wrapper">
        <div class="trust-track">
            <?php
            $logos = array(
                'dell' => 'Dell',
                'kaspersky' => 'Kaspersky',
                'bitdefender' => 'Bitdefender',
                'aws' => 'AWS',
                'microsoft' => 'Microsoft',
                'hp' => 'HP',
                'cisco' => 'Cisco',
                'acronis' => 'Acronis',
                'checkpoint' => 'Check Point',
                'sonicwall' => 'SonicWall',
                'fortinet' => 'Fortinet',
            );
            for ($i = 0; $i < 2; $i++):
                foreach ($logos as $file => $name): ?>
                    <div class="trust-item trust-item-logo">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/' . $file . '.png'); ?>"
                            alt="<?php echo esc_attr($name); ?>">
                    </div>
                <?php endforeach;
            endfor; ?>
        </div>
    </div>
</section>

<section class="pillars">
    <div class="container">
        <div class="section-header center anim anim-up">
            <span class="section-label">CORE CAPABILITIES</span>
            <h2 class="section-title">What We Do</h2>
            <p class="section-subtitle">Our capabilities span the full technology lifecycle, from connecting your
                business to protecting and managing it every day.</p>
        </div>
        <div class="pillars-grid stagger-children">

            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-satellite-dish"></i></div>
                <h3>Connectivity & Digital Transformation</h3>
                <div class="pillar-tagline">Communicate smarter. Stay connected.</div>
                <p>From enterprise-grade ILL, P2P links and SD-WAN to WhatsApp Business APIs and Digital Transformation
                    platforms, we keep your
                    business connected to customers and branches alike, with reliability built in.</p>
                <a href="<?php echo esc_url($products_url . '#digital-connectivity'); ?>" class="pillar-link">Explore
                    Digital & Connectivity <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-server"></i></div>
                <h3>IT Infrastructure</h3>
                <div class="pillar-tagline">Build the foundation your business runs on.</div>
                <p>Your business is only as strong as the infrastructure beneath it. We design, supply and deploy
                    servers, storage, networking, virtualization and end-user computing environments that are built to
                    last, built to scale and built around your specific needs.</p>
                <a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>" class="pillar-link">Explore IT
                    Infrastructure <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-shield-halved"></i></div>
                <h3>Cybersecurity</h3>
                <div class="pillar-tagline">Protect what matters most.</div>
                <p>Layered security across your endpoints, identities, networks, applications and data, backed by SOC
                    monitoring and SIEM, so threats are detected, contained and neutralised before they become crises.
                </p>
                <a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>" class="pillar-link">Explore
                    Cybersecurity <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-cloud"></i></div>
                <h3>Cloud & Data Center</h3>
                <div class="pillar-tagline">Move to the cloud. Confidently.</div>
                <p>From public cloud on Azure and AWS to private, hybrid and co-location environments, we help you
                    migrate, modernise and manage your cloud infrastructure with security and cost-efficiency at the
                    core.</p>
                <a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>" class="pillar-link">Explore Cloud
                    & Data Center <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-headset"></i></div>
                <h3>Professional Services</h3>
                <div class="pillar-tagline">Run your technology. We'll manage it.</div>
                <p>From managed infrastructure and cloud to managed security and full IT operations, our team becomes an
                    extension of yours, so you can focus on business outcomes while we keep the technology running.</p>
                <a href="<?php echo esc_url($products_url . '#managed-services'); ?>" class="pillar-link">Explore
                    Managed Services <i class="fas fa-arrow-right"></i></a>
            </div>

        </div>
    </div>
</section>
<section class="testimonials section-light">
    <div class="container">
        <div class="section-header center anim anim-up">
            <span class="section-label">CLIENT STORIES</span>
            <h2 class="section-title">What Our Clients Say</h2>
            <p class="section-subtitle">Trusted by enterprises and growing businesses across industries.</p>
        </div>
        <div class="testimonial-slider">
            <button class="testimonial-btn testimonial-prev" aria-label="Previous"><i
                    class="fas fa-chevron-left"></i></button>

            <div class="testimonial-viewport">
                <div class="testimonial-track">

                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"Eden Infosol designed a robust backup and disaster recovery
                                strategy for us that ensures our data is always protected. Knowing that our systems can
                                be restored quickly in case of any disruption has significantly improved our business
                                confidence and continuity planning."</p>
                            <div class="testimonial-author">Head of IT</div>
                            <div class="testimonial-role">Investment Management Company</div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"Eden Infosol's strength lies in their ability to integrate
                                multiple technologies seamlessly—networking, cloud, security, and endpoints. We no
                                longer deal with multiple vendors; they handle it all end-to-end."</p>
                            <div class="testimonial-author">Operations Head</div>
                            <div class="testimonial-role">SME Enterprise</div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"We were struggling with unpredictable IT costs. With Eden's
                                managed services, everything is now structured and budget-friendly without compromising
                                on quality or response time."</p>
                            <div class="testimonial-author">Founder</div>
                            <div class="testimonial-role">Fast-Growing Startup</div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"Their SOC and monitoring services give us real-time visibility
                                into threats. We now receive actionable alerts instead of noise, which helps our
                                internal team focus on what truly matters."</p>
                            <div class="testimonial-author">CISO</div>
                            <div class="testimonial-role">NBFC (Non-Banking Financial Company)</div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"Eden Infosol designed a robust backup and disaster recovery
                                strategy for us that ensures our data is always protected. Knowing that our systems can
                                be restored quickly in case of any disruption has significantly improved our business
                                confidence and continuity planning."</p>
                            <div class="testimonial-author">VP</div>
                            <div class="testimonial-role">Technology, Wealth Management Firm</div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-card-inner">
                            <p class="testimonial-text">"We operate across multiple locations, and managing IT used to
                                be chaotic. Eden brought control, visibility, and security under one roof. Their
                                centralized monitoring solution and proactive support have significantly reduced our IT
                                incidents."</p>
                            <div class="testimonial-author">IT Manager</div>
                            <div class="testimonial-role">Retail Firm</div>
                        </div>
                    </div>

                    <!-- ADD MORE TESTIMONIALS HERE - just copy a card block above -->

                </div>
            </div>

            <button class="testimonial-btn testimonial-next" aria-label="Next"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>
<section class="cta-section">
    <div class="container">
        <div class="cta-content anim anim-scale">
            <h2>Ready to Transform Your IT?</h2>
            <p>Let's discuss how Eden Infosol can help you build, secure and manage your technology environment end to
                end.</p>
            <a href="<?php echo esc_url($assess_url); ?>" class="btn btn-primary">Get Your Assessment</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>