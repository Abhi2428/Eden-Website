<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$home_url     = home_url('/');
$products_url = eden_get_page_url('products', home_url('/products/'));
$about_url    = eden_get_page_url('about', home_url('/about/'));
$contact_url  = eden_get_page_url('contact-us', home_url('/contact-us/'));

?>

<nav class="navbar">
    <div class="container">
        <a href="<?php echo esc_url($home_url); ?>" class="nav-logo">
            <span>EDEN</span>INFOSOL
        </a>

        <ul class="nav-links">
            <li><a href="<?php echo esc_url($home_url); ?>">Home</a></li>

            <li class="dropdown">
                <a href="<?php echo esc_url($products_url); ?>" class="dropdown-toggle">
                    Products &amp; Services <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>"><i class="fas fa-server"></i> IT Infrastructure</a>
                    <a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>"><i class="fas fa-cloud"></i> Cloud &amp; Data Center</a>
                    <a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>"><i class="fas fa-shield-halved"></i> Cybersecurity</a>
                    <a href="<?php echo esc_url($products_url . '#managed-services'); ?>"><i class="fas fa-headset"></i> Managed Services</a>
                    <a href="<?php echo esc_url($products_url . '#connectivity-voice'); ?>"><i class="fas fa-phone-volume"></i> Connectivity &amp; Voice</a>
                    <a href="<?php echo esc_url($products_url . '#audits-compliance'); ?>"><i class="fas fa-clipboard-check"></i> Audits &amp; Compliance</a>
                    <a href="<?php echo esc_url($products_url . '#digital-solutions'); ?>"><i class="fas fa-laptop-code"></i> Digital Solutions</a>
                </div>
            </li>

            <li><a href="<?php echo esc_url($about_url); ?>">About Us</a></li>
        

            <li><a href="<?php echo esc_url($contact_url); ?>">Contact Us</a></li>
            <li class="nav-cta"><a href="<?php echo esc_url($contact_url); ?>" class="btn btn-primary">Get Your Free Assessment</a></li>

        </ul>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>
