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

    // ─── Mark read action ───
    if (isset($_GET['mark_read'])) {
        $wpdb->update($table_name, array('is_read' => 1), array('id' => intval($_GET['mark_read'])), array('%d'), array('%d'));
    }

    // ─── Delete action ───
    if (isset($_GET['delete_id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['delete_id'])), array('%d'));
        echo '<div class="notice notice-success"><p>Entry deleted.</p></div>';
    }

    // ─── DETAIL VIEW ───
    if (isset($_GET['view_id'])) {
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['view_id'])));
        if (!$row) {
            echo '<div class="wrap"><h1>Submission Not Found</h1><p><a href="' . admin_url('admin.php?page=eden-contacts') . '">&larr; Back to list</a></p></div>';
            return;
        }

        // Auto-mark as read when viewed
        if (!$row->is_read) {
            $wpdb->update($table_name, array('is_read' => 1), array('id' => $row->id), array('%d'), array('%d'));
        }

        echo '<div class="wrap">';

        // Top bar
        echo '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">';
        echo '<div>';
        echo '<h1 style="margin:0;"><span class="dashicons dashicons-email-alt" style="margin-right:8px;color:#d39a06;"></span>Submission #' . $row->id . '</h1>';
        echo '<p style="color:#666;margin:4px 0 0;">Received ' . date('F j, Y \a\t g:i A', strtotime($row->submitted_at)) . '</p>';
        echo '</div>';
        echo '<div style="display:flex;gap:8px;">';
        echo '<a href="' . admin_url('admin.php?page=eden-contacts') . '" class="button">&larr; Back to List</a>';
        echo '<a href="mailto:' . esc_attr($row->email) . '?subject=Re: ' . esc_attr($row->interest) . '" class="button button-primary"><span class="dashicons dashicons-email" style="margin-top:3px;margin-right:4px;"></span> Reply via Email</a>';
        echo '<button onclick="window.print();" class="button"><span class="dashicons dashicons-printer" style="margin-top:3px;margin-right:4px;"></span> Print</button>';
        echo '</div></div>';

        // Contact Info Cards
        echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:28px;">';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;">';
        echo '<div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;font-weight:700;">Contact</div>';
        echo '<div style="font-size:18px;font-weight:700;color:#122c55;margin-bottom:6px;">' . esc_html($row->first_name . ' ' . $row->last_name) . '</div>';
        if ($row->company)
            echo '<div style="color:#666;font-size:14px;">' . esc_html($row->company) . '</div>';
        echo '</div>';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;">';
        echo '<div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;font-weight:700;">Email & Phone</div>';
        echo '<div style="font-size:14px;margin-bottom:4px;"><a href="mailto:' . esc_attr($row->email) . '">' . esc_html($row->email) . '</a></div>';
        echo '<div style="color:#666;font-size:14px;"><a href="tel:' . esc_attr($row->phone) . '" style="color:#666;text-decoration:none;">' . esc_html($row->phone) . '</a></div>';
        echo '</div>';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;">';
        echo '<div style="font-size:12px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;font-weight:700;">Area of Interest</div>';
        echo '<div style="display:inline-block;background:#fff8e1;color:#d39a06;padding:6px 14px;border-radius:20px;font-weight:700;font-size:14px;">' . esc_html($row->interest) . '</div>';
        echo '</div>';

        echo '</div>';

        // FULL MESSAGE
        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:28px;margin-bottom:20px;">';
        echo '<h2 style="margin:0 0 16px;font-size:16px;color:#122c55;display:flex;align-items:center;gap:8px;">';
        echo '<span class="dashicons dashicons-format-chat" style="color:#d39a06;"></span> Full Message';
        echo '</h2>';
        echo '<div style="background:#fafafa;border-left:4px solid #d39a06;padding:18px 22px;border-radius:6px;font-size:15px;line-height:1.7;color:#333;white-space:pre-wrap;word-wrap:break-word;">';
        echo esc_html($row->message);
        echo '</div>';
        echo '</div>';

        // Meta info
        echo '<div style="background:#f9f9f9;border:1px solid #e0e0e0;border-radius:8px;padding:18px;font-size:13px;color:#666;display:flex;gap:24px;flex-wrap:wrap;">';
        echo '<div><strong>Submission ID:</strong> #' . esc_html($row->id) . '</div>';
        echo '<div><strong>IP Address:</strong> ' . esc_html($row->ip_address ?: 'N/A') . '</div>';
        echo '<div><strong>Status:</strong> ' . ($row->is_read ? '✅ Read' : '🆕 New') . '</div>';
        echo '</div>';

        echo '</div>'; // end wrap
        return;
    }

    // ─── LIST VIEW (default) ───
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submitted_at DESC");
    $unread = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE is_read = 0");
    $total = count($results);

    echo '<div class="wrap">';
    echo '<h1 style="display:flex;align-items:center;gap:8px;">';
    echo '<span class="dashicons dashicons-email-alt" style="color:#d39a06;"></span> Contact Form Submissions';
    if ($unread > 0) {
        echo ' <span style="background:#d39a06;color:#fff;padding:4px 12px;border-radius:20px;font-size:14px;margin-left:10px;">' . esc_html($unread) . ' new</span>';
    }
    echo '</h1>';
    echo '<p style="color:#666;">All contact form submissions from your website. Click <strong>View</strong> to see the full message and contact details.</p>';

    if (empty($results)) {
        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:40px;text-align:center;margin-top:20px;">';
        echo '<span class="dashicons dashicons-email-alt" style="font-size:48px;color:#ccc;"></span>';
        echo '<p style="font-size:16px;color:#999;margin-top:16px;">No submissions yet.</p>';
        echo '</div>';
    } else {
        echo '<table class="widefat fixed striped" style="margin-top:20px;">';
        echo '<thead><tr>';
        echo '<th style="width:50px;">ID</th>';
        echo '<th>Name</th>';
        echo '<th>Email</th>';
        echo '<th style="width:130px;">Phone</th>';
        echo '<th>Company</th>';
        echo '<th style="width:140px;">Interest</th>';
        echo '<th style="width:140px;">Date</th>';
        echo '<th style="width:140px;">Actions</th>';
        echo '</tr></thead><tbody>';

        foreach ($results as $row) {
            $bg = $row->is_read ? '' : 'background:#fff8e1;font-weight:600;';
            echo '<tr style="' . esc_attr($bg) . '">';
            echo '<td><strong>#' . esc_html($row->id) . '</strong></td>';
            echo '<td><strong>' . esc_html($row->first_name . ' ' . $row->last_name) . '</strong>' . ($row->is_read ? '' : ' <span style="background:#d39a06;color:#fff;padding:1px 8px;border-radius:10px;font-size:10px;margin-left:4px;">NEW</span>') . '</td>';
            echo '<td><a href="mailto:' . esc_attr($row->email) . '">' . esc_html($row->email) . '</a></td>';
            echo '<td>' . esc_html($row->phone) . '</td>';
            echo '<td>' . esc_html($row->company) . '</td>';
            echo '<td><span style="background:#fff8e1;color:#d39a06;padding:3px 10px;border-radius:12px;font-weight:600;font-size:12px;">' . esc_html($row->interest) . '</span></td>';
            echo '<td>' . esc_html(date('M j, Y g:i A', strtotime($row->submitted_at))) . '</td>';
            echo '<td>';
            echo '<a href="' . esc_url(admin_url('admin.php?page=eden-contacts&view_id=' . $row->id)) . '" class="button button-small" title="View full message">👁 View</a> ';
            echo '<a href="' . esc_url(admin_url('admin.php?page=eden-contacts&delete_id=' . $row->id)) . '" class="button button-small" style="color:#c62828;" title="Delete" onclick="return confirm(\'Delete submission #' . $row->id . '?\');">🗑</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '<p style="margin-top:15px;color:#666;">Total: ' . esc_html($total) . ' submissions';
        if ($unread > 0)
            echo ' (<strong style="color:#d39a06;">' . esc_html($unread) . ' unread</strong>)';
        echo '</p>';
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
    if (is_front_page()) {
        $base = get_template_directory_uri() . '/assets/images/';
        // Mobile WebP preload
        echo '<link rel="preload" as="image" href="' . esc_url($base . 'hero-poster-mobile.webp') . '" type="image/webp" media="(max-width: 768px)" fetchpriority="high">' . "\n";
        // Desktop WebP preload
        echo '<link rel="preload" as="image" href="' . esc_url($base . 'hero-poster.webp') . '" type="image/webp" media="(min-width: 769px)" fetchpriority="high">' . "\n";
    }
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

    // Save to database (risk_score and risk_level kept as defaults for schema compatibility)
    global $wpdb;
    $table_name = $wpdb->prefix . 'eden_assessments';
    $inserted = $wpdb->insert($table_name, array(
        'client_name' => $client_name,
        'contact_email' => $contact_email,
        'contact_phone' => $contact_phone,
        'form_data' => wp_json_encode($sanitized),
        'risk_score' => 0,
        'risk_level' => 'Pending Review',
        'submission_date' => current_time('mysql'),
        'status' => 'new',
    ));

    if ($inserted === false) {
        wp_send_json_error(array('message' => 'Database error. Please try again.'));
    }
    $assessment_id = $wpdb->insert_id;

    // Email to Eden team
    $to = 'abhishek.sheth@edeninfosol.com';
    $subject = "New IT Assessment Submission: {$client_name}";
    $body = "<h2>New IT Infrastructure & Security Assessment</h2>";
    $body .= "<p><strong>Client:</strong> {$client_name}</p>";
    $body .= "<p><strong>Email:</strong> {$contact_email}</p>";
    $body .= "<p><strong>Phone:</strong> {$contact_phone}</p>";
    $body .= "<hr>";
    $body .= "<p><strong>Employees:</strong> " . ($sanitized['num_employees'] ?? 'N/A') . "</p>";
    $body .= "<p><strong>Locations:</strong> " . ($sanitized['num_locations'] ?? 'N/A') . "</p>";
    $body .= "<p><strong>Assessment ID:</strong> #{$assessment_id}</p>";
    $body .= "<p>View full details in the WordPress admin panel.</p>";
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);

    // Confirmation email to client (no risk language)
    if (!empty($contact_email) && is_email($contact_email)) {
        $client_subject = "We've Received Your IT Assessment — Eden Infosol";
        $client_body = "<h2>Thank you, {$client_name}!</h2>";
        $client_body .= "<p>We have received your IT Infrastructure & Security Assessment submission successfully.</p>";
        $client_body .= "<p>Our specialists will carefully analyze your IT structure and reach out to you within <strong>24 hours</strong> with a detailed analysis and tailored recommendations.</p>";
        $client_body .= "<p>If you have any questions in the meantime, feel free to reach us at <a href='mailto:management@edeninfosol.com'>management@edeninfosol.com</a>.</p>";
        $client_body .= "<br><p>Best regards,<br>Eden Infosol Team<br><a href='https://edeninfosol.com'>edeninfosol.com</a></p>";
        wp_mail($contact_email, $client_subject, $client_body, $headers);
    }

    // Return success — no risk fields
    wp_send_json_success(array(
        'message' => 'Assessment submitted successfully!',
        'id' => $assessment_id,
        'client_name' => $client_name,
    ));
}
add_action('wp_ajax_eden_submit_assessment', 'eden_handle_assessment_form');
add_action('wp_ajax_nopriv_eden_submit_assessment', 'eden_handle_assessment_form');



