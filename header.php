<?php
if (!defined('ABSPATH'))
    exit;

$home_url = home_url('/');
$products_url = eden_get_page_url('products', home_url('/products/'));
$bytes_url = eden_get_page_url('eden-bytes', home_url('/eden-bytes/'));
$about_url = eden_get_page_url('about', home_url('/about/'));
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
$assess_url = eden_get_page_url('assessment', home_url('/assessment/'));
$careers_url = eden_get_page_url('careers', home_url('/careers/'));
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- Radial expanding social orbit -->
    <aside class="eden-orbit" aria-label="Follow Eden Infosol">
        <button class="eden-orbit__trigger" type="button" aria-label="Show social links">
            <span class="eden-orbit__dot"></span>
            <span class="eden-orbit__dot"></span>
            <span class="eden-orbit__dot"></span>
        </button>
        <div class="eden-orbit__items">
            <a href="https://www.linkedin.com/in/eden-infosol-154a66121/" target="_blank" rel="noopener"
                class="eden-orbit__item" style="--i:0" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
            </a>
            <a href="https://www.facebook.com/edeninfosol" target="_blank" rel="noopener" class="eden-orbit__item"
                style="--i:1" aria-label="Facebook">
                <i class="fab fa-facebook-f" aria-hidden="true"></i>
            </a>
            <a href="https://maps.google.com/?q=Eden+Infosol+Mumbai" target="_blank" rel="noopener"
                class="eden-orbit__item" style="--i:2" aria-label="Visit us in Mumbai">
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
            </a>
        </div>
    </aside>
    <nav class="navbar navbar-float">
        <div class="container">

            <!-- Hamburger FIRST = appears on LEFT -->
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <a href="<?php echo esc_url($home_url); ?>" class="nav-brand">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/logos/EdenInfosol.png'); ?>"
                    alt="Eden Infosol" class="nav-brand-logo">
                <div class="nav-brand-text">
                    <span class="nav-logo">EDEN <span>INFOSOL</span></span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="<?php echo esc_url($home_url); ?>">Home</a></li>
                <li class="dropdown">
                    <a href="<?php echo esc_url($products_url); ?>" class="dropdown-toggle">Products & Services <i
                            class="fas fa-chevron-down"></i></a>
                    <div class="dropdown-menu">
                        <a href="<?php echo esc_url($products_url . '#digital-connectivity'); ?>"><i
                                class="fas fa-satellite-dish"></i> Connectivity & Digital Transformation</a>
                        <a href="<?php echo esc_url($products_url . '#it-infrastructure'); ?>"><i
                                class="fas fa-server"></i> IT Infrastructure</a>
                        <a href="<?php echo esc_url($products_url . '#cybersecurity'); ?>"><i
                                class="fas fa-shield-halved"></i> Cybersecurity</a>
                        <a href="<?php echo esc_url($products_url . '#cloud-datacenter'); ?>"><i
                                class="fas fa-cloud"></i> Cloud & Data Center</a>
                        <a href="<?php echo esc_url($products_url . '#managed-services'); ?>"><i
                                class="fas fa-headset"></i> Professional Services</a>
                    </div>
                </li>
                <li><a href="<?php echo esc_url($bytes_url); ?>">EdenBytes</a></li>
                <li><a href="<?php echo esc_url($about_url); ?>">About Us</a></li>
                <li><a href="<?php echo esc_url($careers_url); ?>" class="nav-careers-link">Careers <span
                            class="nav-hiring-badge">Hiring</span></a></li>
                <li class="nav-cta"><a href="<?php echo esc_url($assess_url); ?>" class="btn btn-primary">Get Your
                        Assessment</a></li>

                <!-- Social icons INSIDE nav-links = shows in mobile sidebar only -->
                <li class="sidebar-social">
                    <a href="https://www.linkedin.com/in/eden-infosol-154a66121/" target="_blank" rel="noopener"
                        aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.facebook.com/edeninfosol" target="_blank" rel="noopener"
                        aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://maps.google.com/?q=Eden+Infosol+Mumbai" target="_blank" rel="noopener"
                        aria-label="Google Maps"><i class="fas fa-map-marker-alt"></i></a>
                </li>
            </ul>

        </div>
    </nav>