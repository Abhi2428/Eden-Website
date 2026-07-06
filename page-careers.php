<?php
/*
Template Name: Careers Page
*/
get_header();

$jobs = new WP_Query(array(
    'post_type' => 'jobs',
    'posts_per_page' => -1,
    'post_status' => 'publish',
));
// ─── MICROSOFT FORMS APPLICATION URL ───
// The single Microsoft Forms link where all applications are collected.
$ms_forms_url = 'https://forms.office.com/Pages/ResponsePage.aspx?id=nWi5z2NTukebx2KPD3b3ERXuyZzpByJIn2kcN-ooKihUM01SRlk0UzUwRUlFTEU1MUFPSlo3QzhCMC4u';
?>

<!-- ============ HERO ============ -->
<section class="careers-hero">
    <div class="careers-hero-inner">
        <h1>Join the Eden Infosol Team</h1>
        <p>Help us build secure, future-ready IT infrastructure for businesses across India.</p>
        <a href="#open-roles" class="careers-cta">View Open Roles</a>
    </div>
</section>

<!-- ============ WHY US ============ -->
<section class="careers-why">
    <h2>Why Work With Us</h2>
    <div class="why-grid">
        <div class="why-card">
            <i class="fa-solid fa-shield-halved"></i>
            <h3>Cybersecurity First</h3>
            <p>Work on real-world security challenges for enterprise clients.</p>
        </div>
        <div class="why-card">
            <i class="fa-solid fa-chart-line"></i>
            <h3>Career Growth</h3>
            <p>Mentorship, certifications and structured growth paths.</p>
        </div>
        <div class="why-card">
            <i class="fa-solid fa-people-group"></i>
            <h3>Strong Culture</h3>
            <p>A close-knit team that supports learning, ideas and ownership.</p>
        </div>
        <div class="why-card">
            <i class="fa-solid fa-laptop-code"></i>
            <h3>Modern Tech Stack</h3>
            <p>Cloud, automation, networking, and emerging tech projects.</p>
        </div>
    </div>
</section>

<!-- ============ OPEN POSITIONS ============ -->
<section class="careers-jobs" id="open-roles">
    <div class="jobs-section-header">
        <h2>Open Positions</h2>
        <?php $total_jobs = $jobs->found_posts; ?>
        <?php if ($total_jobs > 0): ?>
            <p class="jobs-count">
                <i class="fas fa-briefcase"></i>
                <strong><?php echo esc_html($total_jobs); ?></strong>
                <?php echo ($total_jobs === 1) ? 'active opening' : 'active openings'; ?> across departments
            </p>
        <?php endif; ?>
    </div>

    <?php if (isset($_GET['applied'])): ?>
        <div class="apply-success">✅ Application submitted successfully. Our HR team will get back to you soon.</div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="job-filters">
        <input type="text" id="jobSearch" placeholder="🔍 Search jobs...">
        <select id="filterDept">
            <option value="">All Departments</option>
            <option>Cybersecurity</option>
            <option>Infrastructure</option>
            <option>Cloud</option>
            <option>Sales</option>
            <option>Operations</option>
            <option>Support</option>
            <option>Other</option>
        </select>

    </div>

    <div class="jobs-grid" id="jobsGrid">
        <?php if ($jobs->have_posts()): ?>
            <?php while ($jobs->have_posts()):
                $jobs->the_post();
                $id = get_the_ID();
                $location = get_post_meta($id, '_job_location', true);
                $exp = get_post_meta($id, '_job_experience', true);
                $type = get_post_meta($id, '_job_type', true);
                $dept = get_post_meta($id, '_job_department', true);
                $job_title = get_the_title();
                $openings = get_post_meta($id, '_job_openings', true);
                $openings = $openings ? intval($openings) : 1;
                ?>
                <div class="job-card" data-dept="<?php echo esc_attr($dept); ?>" data-type="<?php echo esc_attr($type); ?>"
                    data-search="<?php echo esc_attr(strtolower($job_title . ' ' . $location . ' ' . $exp . ' ' . $type . ' ' . $dept)); ?>">

                    <div class="job-card-header">
                        <h3 class="job-title">
                            <?php echo esc_html($job_title); ?>
                            <span class="openings-badge">
                                <i class="fa-solid fa-users"></i>
                                <?php echo esc_html($openings); ?>
                                <?php echo $openings === 1 ? 'Opening' : 'Openings'; ?>
                            </span>
                        </h3>
                    </div>

                    <div class="job-meta">
                        <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></span>
                        <span><i class="fas fa-briefcase"></i> <?php echo esc_html($exp); ?></span>
                        <span><i class="fas fa-tag"></i> <?php echo esc_html($dept); ?></span>
                    </div>

                    <div class="job-card-actions">
                        <button type="button" class="btn-view-details" data-job-id="<?php echo esc_attr($id); ?>"
                            data-job-title="<?php echo esc_attr($job_title); ?>"
                            data-job-location="<?php echo esc_attr($location); ?>" data-job-exp="<?php echo esc_attr($exp); ?>"
                            data-job-type="<?php echo esc_attr($type); ?>" data-job-dept="<?php echo esc_attr($dept); ?>"
                            data-job-description="<?php echo esc_attr(apply_filters('the_content', get_the_content())); ?>">
                            View Details <i class="fas fa-arrow-right"></i>
                        </button>

                        <a href="<?php echo esc_url($ms_forms_url); ?>" target="_blank" rel="noopener noreferrer"
                            class="btn-apply-now">
                            <i class="fas fa-paper-plane"></i> Apply Now
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else: ?>
            <p class="no-jobs">No open positions right now. Please check back soon!</p>
        <?php endif; ?>
    </div>

    <p class="no-results" id="noResults" style="display:none;">No jobs match your filters.</p>