// =============================================
// 16. ADMIN PAGE — VIEW ASSESSMENTS (ENHANCED)
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

    // ─── DELETE ───
    if (isset($_GET['delete_id'])) {
        $wpdb->delete($table_name, array('id' => intval($_GET['delete_id'])), array('%d'));
        echo '<div class="notice notice-success"><p>Assessment deleted.</p></div>';
    }

    // ─── DETAIL VIEW ───
    if (isset($_GET['view_id'])) {
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", intval($_GET['view_id'])));
        if (!$row) {
            echo '<div class="wrap"><h1>Assessment Not Found</h1><p><a href="' . admin_url('admin.php?page=eden-assessments') . '">&larr; Back to list</a></p></div>';
            return;
        }
        $data = json_decode($row->form_data, true);
        if (!$data)
            $data = array();

        // Risk colors
        $risk_colors = array('Low' => '#2e7d32', 'Medium' => '#f57f17', 'High' => '#e65100', 'Critical' => '#c62828');
        $risk_bg = array('Low' => '#e8f5e9', 'Medium' => '#fff8e1', 'High' => '#fff3e0', 'Critical' => '#ffebee');
        $rc = isset($risk_colors[$row->risk_level]) ? $risk_colors[$row->risk_level] : '#666';
        $rb = isset($risk_bg[$row->risk_level]) ? $risk_bg[$row->risk_level] : '#f5f5f5';

        // Helper to get value
        function eden_val($data, $key, $fallback = '—')
        {
            if (!isset($data[$key]))
                return $fallback;
            if (is_array($data[$key]))
                return implode(', ', $data[$key]);
            $v = trim($data[$key]);
            return ($v !== '') ? esc_html($v) : $fallback;
        }

        // Helper to render a section

        function eden_render_section($title, $icon, $fields, $data)
        {
            $has_data = false;
            foreach ($fields as $key => $label) {
                $val = isset($data[$key]) ? (is_array($data[$key]) ? implode(', ', $data[$key]) : trim($data[$key])) : '';
                if ($val !== '') {
                    $has_data = true;
                    break;
                }
            }
            if (!$has_data)
                return;

            echo '<div style="margin-bottom:24px;">';
            echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
            echo '<span class="dashicons ' . $icon . '" style="margin-right:8px;color:#d39a06;"></span>' . $title . '</h3>';
            echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
            $i = 0;
            foreach ($fields as $key => $label) {
                $val = eden_val($data, $key);
                $bg = ($i % 2 === 0) ? '#fff' : '#fafafa';
                echo '<tr style="background:' . $bg . ';">';
                echo '<td style="width:35%;padding:10px 14px;font-weight:600;color:#333;border-bottom:1px solid #eee;">' . $label . '</td>';
                echo '<td style="padding:10px 14px;color:#555;border-bottom:1px solid #eee;">' . $val . '</td>';
                echo '</tr>';
                $i++;
            }
            echo '</table></div>';
        }

        // ─── Helper: Render per-location data ───
        function eden_render_locations($data)
        {
            $loc_count = isset($data['num_locations']) ? intval($data['num_locations']) : (isset($data['_loc_count']) ? intval($data['_loc_count']) : 1);
            if ($loc_count < 1)
                $loc_count = 1;

            for ($i = 0; $i < $loc_count; $i++) {
                $loc_label = isset($data['loc_' . $i . '_name']) && !empty(trim($data['loc_' . $i . '_name']))
                    ? esc_html(trim($data['loc_' . $i . '_name']))
                    : 'Location ' . ($i + 1);

                // Check if this location has ANY data
                $has_any = false;
                foreach ($data as $key => $val) {
                    if (strpos($key, 'loc_' . $i . '_') === 0) {
                        if (is_array($val) ? count($val) : trim((string) $val) !== '') {
                            $has_any = true;
                            break;
                        }
                    }
                }
                if (!$has_any)
                    continue;

                echo '<div style="margin-bottom:32px;border:1px solid #d39a06;border-radius:10px;overflow:hidden;background:#fff;">';
                echo '<div style="background:linear-gradient(135deg, #122c55, #173663);color:#fff;padding:14px 20px;display:flex;align-items:center;gap:12px;">';
                echo '<span class="dashicons dashicons-location" style="color:#d39a06;font-size:24px;width:24px;height:24px;"></span>';
                echo '<h2 style="margin:0;color:#fff;font-size:18px;font-weight:700;">' . $loc_label . '</h2>';
                echo '</div>';
                echo '<div style="padding:24px;">';

                // ─── Basic Info ───
                eden_render_loc_section('Basic Information', 'dashicons-info', array(
                    'name' => 'Location Name',
                    'users' => 'No. of Users',
                    'work_setup' => 'Work Setup',
                ), $data, $i);

                // ─── Connectivity ───
                eden_render_loc_section('Connectivity & WAN', 'dashicons-admin-site-alt3', array(
                    'num_internet' => 'Internet Connections',
                    'num_p2p' => 'P2P Leased Lines',
                    'num_leased' => 'Leased Lines',
                ), $data, $i);

                // ─── Internet dynamic rows ───
                eden_render_dynamic_rows('Internet Connection Details', array(
                    'isp' => 'ISP',
                    'bw' => 'Bandwidth',
                    'type' => 'Type'
                ), $data, $i, 'internet');

                // ─── P2P dynamic rows ───
                eden_render_dynamic_rows('P2P Line Details', array(
                    'point_a' => 'Point A',
                    'point_b' => 'Point B',
                    'bw' => 'Bandwidth'
                ), $data, $i, 'p2p');

                // ─── Leased Line rows ───
                eden_render_dynamic_rows('Leased Line Details', array(
                    'bw' => 'Bandwidth',
                    'details' => 'Details',
                    'sp_router' => 'SP Router'
                ), $data, $i, 'leased');

                // ─── Network Devices Table ───
                eden_render_device_table('Routers & Firewalls', array(
                    'num_owned_routers' => array('Owned Routers', 'owned_routers_oem'),
                    'num_isp_routers' => array('ISP-Provided Routers', 'isp_routers_oem'),
                    'num_firewalls' => array('Firewalls', 'firewalls_oem'),
                ), $data, $i);

                // ─── Network Features ───
                eden_render_loc_section('Network Features', 'dashicons-networking', array(
                    'sd_wan' => 'Firewall-based SD-WAN',
                    's2s_vpn' => 'Site-to-Site VPN',
                    'p2s_vpn' => 'Point-to-Site VPN',
                ), $data, $i);

                // ─── Switches Table ───
                eden_render_device_table('Network Switches', array(
                    'core_sw_qty' => array('Core Switches (L3)', 'core_sw_oem'),
                    'dist_sw_qty' => array('Distribution Switches', 'dist_sw_oem'),
                    'access_sw_qty' => array('Access Layer Switches', 'access_sw_oem'),
                ), $data, $i);

                // ─── WiFi APs Table ───
                eden_render_device_table('WiFi / Access Points', array(
                    'standalone_ap_qty' => array('Standalone AP', 'standalone_ap_oem'),
                    'controller_ap_qty' => array('Controller-Based AP', 'controller_ap_oem'),
                ), $data, $i);

                // ─── Server Room / Racks ───
                eden_render_loc_section('Server Room', 'dashicons-cloud-saved', array(
                    'server_room' => 'Server Room Present',
                    'num_racks' => 'No. of Racks',
                ), $data, $i);

                // ─── Servers ───
                eden_render_loc_section('Servers & Virtualization', 'dashicons-cloud-saved', array(
                    'has_phys_nonvirt' => 'Physical Servers (Non-Virt)',
                    'phys_nonvirt_qty' => 'Non-Virt Quantity',
                    'has_phys_virt' => 'Physical Servers (Virt)',
                    'phys_virt_qty' => 'Virt Quantity',
                    'hypervisor' => 'Hypervisor',
                    'vm_windows' => 'Windows VMs',
                    'vm_linux' => 'Linux VMs',
                ), $data, $i);

                // ─── Storage (SAN/NAS/HCI/KVM/Serial) — note: SAN fields use a different naming pattern ───
                $san_qty = isset($data['san_num_drives_' . $i]) ? trim($data['san_num_drives_' . $i]) : '';
                $san_raw = isset($data['san_raw_capacity_' . $i]) ? trim($data['san_raw_capacity_' . $i]) : '';
                $san_usable = isset($data['san_usable_capacity_' . $i]) ? trim($data['san_usable_capacity_' . $i]) : '';
                $has_san = isset($data['has_san_' . $i]) ? $data['has_san_' . $i] : '';

                if ($has_san || $san_qty || $san_raw || $san_usable) {
                    echo '<div style="margin-bottom:24px;">';
                    echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
                    echo '<span class="dashicons dashicons-database" style="margin-right:8px;color:#d39a06;"></span>SAN Storage</h3>';
                    echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
                    if ($has_san)
                        eden_print_row('Has SAN', $has_san, 0);
                    if ($san_qty)
                        eden_print_row('No. of Drives', $san_qty, 1);
                    if ($san_raw)
                        eden_print_row('Total Raw Capacity', $san_raw, 2);
                    if ($san_usable)
                        eden_print_row('Total Usable Capacity', $san_usable, 3);
                    echo '</table></div>';
                }

                eden_render_loc_section('NAS / HCI', 'dashicons-database', array(
                    'nas' => 'NAS Storage',
                    'nas_makemodel' => 'NAS Make & Model',
                    'hci' => 'HCI',
                    'hci_solution' => 'HCI Solution',
                ), $data, $i);

                // ─── Power & UPS ───
                $has_ups = isset($data['has_ups_' . $i]) ? $data['has_ups_' . $i] : '';
                $ups_qty = isset($data['ups_quantity_' . $i]) ? $data['ups_quantity_' . $i] : '';
                if ($has_ups || $ups_qty) {
                    echo '<div style="margin-bottom:24px;">';
                    echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
                    echo '<span class="dashicons dashicons-superhero" style="margin-right:8px;color:#d39a06;"></span>UPS & Power Backup</h3>';
                    echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
                    $j = 0;
                    foreach (array(
                        'has_ups_' => 'Has UPS',
                        'ups_quantity_' => 'Quantity',
                        'ups_type_' => 'UPS Type',
                        'ups_mode_' => 'UPS Mode',
                        'ups_capacity_' => 'Total Capacity',
                        'ups_backup_time_' => 'Backup Time',
                        'ups_make_model_' => 'Make / Model',
                    ) as $key_prefix => $label) {
                        $val = isset($data[$key_prefix . $i]) ? trim($data[$key_prefix . $i]) : '';
                        if ($val !== '')
                            eden_print_row($label, $val, $j++);
                    }
                    echo '</table></div>';
                }

                // ─── Fire Safety ───
                $fire_alarm = isset($data['fire_alarm_system_' . $i]) ? $data['fire_alarm_system_' . $i] : '';
                $has_ext = isset($data['has_extinguishers_' . $i]) ? $data['has_extinguishers_' . $i] : '';
                $ext_qty = isset($data['ext_quantity_' . $i]) ? $data['ext_quantity_' . $i] : '';
                if ($fire_alarm || $has_ext || $ext_qty) {
                    echo '<div style="margin-bottom:24px;">';
                    echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
                    echo '<span class="dashicons dashicons-warning" style="margin-right:8px;color:#d39a06;"></span>Fire Safety</h3>';
                    echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
                    $j = 0;
                    if ($fire_alarm)
                        eden_print_row('Fire Alarm System', $fire_alarm, $j++);
                    if ($has_ext)
                        eden_print_row('Fire Extinguishers Present', $has_ext, $j++);
                    if ($ext_qty)
                        eden_print_row('Extinguisher Quantity', $ext_qty, $j++);
                    echo '</table></div>';
                }

                // ─── CCTV Table ───
                eden_render_device_table('CCTV Surveillance', array(
                    'nvr_qty' => array('NVR / DVR Units', 'nvr_oem'),
                    'ip_cameras' => array('IP Cameras', 'ip_cameras_oem'),
                    'analog_cameras' => array('Analog Cameras', 'analog_cameras_oem'),
                ), $data, $i);

                eden_render_loc_section('CCTV Storage', 'dashicons-camera', array(
                    'cctv_storage' => 'Storage Capacity',
                    'cctv_retention' => 'Retention Period',
                ), $data, $i);

                // ─── Biometric ───
                eden_render_loc_section('Biometric / Access Control', 'dashicons-id', array(
                    'bio_type' => 'Type',
                    'bio_qty' => 'No. of Devices',
                    'bio_makemodel' => 'Make & Model',
                    'bio_areas' => 'Areas Covered',
                ), $data, $i);

                // ─── Telephony ───
                eden_render_loc_section('Telephony (EPABX / IP-PBX)', 'dashicons-phone', array(
                    'epabx' => 'EPABX',
                    'epabx_make' => 'EPABX Make',
                    'epabx_model' => 'EPABX Model',
                    'ip_pbx' => 'IP-PBX',
                    'ip_pbx_make' => 'IP-PBX Make',
                    'ip_pbx_model' => 'IP-PBX Model',
                    'pa' => 'PA System',
                    'pa_mm' => 'PA Make & Model',
                ), $data, $i);

                // ─── Phones Table ───
                eden_render_device_table('Phones', array(
                    'analog_phones' => array('Analog Phones', 'analog_phones_oem'),
                    'ip_phones' => array('IP Phones', 'ip_phones_oem'),
                    'soft_phones' => array('Soft Phones', 'soft_phones_oem'),
                ), $data, $i);

                // ─── Video Conferencing ───
                eden_render_loc_section('Video Conferencing', 'dashicons-video-alt2', array(
                    'vc_rooms' => 'No. of VC-Enabled Meeting Rooms',
                ), $data, $i);

                // ─── End-User Computing Table ───
                eden_render_device_table('End-User Computing', array(
                    'laptops_qty' => array('Laptops', 'laptops_oem'),
                    'desktops_qty' => array('Desktops', 'desktops_oem'),
                    'workstations_qty' => array('Workstations', 'workstations_oem'),
                    'thin_clients_qty' => array('Thin Clients', 'thin_clients_oem'),
                    'tablets_qty' => array('Tablets', 'tablets_oem'),
                    'co_phones_qty' => array('Phones (Company-Owned)', 'co_phones_oem'),
                    'printers_qty' => array('Printers', 'printers_oem'),
                    'scanners_qty' => array('Scanners', 'scanners_oem'),
                    'mfp_qty' => array('Multifunction Devices', 'mfp_oem'),
                    'headsets_qty' => array('Headsets', 'headsets_oem'),
                ), $data, $i);

                echo '</div></div>';
            }
        }

        // ─── Helper: Render a per-location key/value section ───
        function eden_render_loc_section($title, $icon, $fields, $data, $loc_idx)
        {
            $has_data = false;
            foreach ($fields as $key => $label) {
                $full_key = 'loc_' . $loc_idx . '_' . $key;
                if (isset($data[$full_key]) && trim((string) $data[$full_key]) !== '') {
                    $has_data = true;
                    break;
                }
            }
            if (!$has_data)
                return;

            echo '<div style="margin-bottom:24px;">';
            echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
            echo '<span class="dashicons ' . $icon . '" style="margin-right:8px;color:#d39a06;"></span>' . $title . '</h3>';
            echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
            $i = 0;
            foreach ($fields as $key => $label) {
                $full_key = 'loc_' . $loc_idx . '_' . $key;
                $val = isset($data[$full_key]) ? trim((string) $data[$full_key]) : '';
                if ($val === '')
                    continue;
                eden_print_row($label, $val, $i);
                $i++;
            }
            echo '</table></div>';
        }

        // ─── Helper: Print a single key/value row ───
        function eden_print_row($label, $val, $i)
        {
            $bg = ($i % 2 === 0) ? '#fff' : '#fafafa';
            echo '<tr style="background:' . $bg . ';">';
            echo '<td style="width:35%;padding:10px 14px;font-weight:600;color:#333;border-bottom:1px solid #eee;">' . esc_html($label) . '</td>';
            echo '<td style="padding:10px 14px;color:#555;border-bottom:1px solid #eee;">' . esc_html($val) . '</td>';
            echo '</tr>';
        }

        // ─── Helper: Render device table (Device | Qty | OEM) ───
        function eden_render_device_table($title, $fields, $data, $loc_idx)
        {
            $has_data = false;
            foreach ($fields as $qty_key => $info) {
                $full_qty = 'loc_' . $loc_idx . '_' . $qty_key;
                if (isset($data[$full_qty]) && trim((string) $data[$full_qty]) !== '' && intval($data[$full_qty]) > 0) {
                    $has_data = true;
                    break;
                }
            }
            if (!$has_data)
                return;

            echo '<div style="margin-bottom:24px;">';
            echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
            echo '<span class="dashicons dashicons-grid-view" style="margin-right:8px;color:#d39a06;"></span>' . $title . '</h3>';
            echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
            echo '<thead><tr style="background:#122c55;color:#fff;">';
            echo '<th style="padding:10px 14px;width:40%;">Device</th>';
            echo '<th style="padding:10px 14px;width:120px;">Quantity</th>';
            echo '<th style="padding:10px 14px;">OEM / Vendor</th>';
            echo '</tr></thead><tbody>';

            $i = 0;
            foreach ($fields as $qty_key => $info) {
                $label = $info[0];
                $oem_key = $info[1];
                $full_qty = 'loc_' . $loc_idx . '_' . $qty_key;
                $full_oem = 'loc_' . $loc_idx . '_' . $oem_key;
                $qty = isset($data[$full_qty]) ? trim((string) $data[$full_qty]) : '';
                $oem = isset($data[$full_oem]) ? trim((string) $data[$full_oem]) : '';
                if (($qty === '' || $qty === '0') && $oem === '')
                    continue;
                $bg = ($i % 2 === 0) ? '#fff' : '#fafafa';
                $qty_display = ($qty !== '' && $qty !== '0')
                    ? '<span style="display:inline-block;background:#122c55;color:#fff;padding:3px 12px;border-radius:20px;font-weight:700;font-size:13px;">' . esc_html($qty) . '</span>'
                    : '<span style="color:#999;">—</span>';
                $oem_display = $oem !== '' ? esc_html($oem) : '<span style="color:#999;">—</span>';
                echo '<tr style="background:' . $bg . ';">';
                echo '<td style="padding:10px 14px;font-weight:600;border-bottom:1px solid #eee;">' . esc_html($label) . '</td>';
                echo '<td style="padding:10px 14px;border-bottom:1px solid #eee;">' . $qty_display . '</td>';
                echo '<td style="padding:10px 14px;border-bottom:1px solid #eee;color:#555;">' . $oem_display . '</td>';
                echo '</tr>';
                $i++;
            }
            echo '</tbody></table></div>';
        }

        // ─── Helper: Render dynamic rows (Internet/P2P/Leased) ───
        function eden_render_dynamic_rows($title, $col_keys, $data, $loc_idx, $prefix)
        {
            $rows_html = '';
            $row_idx = 1;
            while ($row_idx <= 50) {
                $has_data = false;
                foreach ($col_keys as $col_key => $col_label) {
                    $full_key = 'loc_' . $loc_idx . '_' . $prefix . '_' . $row_idx . '_' . $col_key;
                    if (isset($data[$full_key]) && trim((string) $data[$full_key]) !== '') {
                        $has_data = true;
                        break;
                    }
                }
                if (!$has_data)
                    break;

                $cells = '';
                foreach ($col_keys as $col_key => $col_label) {
                    $full_key = 'loc_' . $loc_idx . '_' . $prefix . '_' . $row_idx . '_' . $col_key;
                    $val = isset($data[$full_key]) ? trim((string) $data[$full_key]) : '';
                    $cells .= '<td style="padding:10px 14px;border-bottom:1px solid #eee;">' . esc_html($val !== '' ? $val : '—') . '</td>';
                }
                $bg = ($row_idx % 2 === 1) ? '#fff' : '#fafafa';
                $rows_html .= '<tr style="background:' . $bg . ';"><td style="padding:10px 14px;font-weight:600;border-bottom:1px solid #eee;">#' . $row_idx . '</td>' . $cells . '</tr>';
                $row_idx++;
            }
            if (!$rows_html)
                return;

            echo '<div style="margin-bottom:24px;">';
            echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
            echo '<span class="dashicons dashicons-list-view" style="margin-right:8px;color:#d39a06;"></span>' . $title . '</h3>';
            echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
            echo '<thead><tr style="background:#122c55;color:#fff;">';
            echo '<th style="padding:10px 14px;width:60px;">#</th>';
            foreach ($col_keys as $col_label) {
                echo '<th style="padding:10px 14px;">' . esc_html($col_label) . '</th>';
            }
            echo '</tr></thead><tbody>' . $rows_html . '</tbody></table></div>';
        }

        // ─── Render Detail Page ───
        echo '<div class="wrap">';

        // Top bar
        echo '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px;">';
        echo '<div>';
        echo '<h1 style="margin:0;"><span class="dashicons dashicons-shield" style="margin-right:8px;"></span>Assessment #' . $row->id . '</h1>';
        echo '<p style="color:#666;margin:4px 0 0;">Submitted ' . date('F j, Y \a\t g:i A', strtotime($row->submission_date)) . '</p>';
        echo '</div>';
        echo '<div style="display:flex;gap:8px;">';
        echo '<a href="' . admin_url('admin.php?page=eden-assessments') . '" class="button">&larr; Back to List</a>';
        echo '<button onclick="window.print();" class="button button-primary"><span class="dashicons dashicons-printer" style="margin-top:3px;margin-right:4px;"></span> Print</button>';
        echo '</div></div>';

        // Risk Summary Cards
        echo '<div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:16px;margin-bottom:28px;">';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;text-align:center;">';
        echo '<div style="font-size:13px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Client</div>';
        echo '<div style="font-size:18px;font-weight:700;color:#122c55;">' . esc_html($row->client_name) . '</div>';
        echo '</div>';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;text-align:center;">';
        echo '<div style="font-size:13px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Risk Level</div>';
        echo '<div style="display:inline-block;background:' . $rb . ';color:' . $rc . ';padding:6px 18px;border-radius:50px;font-weight:700;font-size:15px;">' . esc_html($row->risk_level) . '</div>';
        echo '</div>';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;text-align:center;">';
        echo '<div style="font-size:13px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Risk Score</div>';
        echo '<div style="font-size:18px;font-weight:700;color:#122c55;">' . esc_html($row->risk_score) . '</div>';
        echo '</div>';

        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:20px;text-align:center;">';
        echo '<div style="font-size:13px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Contact</div>';
        echo '<div style="font-size:14px;"><a href="mailto:' . esc_attr($row->contact_email) . '">' . esc_html($row->contact_email) . '</a></div>';
        echo '<div style="font-size:13px;color:#666;margin-top:4px;">' . esc_html($row->contact_phone) . '</div>';
        echo '</div>';

        echo '</div>';

        // ─── All Sections ───
        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:28px;">';

        eden_render_section('Organization Details', 'dashicons-building', array(
            'client_name' => 'Organization Name',
            'contact_email' => 'Contact Email',
            'contact_phone' => 'Contact Phone',
            'designation' => 'Designation',
            'num_employees' => 'No. of Employees',
            'total_employees' => 'Total Employees (All Locations)',
            'num_locations' => 'No. of Locations',
            'num_departments' => 'No. of Departments',
            'num_vendors' => 'No. of Vendors',
            'work_days' => 'Work Days per Week',
            'departments_list' => 'Departments',
            'vendors_list' => 'Vendors',
            'total_working_hours' => 'Working Hours/Day',
            'inhouse_it_support' => 'Inhouse IT Support',
            'num_it_support_staff' => 'IT Support Staff',
        ), $data);

        // ─── Render all locations dynamically ───
        eden_render_locations($data);

        eden_render_section('Internet & ISP', 'dashicons-admin-site-alt3', array(
            'isp_names' => 'ISP Name(s)',
            'isp1_bandwidth' => 'ISP 1 Bandwidth',
            'isp2_bandwidth' => 'ISP 2 Bandwidth',
            'isp_router_provided' => 'ISP Router Provided',
        ), $data);

        eden_render_section('Leased Lines', 'dashicons-admin-links', array(
            'num_leased_lines' => 'No. of Leased Lines',
            'leased_bandwidth' => 'Bandwidth',
            'additional_leased_details' => 'Additional Details',
            'sp_router_provided' => 'SP Router Provided',
        ), $data);

        eden_render_section('Network Devices', 'dashicons-networking', array(
            'num_routers' => 'Owned Routers',
            'firewalls' => 'Firewalls',
            'num_vpn_users' => 'VPN Users',
        ), $data);

        eden_render_section('Switching Infrastructure', 'dashicons-randomize', array(
            'num_switches' => 'No. of Switches',
            'core_switches_l3' => 'Core Switches (L3)',
            'access_switches_l2' => 'Distribution / Access (L2/L1)',
        ), $data);

        eden_render_section('Server Infrastructure', 'dashicons-cloud-saved', array(
            'physical_servers_non_virt' => 'Physical Servers (Non-Virt)',
            'physical_servers_virt' => 'Physical Servers (Virt)',
            'hypervisor' => 'Hypervisor Platform',
            'total_vms' => 'Virtual Machines',
        ), $data);

        eden_render_section('Storage', 'dashicons-database', array(
            'num_nas' => 'NAS Devices',
            'nas_capacity' => 'NAS Capacity',
            'has_san' => 'SAN Storage Present',
            'san_num_drives' => 'SAN - No. of Drives',
            'san_raw_capacity' => 'SAN - Total Raw Capacity',
            'san_usable_capacity' => 'SAN - Total Usable Capacity',
        ), $data);

        eden_render_section('End-User Devices', 'dashicons-laptop', array(
            'company_desktops' => 'Company Desktops',
            'company_laptops' => 'Company Laptops',
            'company_tablets' => 'Company Tablets',
            'byod_desktops' => 'BYOD Desktops',
            'byod_laptops' => 'BYOD Laptops',
            'byod_mobile' => 'BYOD Mobile/Tablets',
            'thin_clients' => 'Thin Clients',
            'vdi_instances' => 'VDI Instances',
        ), $data);

        eden_render_section('Peripherals', 'dashicons-printer', array(
            'printers' => 'Printers',
            'scanners' => 'Scanners',
            'mfp_devices' => 'MFP Devices',
            'biometric_devices' => 'Biometric Devices',
        ), $data);

        eden_render_section('CCTV & Security Systems', 'dashicons-visibility', array(
            'ip_cameras' => 'IP Cameras',
            'analog_cameras' => 'Analog Cameras',
            'dvr_nvr_units' => 'DVR / NVR Units',
            'cctv_storage_capacity' => 'CCTV Storage Capacity',
        ), $data);

        eden_render_section('Telephony', 'dashicons-phone', array(
            'phone_line_types' => 'Phone Line Types',
            'epabx_type' => 'EPABX Type',
            'phone_types' => 'Phone Types',
        ), $data);

        eden_render_section('Power & Safety', 'dashicons-superhero', array(
            'fire_alarm_system' => 'Fire Alarm System (Office)',
            'has_extinguishers' => 'Fire Extinguishers Present',
            'ext_quantity' => 'Extinguisher Quantity',
            'has_ups' => 'UPS Installed',
            'ups_quantity' => 'UPS Quantity (Units)',
            'ups_type' => 'UPS Type',
            'ups_mode' => 'UPS Mode',
            'ups_capacity' => 'UPS Capacity',
            'ups_backup_time' => 'UPS Backup Time',
            'ups_make_model' => 'UPS Make / Model',
        ), $data);

        eden_render_section('Video Conferencing', 'dashicons-video-alt2', array(
            'vc_devices' => 'VC Devices (Hardware)',
        ), $data);

        eden_render_section('Identity & Directory', 'dashicons-admin-network', array(
            'ad_workgroup' => 'AD / Workgroup',
            'ad_type' => 'Type of AD',
        ), $data);

        // ─── Endpoint Security — Special Table ───
        $sec_features = array(
            'sec_antivirus' => 'Antivirus / Anti-malware',
            'sec_endpoint_firewall' => 'Endpoint Firewall',
            'sec_app_control' => 'Application Control',
            'sec_device_control' => 'Device Control',
            'sec_vuln_assessment' => 'Vulnerability Assessment',
            'sec_patch_mgmt' => 'Patch Management',
            'sec_siem' => 'SIEM Integration',
            'sec_encryption' => 'Encryption',
            'sec_edr_xdr' => 'EDR / XDR',
            'sec_software_control' => 'Software Control',
            'sec_inventory_tracking' => 'Inventory Tracking',
        );

        echo '<div style="margin-bottom:24px;">';
        echo '<h3 style="font-size:15px;color:#122c55;margin:0 0 12px;padding:10px 14px;background:#f0f0f1;border-left:4px solid #d39a06;border-radius:4px;">';
        echo '<span class="dashicons dashicons-shield" style="margin-right:8px;color:#d39a06;"></span>Endpoint Security</h3>';
        echo '<table class="widefat fixed" style="border:1px solid #e0e0e0;">';
        echo '<thead><tr style="background:#122c55;color:#fff;">';
        echo '<th style="padding:10px 14px;width:35%;">Feature</th>';
        echo '<th style="padding:10px 14px;width:15%;">Status</th>';
        echo '<th style="padding:10px 14px;">Remarks / Solution</th>';
        echo '</tr></thead><tbody>';
        $i = 0;
        foreach ($sec_features as $key => $label) {
            $status = eden_val($data, $key, 'no');
            $remarks = eden_val($data, $key . '_remarks');
            $bg = ($i % 2 === 0) ? '#fff' : '#fafafa';
            $status_color = (strtolower($status) === 'yes') ? '#2e7d32' : '#c62828';
            $status_bg = (strtolower($status) === 'yes') ? '#e8f5e9' : '#ffebee';
            $status_icon = (strtolower($status) === 'yes') ? '✅' : '❌';
            echo '<tr style="background:' . $bg . ';">';
            echo '<td style="padding:10px 14px;font-weight:600;border-bottom:1px solid #eee;">' . $label . '</td>';
            echo '<td style="padding:10px 14px;border-bottom:1px solid #eee;"><span style="background:' . $status_bg . ';color:' . $status_color . ';padding:3px 12px;border-radius:20px;font-weight:700;font-size:13px;">' . $status_icon . ' ' . ucfirst($status) . '</span></td>';
            echo '<td style="padding:10px 14px;border-bottom:1px solid #eee;color:#555;">' . $remarks . '</td>';
            echo '</tr>';
            $i++;
        }
        echo '</tbody></table></div>';

        eden_render_section('IT Operations Tools', 'dashicons-admin-tools', array(
            'encryption_tool' => 'Encryption Tool',
            'patch_mgmt_solution' => 'Patch Management',
            'remote_support_tool' => 'Remote Support Tool',
            'asset_mgmt_system' => 'Asset Management',
            'siem_system' => 'Log / SIEM System',
        ), $data);

        eden_render_section('Email & Collaboration', 'dashicons-email', array(
            'email_platform' => 'Email Platform',
            'num_email_users' => 'Email Users',
            'email_backup' => 'Email Backup / Archival',
            'email_security_solution' => 'Email Security Solution',
        ), $data);

        eden_render_section('File Server & OS', 'dashicons-open-folder', array(
            'file_server_type' => 'File Server Type',
            'server_os_types' => 'Server OS Types',
            'endpoint_os_types' => 'Endpoint OS Types',
        ), $data);

        eden_render_section('Backup & Disaster Recovery', 'dashicons-backup', array(
            'server_backup_solution' => 'Server Backup Solution',
            'endpoint_backup_solution' => 'Endpoint Backup Solution',
            'nas_backup' => 'NAS Backup',
            'm365_collab_backup' => 'M365 / G-Suite Collab Backup',
            'mfa_sso' => 'MFA / SSO Implemented',
        ), $data);

        eden_render_section('Applications & Databases', 'dashicons-grid-view', array(
            'total_applications' => 'Total Applications',
            'web_applications' => 'Web Applications',
            'databases_count' => 'Databases Count',
            'database_types' => 'Database Types',
        ), $data);

        eden_render_section('Website & Domain', 'dashicons-admin-site', array(
            'domain_provider' => 'Domain Provider',
            'website_url' => 'Website URL',
            'ssl_certificate' => 'SSL Certificate',
        ), $data);
        eden_render_section('SIEM / SOC', 'dashicons-shield-alt', array(
            'siem_deployed' => 'SIEM Solution Deployed',
            'siem_deployment' => 'SIEM Deployment',
            'siem_oem' => 'SIEM OEM Name',
            'soc_247' => 'SOC Monitoring 24/7',
            'soc_type' => 'SOC Type',
            'soc_oem' => 'SOC OEM Name',
        ), $data);

        eden_render_section('Compliance & Standards', 'dashicons-awards', array(
            'has_compliance' => 'Follows Compliances',
            'compliances' => 'Compliances Followed',
        ), $data);
        echo '</div>'; // end white card
        echo '</div>'; // end wrap
        return;
    }

    // ─── LIST VIEW (default) ───
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY submission_date DESC LIMIT 100");
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    echo '<div class="wrap">';
    echo '<h1 style="display:flex;align-items:center;gap:8px;"><span class="dashicons dashicons-shield" style="color:#d39a06;"></span> IT Infrastructure & Security Assessments</h1>';
    echo '<p style="color:#666;">All client assessments submitted via the website. Click <strong>View</strong> to see full details.</p>';

    if (empty($results)) {
        echo '<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:40px;text-align:center;margin-top:20px;">';
        echo '<span class="dashicons dashicons-shield" style="font-size:48px;color:#ccc;"></span>';
        echo '<p style="font-size:16px;color:#999;margin-top:16px;">No assessments submitted yet.</p>';
        echo '</div>';
    } else {
        echo '<table class="widefat fixed striped" style="margin-top:20px;">';
        echo '<thead><tr>
                <th style="width:50px;">ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Phone</th>
                <th style="width:100px;">Risk Level</th>
                <th style="width:70px;">Score</th>
                <th style="width:150px;">Date</th>
                <th style="width:120px;">Actions</th>
              </tr></thead><tbody>';

        $risk_colors = array('Low' => '#2e7d32', 'Medium' => '#f57f17', 'High' => '#e65100', 'Critical' => '#c62828');
        $risk_bg = array('Low' => '#e8f5e9', 'Medium' => '#fff8e1', 'High' => '#fff3e0', 'Critical' => '#ffebee');

        foreach ($results as $row) {
            $rc = isset($risk_colors[$row->risk_level]) ? $risk_colors[$row->risk_level] : '#666';
            $rb = isset($risk_bg[$row->risk_level]) ? $risk_bg[$row->risk_level] : '#f5f5f5';

            echo '<tr>';
            echo '<td><strong>#' . $row->id . '</strong></td>';
            echo '<td><strong>' . esc_html($row->client_name) . '</strong></td>';
            echo '<td><a href="mailto:' . esc_attr($row->contact_email) . '">' . esc_html($row->contact_email) . '</a></td>';
            echo '<td>' . esc_html($row->contact_phone) . '</td>';
            echo '<td><span style="background:' . $rb . ';color:' . $rc . ';padding:4px 14px;border-radius:20px;font-weight:700;font-size:13px;white-space:nowrap;">' . esc_html($row->risk_level) . '</span></td>';
            echo '<td>' . esc_html($row->risk_score) . '</td>';
            echo '<td>' . date('M j, Y g:i A', strtotime($row->submission_date)) . '</td>';
            echo '<td>';
            echo '<a href="' . esc_url(admin_url('admin.php?page=eden-assessments&view_id=' . $row->id)) . '" class="button button-small" title="View full details">👁 View</a> ';
            echo '<a href="' . esc_url(admin_url('admin.php?page=eden-assessments&delete_id=' . $row->id)) . '" class="button button-small" style="color:#c62828;" title="Delete" onclick="return confirm(\'Delete assessment #' . $row->id . '?\');">🗑</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody></table>';
        echo '<p style="margin-top:15px;color:#666;">Showing ' . count($results) . ' of ' . $total . ' total assessments.</p>';

    }


    echo '</div>';


}



