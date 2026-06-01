<?php
if (!defined('ABSPATH')) exit;
get_header();

$products_url = eden_get_page_url('products', home_url('/products/'));
$contact_url  = eden_get_page_url('contact-us', home_url('/contact-us/'));

$hero_title       = get_field('hero_title');
$hero_highlight   = get_field('hero_highlight');
$hero_description = get_field('hero_description');
$hero_video       = get_field('hero_video');
$btn1_text        = get_field('hero_btn1_text');
$btn1_link        = get_field('hero_btn1_link');
$btn2_text        = get_field('hero_btn2_text');
$btn2_link        = get_field('hero_btn2_link');
?>

<section class="hero hero-video-section">
    <div class="hero-video-wrap">
        <?php if ($hero_video) : ?>
            <video class="hero-bg-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
            </video>
        <?php else : ?>
            <div class="hero-fallback"></div>
        <?php endif; ?>
        <div class="hero-video-overlay"></div>
    </div>
    <div class="hero-content">
        <h1 class="hero-anim">
            <?php echo esc_html($hero_title); ?>
            <span class="highlight"><?php echo esc_html($hero_highlight); ?></span>
        </h1>
        <p class="hero-anim"><?php echo esc_html($hero_description); ?></p>
        <div class="hero-buttons hero-anim">
            <?php if ($btn1_text && $btn1_link) : ?>
                <a href="<?php echo esc_url($btn1_link); ?>" class="btn btn-primary"><?php echo esc_html($btn1_text); ?></a>
            <?php endif; ?>
            <?php if ($btn2_text && $btn2_link) : ?>
                <a href="<?php echo esc_url($btn2_link); ?>" class="btn btn-secondary"><?php echo esc_html($btn2_text); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section section-white" id="about">
    <div class="container">
        <div class="about-grid">
            <div class="about-text anim anim-left">
                <span class="section-label">THE EDEN STORY</span>
                <h2 class="section-title">Who We Are</h2>
                <p class="section-subtitle">Eden is a full-spectrum technology solutions company serving enterprises, mid-market businesses and SMEs across industries. From supplying and deploying the right hardware to designing complete IT environments, we combine the reliability of a trusted technology vendor with the strategic capability of a solutions partner.</p>
                <p>Whether you need servers, networking equipment, storage or end-user devices, or you're looking to migrate to the cloud, strengthen your cybersecurity posture or run your technology through managed services — Eden brings the expertise, partnerships and delivery capability to get it done, and keep it running.</p>
                <p>We work with decision-makers — CIOs, CISOs, IT Managers, Procurement Heads and Compliance Officers — who need a partner they can trust with both their day-to-day technology procurement and their most critical IT decisions.</p>
            </div>
            <div class="about-image anim anim-right">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/leaders.png'); ?>" alt="Eden Infosol Leadership Team">
            </div>
        </div>

        <div class="stats-grid stagger-children">
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-number" data-target="15+">15+</div>
                <div class="stat-label">Years of Experience</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-handshake"></i></div>
                <div class="stat-number" data-target="500+">500+</div>
                <div class="stat-label">Clients Served</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-certificate"></i></div>
                <div class="stat-number" data-target="10+">10+</div>
                <div class="stat-label">Technology Partners</div>
            </div>
            <div class="stat-card anim anim-up">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number" data-target="1000+">1000+</div>
                <div class="stat-label">Solutions Delivered</div>
            </div>
        </div>
    </div>
</section>

