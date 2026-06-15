<?php
// ===== EDEN INFOSOL - CLEAN MERGED FUNCTIONS.PHP =====
if (!defined('ABSPATH'))
    exit;

// =============================================
// DISABLE GUTENBERG — USE CLASSIC EDITOR
// =============================================
add_filter('use_block_editor_for_post', '__return_false');

// =============================================
// 1. THEME SETUP
// =============================================
function eden_infosol_theme_setup()
{
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

// =============================================
// 2. ENQUEUE STYLES & SCRIPTS + AJAX URL
// =============================================
function eden_infosol_enqueue_assets()
{
    wp_enqueue_style(
        'eden-style',
        get_stylesheet_uri(),
        array(),
        filemtime(get_template_directory() . '/style.css')
    );

    if (file_exists(get_template_directory() . '/script.js')) {
        wp_enqueue_script(
            'eden-script',
            get_template_directory_uri() . '/script.js',
            array(),
            filemtime(get_template_directory() . '/script.js'),
            true
        );

        // Pass AJAX URL to JavaScript (needed for contact form)
        wp_localize_script('eden-script', 'edenAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('eden_assessment_nonce'),
        ));
    }
}
add_action('wp_enqueue_scripts', 'eden_infosol_enqueue_assets');

// =============================================
// 2B. DISABLE ELEMENTOR'S OLD FONT AWESOME
// (We load FA 6 directly in header.php via CDN)
// =============================================
function eden_disable_elementor_fa()
{
    wp_deregister_style('font-awesome');
    wp_dequeue_style('font-awesome');
}
add_action('wp_enqueue_scripts', 'eden_disable_elementor_fa', 999);

add_action('elementor/frontend/after_register_styles', function () {
    foreach (['font-awesome', 'font-awesome-5-all', 'font-awesome-4-shim'] as $style) {
        wp_deregister_style($style);
        wp_dequeue_style($style);
    }
}, 20);

// =============================================
// 3. PAGE URL HELPER
// =============================================
function eden_get_page_url($slug, $fallback = '#')
{
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page->ID) : $fallback;
}

