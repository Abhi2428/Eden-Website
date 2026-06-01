<?php
/*
Template Name: Contact Page
*/
if (!defined('ABSPATH')) exit;

get_header();

$status = isset($_GET['eden_contact']) ? sanitize_text_field(wp_unslash($_GET['eden_contact'])) : '';
?>

<section class="contact-page">
    <div class="container">
        <div class="contact-layout">

            <!-- LEFT SIDE -->
            <div class="contact-left fade-in">
                <h1>Get in Touch</h1>
                <p class="intro">Reach us through any channel below — we're always happy to help.</p>

                <div class="contact-info-list">
                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <small>Phone</small>
                            <p>+91 XXXXX XXXXX</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <small>Email</small>
                            <p>info@edeninfosol.com</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <small>Address</small>
                            <p>Mumbai, Maharashtra, India</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <small>Business Hours</small>
                            <p>Mon – Sat: 9:00 AM – 7:00 PM IST</p>
                        </div>
                    </div>
                </div>

                <div class="emergency-box fade-in">
                    <h3>Emergency Support</h3>
                    <p>For critical incidents outside business hours, our 24/7 emergency line is available to all managed services clients.</p>
                    <div class="hotline">+91 XXXXXX XXXXXX</div>
                </div>
            </div>

            <!-- RIGHT SIDE FORM -->
            <div class="contact-form-card fade-in">
                <h2>Send Us a Message</h2>
                <p class="form-copy">Fill in the form and we'll get back to you within one business day.</p>

                <?php if ($status === 'success') : ?>
                    <div class="contact-form-notice success">
                        Thank you — your message has been sent successfully.
                    </div>
                <?php elseif ($status === 'error') : ?>
                    <div class="contact-form-notice error">
                        Something went wrong while sending your message. Please try again.
                    </div>
                <?php elseif ($status === 'invalid') : ?>
                    <div class="contact-form-notice error">
                        Please fill in all required fields correctly.
                    </div>
                <?php endif; ?>

                <form class="contact-form-grid" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="eden_contact_form_submit">
                    <?php wp_nonce_field('eden_contact_form_submit', 'eden_contact_nonce'); ?>

                    <div class="contact-form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="John" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Doe" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="john@company.com" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="+91 XXXXX XXXXX">
                    </div>

                    <div class="contact-form-group full">
                        <label for="company">Company Name</label>
                        <input type="text" id="company" name="company" placeholder="Your Organisation">
                    </div>

                    <div class="contact-form-group full">
                        <label for="interest">Area of Interest</label>
                        <select id="interest" name="interest">
                            <option value="General Enquiry">General Enquiry</option>
                            <option value="IT Infrastructure">IT Infrastructure</option>
                            <option value="Cloud & Data Center">Cloud & Data Center</option>
                            <option value="Cybersecurity">Cybersecurity</option>
                            <option value="Managed Services">Managed Services</option>
                            <option value="Connectivity & Voice">Connectivity & Voice</option>
                            <option value="Audits & Compliance">Audits & Compliance</option>
                            <option value="Digital Solutions">Digital Solutions</option>
                        </select>
                    </div>

                    <div class="contact-form-group full">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" placeholder="Tell us about your requirements or challenge..." required></textarea>
                    </div>

                    <div class="contact-submit">
                        <button type="submit" class="btn btn-primary">Send Message <i class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>