<section class="trust-bar section-light">
    <div class="container">
        <div class="section-header center anim anim-up">
            <span class="section-label">WHO WE WORK WITH</span>
            <h2 class="section-title">Backed by the World's Leading Technology Brands</h2>
            <p class="section-subtitle">We are certified partners and authorised resellers for industry-leading OEMs, cloud platforms and security vendors — giving you access to the best technology with expert implementation.</p>
        </div>
    </div>
    <div class="trust-track-wrapper">
        <div class="trust-track">
            <?php
            $logos = array(
                'dell'        => 'Dell',
                'kaspersky'   => 'Kaspersky',
                'bitdefender' => 'Bitdefender',
                'aws'         => 'AWS',
                'microsoft'   => 'Microsoft',
                'hp'          => 'HP',
                'cisco'       => 'Cisco',
                'acronis'     => 'Acronis',
                'checkpoint'  => 'Check Point',
                'sonicwall'   => 'SonicWall',
                'fortinet'    => 'Fortinet',
            );
            for ($i = 0; $i < 2; $i++) :
                foreach ($logos as $file => $name) : ?>
                    <div class="trust-item trust-item-logo">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/' . $file . '.png'); ?>" alt="<?php echo esc_attr($name); ?>">
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
            <p class="section-subtitle">Our capabilities span the full technology lifecycle — from building and connecting your infrastructure to protecting and managing it every day.</p>
        </div>
        <div class="pillars-grid stagger-children">
            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-server"></i></div>
                <h3>IT Infrastructure</h3>
                <div class="pillar-tagline">Build the foundation your business runs on.</div>
                <p>Your business is only as strong as the infrastructure beneath it. We design, supply and deploy servers, storage, networking, virtualization and end-user computing environments that are built to last, built to scale and built around your specific needs.</p>
                <a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>" class="pillar-link">Explore IT Infrastructure <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-cloud"></i></div>
                <h3>Cloud &amp; Data Center</h3>
                <div class="pillar-tagline">Move to the cloud. Confidently.</div>
                <p>From public cloud on Azure and AWS to private, hybrid and co-location environments — we help you migrate, modernise and manage your cloud infrastructure with security and cost-efficiency at the core.</p>
                <a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>" class="pillar-link">Explore Cloud &amp; Data Center <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-shield-halved"></i></div>
                <h3>Cybersecurity</h3>
                <div class="pillar-tagline">Protect what matters most.</div>
                <p>Layered security across your endpoints, identities, networks, applications and data, backed by SOC monitoring and SIEM, so threats are detected, contained and neutralised before they become crises.</p>
                <a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>" class="pillar-link">Explore Cybersecurity <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="pillar-card anim anim-up">
                <div class="pillar-icon"><i class="fas fa-headset"></i></div>
                <h3>Managed Services</h3>
                <div class="pillar-tagline">Run your technology. We'll manage it.</div>
                <p>From managed infrastructure and cloud to managed security and full IT operations, our team becomes an extension of yours — so you can focus on business outcomes while we keep the technology running.</p>
                <a href="<?php echo esc_url($products_url . '#managed-services'); ?>" class="pillar-link">Explore Managed Services <i class="fas fa-arrow-right"></i></a>
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
            <div class="testimonial-track">
                <div class="testimonial-card">
                    <div class="testimonial-card-inner">
                        <p class="testimonial-text">"Eden Infosol transformed our entire IT infrastructure with zero downtime. Their team's deep expertise in server deployment and network design gave us the confidence to scale rapidly. A truly reliable technology partner."</p>
                        <div class="testimonial-author">IT Director</div>
                        <div class="testimonial-role">Enterprise Manufacturing Company</div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-card-inner">
                        <p class="testimonial-text">"Their cybersecurity team identified vulnerabilities we didn't even know existed. From endpoint protection to SOC monitoring, Eden Infosol has given us complete peace of mind. They don't just sell solutions — they genuinely protect our business."</p>
                        <div class="testimonial-author">CISO</div>
                        <div class="testimonial-role">Financial Services Firm</div>
                    </div>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-card-inner">
                        <p class="testimonial-text">"Switching to Eden's managed services was one of the best decisions we made. Our IT operations run seamlessly, costs are predictable, and their response times are exceptional. They truly feel like an extension of our team."</p>
                        <div class="testimonial-author">CIO</div>
                        <div class="testimonial-role">Mid-Market Healthcare Organisation</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-dots">
                <button class="testimonial-dot active" aria-label="Slide 1"></button>
                <button class="testimonial-dot" aria-label="Slide 2"></button>
                <button class="testimonial-dot" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <div class="cta-content anim anim-scale">
            <h2>Ready to Transform Your IT?</h2>
            <p>Let's discuss how Eden Infosol can help you build, secure and manage your technology environment — end to end.</p>
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-primary">Get Your Free Assessment</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>