/* ============================
CAREERS — Job Post Type
============================ */
function eden_register_jobs_cpt()
{
    register_post_type('jobs', array(
        'labels' => array(
            'name' => 'Jobs',
            'singular_name' => 'Job',
            'add_new_item' => 'Add New Job',
            'edit_item' => 'Edit Job',
        ),
        'public' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-businessperson',
        'supports' => array('title', 'editor'),
        'has_archive' => false,
        'publicly_queryable' => false, // we use modal, not single page
        'rewrite' => false,
    ));
}
add_action('init', 'eden_register_jobs_cpt');

/* ============================
   CAREERS — Custom Meta Boxes
============================ */
function eden_add_job_meta_boxes()
{
    add_meta_box(
        'eden_job_details',
        'Job Details',
        'eden_job_meta_box_html',
        'jobs',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'eden_add_job_meta_boxes');

function eden_job_meta_box_html($post)
{
    $location = get_post_meta($post->ID, '_job_location', true);
    $experience = get_post_meta($post->ID, '_job_experience', true);
    $type = get_post_meta($post->ID, '_job_type', true);
    $department = get_post_meta($post->ID, '_job_department', true);
    $apply_email = get_post_meta($post->ID, '_job_apply_email', true);
    $openings = get_post_meta($post->ID, '_job_openings', true);

    wp_nonce_field('eden_job_save', 'eden_job_nonce');
    ?>
    <style>
        .eden-job-fields label {
            display: block;
            font-weight: 600;
            margin: 12px 0 4px;
        }

        .eden-job-fields input,
        .eden-job-fields select {
            width: 100%;
            padding: 8px;
        }
    </style>
    <div class="eden-job-fields">
        <label>Location</label>
        <input type="text" name="job_location" value="<?php echo esc_attr($location); ?>" placeholder="e.g. Mumbai, India">

        <label>Experience</label>
        <input type="text" name="job_experience" value="<?php echo esc_attr($experience); ?>" placeholder="e.g. 2-4 years">

        <label>Job Type</label>
        <select name="job_type">
            <?php
            $types = array('Full-time', 'Part-time', 'Internship', 'Contract');
            foreach ($types as $t) {
                $sel = ($type === $t) ? 'selected' : '';
                echo "<option $sel>$t</option>";
            }
            ?>
        </select>

        <label>Department</label>
        <select name="job_department">
            <?php
            $depts = array('Cybersecurity', 'Infrastructure', 'Cloud', 'Sales', 'Operations', 'Support', 'Other');
            foreach ($depts as $d) {
                $sel = ($department === $d) ? 'selected' : '';
                echo "<option $sel>$d</option>";
            }
            ?>
        </select>
        <label>Number of Openings</label>
        <input type="number" name="job_openings" value="<?php echo esc_attr($openings ?: 1); ?>" min="1"
            placeholder="e.g. 3">

        <label>Apply Email (where applications get sent)</label>
        <input type="email" name="job_apply_email" value="<?php echo esc_attr($apply_email); ?>"
            placeholder="hr@edeninfosol.com">
    </div>
    <?php
}

function eden_save_job_meta($post_id)
{
    if (!isset($_POST['eden_job_nonce']) || !wp_verify_nonce($_POST['eden_job_nonce'], 'eden_job_save'))
        return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    $fields = array('job_location', 'job_experience', 'job_type', 'job_department', 'job_apply_email', 'job_openings');
    foreach ($fields as $f) {
        if (isset($_POST[$f])) {
            update_post_meta($post_id, '_' . $f, sanitize_text_field($_POST[$f]));
        }
    }
}
add_action('save_post_jobs', 'eden_save_job_meta');

/* ============================
   CAREERS — Handle Apply Form
============================ */
function eden_handle_job_application()
{
    if (!isset($_POST['eden_apply_nonce']) || !wp_verify_nonce($_POST['eden_apply_nonce'], 'eden_apply'))
        return;

    $job_id = intval($_POST['job_id']);
    $name = sanitize_text_field($_POST['applicant_name']);
    $email = sanitize_email($_POST['applicant_email']);
    $phone = sanitize_text_field($_POST['applicant_phone']);
    $message = sanitize_textarea_field($_POST['applicant_message']);

    $job_title = get_the_title($job_id);
    $hr_email = get_post_meta($job_id, '_job_apply_email', true);
    if (!$hr_email)
        $hr_email = get_option('admin_email');

    // Handle resume upload
    $attachments = array();
    if (!empty($_FILES['applicant_resume']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $upload = wp_handle_upload($_FILES['applicant_resume'], array('test_form' => false));
        if (!isset($upload['error']) && isset($upload['file'])) {
            $attachments[] = $upload['file'];
        }
    }

    $subject = "New Application: $job_title - $name";
    $body = "New job application received\n\n";
    $body .= "Job: $job_title\n";
    $body .= "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

    wp_mail($hr_email, $subject, $body, array(), $attachments);

    wp_safe_redirect(add_query_arg('applied', '1', wp_get_referer()));
    exit;
}
add_action('admin_post_nopriv_eden_apply_job', 'eden_handle_job_application');
add_action('admin_post_eden_apply_job', 'eden_handle_job_application');