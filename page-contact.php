<?php
/**
 * Template Name: Contact Us
 */
if (!defined('ABSPATH'))
    exit;
get_header();
?>

<section class="contact-page">
    <div class="container">
        <div class="contact-layout">

            <!-- LEFT COLUMN -->
            <div class="contact-left">
                <h1>Get in Touch</h1>
                <p class="intro">Reach us through any channel below — we're always happy to help.</p>

                <div class="contact-info-list">
                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <small>Phone</small>
                            <p>+91 90290 55465</p>
                        </div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <small>Email</small>
                            <p>info@edeninfosol.com</p>
                        </div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <small>Address</small>
                            <p>Mumbai, Maharashtra, India</p>
                        </div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <small>Business Hours</small>
                            <p>Mon – Fri: 9:30 AM – 6:30 PM IST</p>
                        </div>
                    </div>
                </div>


            </div>

            <!-- RIGHT COLUMN - FORM -->
            <div class="contact-form-card">
                <h2>Send Us a Message</h2>
                <p class="form-copy">Fill in the form and we'll get back to you within one business day.</p>

                <!-- Status messages (hidden by default) -->
                <div id="form-success" class="contact-form-notice success" style="display:none;">
                    ✅ Thank you — your message has been sent successfully!
                </div>
                <div id="form-error" class="contact-form-notice error" style="display:none;">
                    ❌ Something went wrong. Please try again.
                </div>

                <form id="eden-contact-form" class="contact-form-grid" novalidate>
                    <?php wp_nonce_field('eden_contact_nonce', 'eden_nonce'); ?>

                    <div class="contact-form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="company">Company Name *</label>
                        <input type="text" id="company" name="company" required>
                    </div>

                    <div class="contact-form-group">
                        <label for="interest">Area of Interest *</label>
                        <select id="interest" name="interest">
                            <option value="Book a Free Consultation">Book a Free Consultation</option>
                            <option value="General Enquiry">General Enquiry</option>
                            <option value="IT Infrastructure">IT Infrastructure</option>
                            <option value="Cloud & Data Center">Cloud & Data Center</option>
                            <option value="Cybersecurity">Cybersecurity</option>
                            <option value="Managed Services">Managed Services</option>
                            <option value="Connectivity & Digital">Connectivity & Digital Transformation</option>
                        </select>
                    </div>

                    <div class="contact-form-group full">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <div class="contact-submit">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <span id="btn-text">Send Message</span>
                            <span id="btn-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i>
                                Sending...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<script>
    (function () {
        var params = new URLSearchParams(window.location.search);
        if (params.get('interest') === 'consultation') {
            var select = document.getElementById('interest');
            if (select) {
                select.value = 'Book a Free Consultation';
            }
        }
    })();
</script>

<?php get_footer(); ?>