// =============================================
// 4. EXPANDABLE CARDS JS
// =============================================
function eden_expandable_cards_js()
{
    if (file_exists(get_template_directory() . '/expandable-cards.js')) {
        wp_enqueue_script(
            'expandable-cards',
            get_template_directory_uri() . '/expandable-cards.js',
            array(),
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'eden_expandable_cards_js');

// =============================================
// 5. SCROLL ANIMATIONS JS
// =============================================
function eden_scroll_animations_js()
{
    if (file_exists(get_template_directory() . '/scroll-animations.js')) {
        wp_enqueue_script(
            'scroll-animations',
            get_template_directory_uri() . '/scroll-animations.js',
            array(),
            '1.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'eden_scroll_animations_js');

// =============================================
// 6. CREATE CONTACTS DATABASE TABLE
// =============================================
function eden_create_contact_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        company VARCHAR(200),
        interest VARCHAR(200),
        message TEXT NOT NULL,
        submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        ip_address VARCHAR(45),
        is_read TINYINT(1) DEFAULT 0,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'eden_create_contact_table');

function eden_maybe_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_contacts';
    if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) !== $table_name) {
        eden_create_contact_table();
    }
}
add_action('init', 'eden_maybe_create_table');

// =============================================
// 7. CONTACT FORM AJAX HANDLER
// =============================================
function eden_handle_contact_form()
{

    // Security check
    if (!isset($_POST['eden_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['eden_nonce'])), 'eden_contact_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }

    // Sanitize all inputs
    $first_name = isset($_POST['first_name']) ? sanitize_text_field(wp_unslash($_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_text_field(wp_unslash($_POST['last_name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
    $company = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
    $interest = isset($_POST['interest']) ? sanitize_text_field(wp_unslash($_POST['interest'])) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field(wp_unslash($_POST['message'])) : '';
    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : '';

    // Validate required fields
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($company) || empty($interest) || empty($message)) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
        return;
    }
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
        return;
    }

    // ---- SAVE TO DATABASE ----
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_contacts';

    $db_result = $wpdb->insert(
        $table_name,
        array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'interest' => $interest,
            'message' => $message,
            'ip_address' => $ip,
            'submitted_at' => current_time('mysql'),
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    // ---- SEND EMAIL TO EDEN TEAM ----
    // >>> CHANGE THIS TO YOUR EMAIL <<<
    $to = 'abhishek.sheth@edeninfosol.com';

    $subject = 'New Enquiry: ' . $interest . ' - ' . $first_name . ' ' . $last_name;

    $body = "================================\n";
    $body .= "  NEW CONTACT FORM SUBMISSION\n";
    $body .= "  Eden Infosol Website\n";
    $body .= "================================\n\n";
    $body .= "NAME:             " . $first_name . " " . $last_name . "\n";
    $body .= "EMAIL:            " . $email . "\n";
    $body .= "PHONE:            " . $phone . "\n";
    $body .= "COMPANY:          " . $company . "\n";
    $body .= "AREA OF INTEREST: " . $interest . "\n\n";
    $body .= "================================\n";
    $body .= "MESSAGE:\n";
    $body .= "================================\n\n";
    $body .= $message . "\n\n";
    $body .= "================================\n";
    $body .= "Submitted: " . current_time('d M Y, h:i A') . " IST\n";
    $body .= "IP: " . $ip . "\n";
    $body .= "================================\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>',
    );

    wp_mail($to, $subject, $body, $headers);



    // Return response
    if ($db_result !== false) {
        wp_send_json_success(array('message' => 'Thank you! Your message has been sent.'));
    } else {
        wp_send_json_error(array('message' => 'Something went wrong. Please try again.'));
    }
}
add_action('wp_ajax_eden_contact_form', 'eden_handle_contact_form');
add_action('wp_ajax_nopriv_eden_contact_form', 'eden_handle_contact_form');

// =============================================
// 8. ADMIN PAGE - VIEW CONTACT SUBMISSIONS
// =============================================
function eden_contacts_admin_menu()
{
    add_menu_page(
        'Contact Submissions',
        'Contact Leads',
        'manage_options',
        'eden-contacts',
        'eden_contacts_admin_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'eden_contacts_admin_menu');

function eden_contacts_admin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_contacts';

    if (isset($_GET['mark_read'])) {
        $wpdb->update($table_name, array('is_read' => 1), array('id' => intval($_GET['mark_read'])), array('%d'), array('%d'));
    }
    if (isset($_GET['delete_id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['delete_id'])), array('%d'));
        echo '<div class="notice notice-success"><p>Entry deleted.</p></div>';
    }

    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
    $unread = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_read = 0");

    echo '<div class="wrap">';
    echo '<h1>Contact Form Submissions';
    if ($unread > 0) {
        echo ' <span style="background:#d39a06;color:#fff;padding:4px 12px;border-radius:20px;font-size:14px;margin-left:10px;">' . esc_html($unread) . ' new</span>';
    }
    echo '</h1>';

    if (empty($results)) {
        echo '<p>No submissions yet.</p>';
    } else {
        echo '<table class="widefat fixed striped" style="margin-top:20px;">';
        echo '<thead><tr>';
        echo '<th width="4%">#</th>';
        echo '<th width="14%">Name</th>';
        echo '<th width="16%">Email</th>';
        echo '<th width="10%">Phone</th>';
        echo '<th width="12%">Company</th>';
        echo '<th width="12%">Interest</th>';
        echo '<th width="14%">Message</th>';
        echo '<th width="10%">Date</th>';
        echo '<th width="8%">Actions</th>';
        echo '</tr></thead><tbody>';

        foreach ($results as $row) {
            $bg = $row->is_read ? '' : 'background:#fff8e1;font-weight:600;';
            echo '<tr style="' . esc_attr($bg) . '">';
            echo '<td>' . esc_html($row->id) . '</td>';
            echo '<td>' . esc_html($row->first_name . ' ' . $row->last_name) . '</td>';
            echo '<td><a href="mailto:' . esc_attr($row->email) . '">' . esc_html($row->email) . '</a></td>';
            echo '<td>' . esc_html($row->phone) . '</td>';
            echo '<td>' . esc_html($row->company) . '</td>';
            echo '<td>' . esc_html($row->interest) . '</td>';
            echo '<td>' . esc_html(wp_trim_words($row->message, 10)) . '</td>';
            echo '<td>' . esc_html(date('d M Y', strtotime($row->submitted_at))) . '</td>';
            echo '<td>';
            if (!$row->is_read) {
                echo '<a href="' . esc_url(admin_url('admin.php?page=eden-contacts&mark_read=' . $row->id)) . '" title="Mark read">&#128065;</a> ';
            }
            echo '<a href="' . esc_url(admin_url('admin.php?page=eden-contacts&delete_id=' . $row->id)) . '" title="Delete" onclick="return confirm(\'Delete this entry?\');">&#128465;</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '<p style="margin-top:15px;color:#666;">Total: ' . count($results) . ' submissions</p>';
    }
    echo '</div>';

}

// =============================================
// 9. SEO - META TITLE, DESCRIPTION, OG & TWITTER
// =============================================

// 9A. Shorten & customize meta title (50-60 chars)
function eden_custom_document_title($title_parts)
{
    if (is_front_page()) {
        $title_parts['title'] = 'Eden Infosol | IT & Cybersecurity Solutions';
    }
    unset($title_parts['tagline']);
    return $title_parts;
}
add_filter('document_title_parts', 'eden_custom_document_title');

function eden_title_separator($sep)
{
    return '|';
}
add_filter('document_title_separator', 'eden_title_separator');

// 9B. Meta Description, Open Graph, Twitter Cards
function eden_seo_head_tags()
{
    $site_name = 'Eden Infosol';
    $default_image = get_template_directory_uri() . '/assets/logos/logo.png';
    $site_url = home_url('/');

    // Defaults
    $title = get_the_title() . ' | ' . $site_name;
    $description = 'Eden Infosol — Full-spectrum IT solutions for SMBs & enterprises. Infrastructure, cybersecurity, cloud, and managed services. One trusted partner.';
    $url = is_front_page() ? $site_url : get_permalink();
    $type = 'website';

    // Page-specific SEO
    if (is_front_page()) {
        $title = 'Eden Infosol | IT & Cybersecurity Solutions';
        $description = 'Full-spectrum IT solutions for SMBs & enterprises in Mumbai — infrastructure, cybersecurity, cloud, and managed services. One trusted partner.';
    } elseif (is_page('products') || is_page('products-services')) {
        $title = 'Products & Services | Eden Infosol';
        $description = 'Explore our full IT portfolio — connectivity, infrastructure, cybersecurity, cloud & data center, and professional services backed by certified expertise.';
    } elseif (is_page('about')) {
        $title = 'About Us | Eden Infosol';
        $description = '15+ years of IT expertise, vendor-agnostic guidance, and end-to-end technology solutions for businesses across India.';
    } elseif (is_page('contact') || is_page('contact-us')) {
        $title = 'Contact Us | Eden Infosol';
        $description = 'Get in touch with Eden Infosol for IT infrastructure, cybersecurity, cloud, and managed services. Based in Mumbai, serving businesses across India.';
    } elseif (is_page('assessment')) {
        $title = 'Free IT Assessment | Eden Infosol';
        $description = 'Request a free IT assessment from Eden Infosol. Our experts will evaluate your infrastructure, security, and cloud readiness.';
    } elseif (is_page('eden-bytes')) {
        $title = 'Eden Bytes | Eden Infosol';
        $description = 'Insights, case studies, and technology perspectives from the Eden Infosol team.';
    }

    // Meta Description
    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";

    // Open Graph Tags
    echo '<meta property="og:type" content="' . esc_attr($type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($default_image) . '">' . "\n";
    echo '<meta property="og:locale" content="en_IN">' . "\n";

    // Twitter Card Tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($default_image) . '">' . "\n";
}
add_action('wp_head', 'eden_seo_head_tags', 1);

// =============================================
// 10. PERFORMANCE OPTIMIZATIONS
// =============================================

// 10A. Add defer attribute to non-critical scripts
function eden_defer_scripts($tag, $handle, $src)
{
    // Don't defer critical scripts
    $no_defer = array('jquery', 'wp-embed');
    if (in_array($handle, $no_defer)) {
        return $tag;
    }
    // Add defer to all other scripts
    if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'eden_defer_scripts', 10, 3);

// 10B. Remove WordPress emoji scripts (unnecessary bloat)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// 10C. Remove WordPress embed script
function eden_deregister_scripts()
{
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'eden_deregister_scripts');

// 10D. Remove jQuery migrate (not needed for custom theme)
function eden_remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'eden_remove_jquery_migrate');

// =============================================
// 11. SITEMAP.XML GENERATOR (CLEAN)
// =============================================
function eden_generate_sitemap()
{
    $home = home_url('/');

    // Pages to include (only your real pages by slug)
    $include_slugs = array(
        'products',
        'products-services',
        'about',
        'contact-us',
        'contact',
        'assessment',
        'eden-bytes',
    );

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $xml .= '  <url>' . "\n";
    $xml .= '    <loc>' . esc_url($home) . '</loc>' . "\n";
    $xml .= '    <changefreq>weekly</changefreq>' . "\n";
    $xml .= '    <priority>1.0</priority>' . "\n";
    $xml .= '  </url>' . "\n";

    // Only include pages that match our whitelist
    foreach ($include_slugs as $slug) {
        $page = get_page_by_path($slug);
        if (!$page || $page->post_status !== 'publish')
            continue;

        $url = get_permalink($page->ID);

        // Remove /index.php/ if it's still in the URL
        $url = str_replace('/index.php/', '/', $url);

        $modified = get_the_modified_date('Y-m-d', $page->ID);
        $priority = '0.8';

        if (in_array($slug, array('products', 'products-services', 'about', 'contact-us'))) {
            $priority = '0.9';
        }

        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . esc_url($url) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . $modified . '</lastmod>' . "\n";
        $xml .= '    <changefreq>monthly</changefreq>' . "\n";
        $xml .= '    <priority>' . $priority . '</priority>' . "\n";
        $xml .= '  </url>' . "\n";
    }

    $xml .= '</urlset>';

    // Write to root
    $sitemap_path = ABSPATH . 'sitemap.xml';
    file_put_contents($sitemap_path, $xml);
}
add_action('save_post', 'eden_generate_sitemap');
add_action('after_switch_theme', 'eden_generate_sitemap');

// Generate on first visit if missing
function eden_maybe_generate_sitemap()
{
    if (!file_exists(ABSPATH . 'sitemap.xml')) {
        eden_generate_sitemap();
    }
}
add_action('init', 'eden_maybe_generate_sitemap');

// =============================================
// 12. ADD PRELOAD HINTS FOR CRITICAL ASSETS
// =============================================
function eden_resource_hints()
{
    // Preload hero poster image (fixes LCP)
    if (is_front_page()) {
        $poster = get_template_directory_uri() . '/assets/images/hero-poster.jpg';
        echo '<link rel="preload" as="image" href="' . esc_url($poster) . '">' . "\n";
    }

    // Preload main stylesheet
    echo '<link rel="preload" as="style" href="' . esc_url(get_stylesheet_uri()) . '">' . "\n";
}
add_action('wp_head', 'eden_resource_hints', 0);


// =============================================
// 13. CREATE ASSESSMENT DATABASE TABLE
// =============================================
function eden_create_assessment_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_assessments';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id              BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        client_name     VARCHAR(255) NOT NULL DEFAULT '',
        contact_email   VARCHAR(255) NOT NULL DEFAULT '',
        contact_phone   VARCHAR(50)  NOT NULL DEFAULT '',
        form_data       LONGTEXT     NOT NULL,
        risk_score      INT(11)      NOT NULL DEFAULT 0,
        risk_level      VARCHAR(20)  NOT NULL DEFAULT 'Unknown',
        submission_date DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
        status          VARCHAR(20)  NOT NULL DEFAULT 'new',
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'eden_create_assessment_table');

function eden_maybe_create_assessment_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_assessments';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !== $table_name) {
        eden_create_assessment_table();
    }
}
add_action('init', 'eden_maybe_create_assessment_table');


// =============================================
// 14. RISK SCORING ENGINE
// =============================================
function eden_calculate_risk_score($data)
{
    $score = 0;
    $max_score = 0;

    // Endpoint Security features (11 items) — each "no" = 8 risk points
    $security_features = array(
        'sec_antivirus',
        'sec_endpoint_firewall',
        'sec_app_control',
        'sec_device_control',
        'sec_vuln_assessment',
        'sec_patch_mgmt',
        'sec_siem',
        'sec_encryption',
        'sec_edr_xdr',
        'sec_software_control',
        'sec_inventory_tracking',
    );
    foreach ($security_features as $feature) {
        $max_score += 8;
        $val = isset($data[$feature]) ? strtolower(trim($data[$feature])) : 'no';
        if ($val !== 'yes') {
            $score += 8;
        }
    }

    // Backup & DR checks
    $max_score += 6;
    if (empty($data['server_backup_solution']))
        $score += 6;

    $max_score += 6;
    if (empty($data['endpoint_backup_solution']))
        $score += 6;

    $max_score += 8;
    $mfa = isset($data['mfa_sso']) ? strtolower(trim($data['mfa_sso'])) : 'no';
    if ($mfa !== 'yes')
        $score += 8;

    // SSL certificate
    $max_score += 6;
    $ssl = isset($data['ssl_certificate']) ? strtolower(trim($data['ssl_certificate'])) : 'no';
    if ($ssl !== 'yes')
        $score += 6;

    // Dedicated server room
    $max_score += 4;
    $server_room = isset($data['dedicated_server_room']) ? strtolower(trim($data['dedicated_server_room'])) : 'no';
    if ($server_room !== 'yes')
        $score += 4;

    // Fire alarm
    $max_score += 4;
    $fire_alarm = isset($data['fire_alarm_system']) ? strtolower(trim($data['fire_alarm_system'])) : 'no';
    if ($fire_alarm !== 'yes')
        $score += 4;

    // Inhouse IT support
    $max_score += 4;
    $it_support = isset($data['inhouse_it_support']) ? strtolower(trim($data['inhouse_it_support'])) : 'no';
    if ($it_support !== 'yes')
        $score += 4;

    // Firewall
    $max_score += 6;
    if (empty($data['firewalls']))
        $score += 6;

    // Email security
    $max_score += 5;
    if (empty($data['email_security_solution']))
        $score += 5;

    // Determine risk level
    $percentage = ($max_score > 0) ? round(($score / $max_score) * 100) : 0;

    if ($percentage <= 25) {
        $level = 'Low';
    } elseif ($percentage <= 50) {
        $level = 'Medium';
    } elseif ($percentage <= 75) {
        $level = 'High';
    } else {
        $level = 'Critical';
    }

    return array(
        'score' => $score,
        'max_score' => $max_score,
        'percentage' => $percentage,
        'level' => $level,
    );
}


// =============================================
// 15. HANDLE ASSESSMENT FORM (AJAX)
// =============================================
function eden_handle_assessment_form()
{
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'eden_assessment_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Sanitize all form data
    $raw_data = isset($_POST['formData']) ? $_POST['formData'] : array();
    $sanitized = array();
    foreach ($raw_data as $key => $value) {
        if (is_array($value)) {
            $sanitized[sanitize_key($key)] = array_map('sanitize_text_field', $value);
        } else {
            $sanitized[sanitize_key($key)] = sanitize_text_field($value);
        }
    }

    // Extract key fields
    $client_name = isset($sanitized['client_name']) ? $sanitized['client_name'] : '';
    $contact_email = isset($sanitized['contact_email']) ? $sanitized['contact_email'] : '';
    $contact_phone = isset($sanitized['contact_phone']) ? $sanitized['contact_phone'] : '';

    // Validate required
    if (empty($client_name) || empty($contact_email)) {
        wp_send_json_error(array('message' => 'Client Name and Email are required.'));
    }

    // Calculate risk score
    $risk = eden_calculate_risk_score($sanitized);

    // Save to database
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_assessments';
    $inserted = $wpdb->insert($table_name, array(
        'client_name' => $client_name,
        'contact_email' => $contact_email,
        'contact_phone' => $contact_phone,
        'form_data' => wp_json_encode($sanitized),
        'risk_score' => $risk['score'],
        'risk_level' => $risk['level'],
        'submission_date' => current_time('mysql'),
        'status' => 'new',
    ));

    if ($inserted === false) {
        wp_send_json_error(array('message' => 'Database error. Please try again.'));
    }

    $assessment_id = $wpdb->insert_id;

    // Email to Eden team
    $to = 'abhishek.sheth@edeninfosol.com';
    $subject = "New IT Assessment: {$client_name} — Risk: {$risk['level']}";

    $body = "<h2>New IT Infrastructure & Security Assessment</h2>";
    $body .= "<p><strong>Client:</strong> {$client_name}</p>";
    $body .= "<p><strong>Email:</strong> {$contact_email}</p>";
    $body .= "<p><strong>Phone:</strong> {$contact_phone}</p>";
    $body .= "<hr>";
    $body .= "<p><strong>Risk Score:</strong> {$risk['score']} / {$risk['max_score']} ({$risk['percentage']}%)</p>";
    $body .= "<p><strong>Risk Level:</strong> {$risk['level']}</p>";
    $body .= "<hr>";
    $body .= "<p><strong>Employees:</strong> " . ($sanitized['num_employees'] ?? 'N/A') . "</p>";
    $body .= "<p><strong>Locations:</strong> " . ($sanitized['num_locations'] ?? 'N/A') . "</p>";
    $body .= "<p><strong>Assessment ID:</strong> #{$assessment_id}</p>";
    $body .= "<p>View full details in the WordPress admin panel.</p>";

    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);

    // Confirmation email to client
    if (!empty($contact_email) && is_email($contact_email)) {
        $client_subject = "Your IT Assessment Report — Eden Infosol";
        $client_body = "<h2>Thank you, {$client_name}!</h2>";
        $client_body .= "<p>We have received your IT Infrastructure & Security Assessment.</p>";
        $client_body .= "<p><strong>Your Risk Level:</strong> {$risk['level']}</p>";
        $client_body .= "<p><strong>Risk Score:</strong> {$risk['percentage']}%</p>";
        $client_body .= "<p>Our team will review your assessment and reach out within 24 hours with a detailed report and recommendations.</p>";
        $client_body .= "<br><p>Best regards,<br>Eden Infosol Team<br><a href='https://edeninfosol.com'>edeninfosol.com</a></p>";

        wp_mail($contact_email, $client_subject, $client_body, $headers);
    }

    // Return success
    wp_send_json_success(array(
        'message' => 'Assessment submitted successfully!',
        'id' => $assessment_id,
        'risk_score' => $risk['score'],
        'max_score' => $risk['max_score'],
        'percentage' => $risk['percentage'],
        'risk_level' => $risk['level'],
    ));
}
add_action('wp_ajax_eden_submit_assessment', 'eden_handle_assessment_form');
add_action('wp_ajax_nopriv_eden_submit_assessment', 'eden_handle_assessment_form');


// =============================================
// 16. ADMIN PAGE — VIEW ASSESSMENTS
// =============================================
function eden_assessments_admin_menu()
{
    add_menu_page(
        'IT Assessments',
        'IT Assessments',
        'manage_options',
        'eden-assessments',
        'eden_assessments_admin_page',
        'dashicons-shield',
        31
    );
}
add_action('admin_menu', 'eden_assessments_admin_menu');

function eden_assessments_admin_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_assessments';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT 100");

    echo '<div class="wrap">';
    echo '<h1><span class="dashicons dashicons-shield" style="margin-right:8px;"></span>IT Infrastructure & Security Assessments</h1>';
    echo '<p>All client assessments submitted via the website.</p>';
    echo '<table class="widefat fixed striped">';
    echo '<thead><tr>
            <th style="width:50px;">ID</th>
            <th>Client</th>
            <th>Email</th>
            <th>Phone</th>
            <th style="width:100px;">Risk Level</th>
            <th style="width:70px;">Score</th>
            <th style="width:160px;">Date</th>
            <th style="width:80px;">Status</th>
          </tr></thead><tbody>';

    if ($results) {
        foreach ($results as $row) {
            $colors = array(
                'Low' => '#2e7d32',
                'Medium' => '#f57f17',
                'High' => '#e65100',
                'Critical' => '#c62828',
            );
            $color = isset($colors[$row->risk_level]) ? $colors[$row->risk_level] : '#666';
            echo "<tr>
                    <td>#{$row->id}</td>
                    <td><strong>{$row->client_name}</strong></td>
                    <td><a href='mailto:{$row->contact_email}'>{$row->contact_email}</a></td>
                    <td>{$row->contact_phone}</td>
                    <td><span style='color:{$color};font-weight:bold;'>{$row->risk_level}</span></td>
                    <td>{$row->risk_score}</td>
                    <td>" . date('M j, Y g:i A', strtotime($row->submission_date)) . "</td>
                    <td>{$row->status}</td>
                  </tr>";
        }
    } else {
        echo '<tr><td colspan="8">No assessments submitted yet.</td></tr>';
    }
    echo '</tbody></table></div>';
}
