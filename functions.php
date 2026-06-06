<?php
// ===== EDEN INFOSOL - CLEAN MERGED FUNCTIONS.PHP =====
if (!defined('ABSPATH'))
    exit;

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
    $to = 'hiren.sheth@edeninfosol.com';

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