</section>

<!-- ═══════════════════════════════════════════ -->
<!-- JOB DETAILS MODAL                            -->
<!-- ═══════════════════════════════════════════ -->
<div class="job-modal-overlay" id="jobDetailsModal" style="display:none;">
    <div class="job-modal">
        <button type="button" class="job-modal-close" id="closeJobModal" aria-label="Close">&times;</button>

        <div class="job-modal-header">
            <h2 id="modalJobTitle"></h2>
            <div class="job-modal-meta" id="modalJobMeta"></div>
        </div>

        <div class="job-modal-body">
            <h3>Job Description</h3>
            <div class="job-modal-description" id="modalJobDescription"></div>
        </div>

        <div class="job-modal-footer">
            <button type="button" class="btn-modal-cancel" id="modalCancelBtn">Close</button>
            <a href="<?php echo esc_url($ms_forms_url); ?>" target="_blank" rel="noopener noreferrer"
                class="btn-modal-apply">
                <i class="fas fa-paper-plane"></i> Apply Now
            </a>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('jobDetailsModal');
        if (!modal) return;

        var modalTitle = document.getElementById('modalJobTitle');
        var modalMeta = document.getElementById('modalJobMeta');
        var modalDesc = document.getElementById('modalJobDescription');
        var closeBtn = document.getElementById('closeJobModal');
        var cancelBtn = document.getElementById('modalCancelBtn');

        // ─── Open modal when "View Details" clicked ───
        document.querySelectorAll('.btn-view-details').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var title = this.getAttribute('data-job-title');
                var location = this.getAttribute('data-job-location');
                var exp = this.getAttribute('data-job-exp');
                var type = this.getAttribute('data-job-type');
                var dept = this.getAttribute('data-job-dept');
                var description = this.getAttribute('data-job-description');

                modalTitle.textContent = title;
                modalMeta.innerHTML =
                    '<div class="modal-meta-item"><span class="meta-label">Location</span><span class="meta-value">' + location + '</span></div>' +
                    '<div class="modal-meta-item"><span class="meta-label">Experience</span><span class="meta-value">' + exp + '</span></div>' +
                    '<div class="modal-meta-item"><span class="meta-label">Department</span><span class="meta-value">' + dept + '</span></div>';

                modalDesc.innerHTML = description || '<p>No description available.</p>';

                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(function () { modal.classList.add('is-active'); });
            });
        });

        // ─── Close modal ───
        function closeModal() {
            modal.classList.remove('is-active');
            setTimeout(function () {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 250);
        }

        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) closeModal();
        });
    });
</script>

<?php get_footer(); ?>