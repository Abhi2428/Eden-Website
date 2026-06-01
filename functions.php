<?php
if (!defined('ABSPATH')) exit;

function eden_infosol_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('menus');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'eden-infosol'),
    ));
}
add_action('after_setup_theme', 'eden_infosol_theme_setup');

function eden_infosol_enqueue_assets() {
    wp_enqueue_style(
        'eden-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_template_directory() . '/style.css')
    );

    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    if (file_exists(get_template_directory() . '/script.js')) {
        wp_enqueue_script(
            'eden-script',
            get_template_directory_uri() . '/script.js',
            array(),
            filemtime(get_template_directory() . '/script.js'),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'eden_infosol_enqueue_assets');

/**
 * Helper: Get page URL by slug with fallback.
 */
function eden_get_page_url($slug, $fallback = '#') {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page->ID) : $fallback;
}
function eden_expandable_cards_js() {
    wp_enqueue_script(
        'expandable-cards',
        get_template_directory_uri() . '/expandable-cards.js',
        array(),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'eden_expandable_cards_js');



function eden_scroll_animations_js() {
    wp_enqueue_script(
        'scroll-animations',
        get_template_directory_uri() . '/scroll-animations.js',
        array(),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'eden_scroll_animations_js');

/**
 * Contact form handler
 */
function eden_contact_form_submit() {
    if (
        !isset($_POST['eden_contact_nonce']) ||
        !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['eden_contact_nonce'])), 'eden_contact_form_submit')
    ) {
        wp_safe_redirect(home_url('/contact-us/?eden_contact=error'));
        exit;
    }

    $first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
    $last_name  = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
    $email      = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone      = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $company    = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
    $interest   = isset($_POST['interest']) ? sanitize_text_field(wp_unslash($_POST['interest'])) : '';
    $message    = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';

    if (empty($first_name) || empty($last_name) || empty($email) || empty($message) || !is_email($email)) {
        wp_safe_redirect(home_url('/contact-us/?eden_contact=invalid'));
        exit;
    }

    $to      = get_option('admin_email');
    $subject = 'New Contact Form Submission - Eden Infosol';

    $body  = "A new contact enquiry was submitted.\n\n";
    $body .= "First Name: {$first_name}\n";
    $body .= "Last Name: {$last_name}\n";
    $body .= "Email: {$email}\n";
    $body .= "Phone: {$phone}\n";
    $body .= "Company: {$company}\n";
    $body .= "Area of Interest: {$interest}\n\n";
    $body .= "Message:\n{$message}\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>',
    );

    $sent = wp_mail($to, $subject, $body, $headers);

    if ($sent) {
        wp_safe_redirect(home_url('/contact-us/?eden_contact=success'));
    } else {
        wp_safe_redirect(home_url('/contact-us/?eden_contact=error'));
    }
    exit;
}
add_action('admin_post_nopriv_eden_contact_form_submit', 'eden_contact_form_submit');
add_action('admin_post_eden_contact_form_submit', 'eden_contact_form_submit');
?>