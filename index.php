<?php
if (!defined('ABSPATH')) exit;
get_header();
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="section-label">PAGE</span>
        <h1><?php the_title(); ?></h1>
        <p>Content managed through WordPress.</p>
    </div>
</section>

<section class="section section-white">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                the_content();
            endwhile;
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>