<?php
/**
 * Template Name: IT Assessment (Secret)
 */
if (!defined('ABSPATH'))
    exit;

$eden_secret_key = 'eden2026secure';
if (!isset($_GET['key']) || $_GET['key'] !== $eden_secret_key) {
    wp_redirect(home_url('/'));
    exit;
}
add_action('wp_head', function () {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
}, 1);
get_header();
$home_url = home_url('/');
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
?>

<!-- HERO -->
<section class="eden-assess-hero">
    <div class="eden-container" style="position:relative;z-index:2;">
        <div class="hero-badge"><i class="fas fa-shield-halved"></i> Free IT Assessment</div>
        <h1>Get Your IT Infrastructure &amp; Security Assessment</h1>
        <p class="hero-subtitle">Complete this assessment in <strong>3 quick steps</strong> and receive a personalized
            IT health report.</p>
        <div class="hero-benefits">
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-search-plus"></i></div>
                <h3>Identify Security Gaps</h3>
                <p>Discover vulnerabilities across your IT infrastructure</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Optimize Infrastructure</h3>
                <p>Get recommendations to improve performance &amp; reduce costs</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fas fa-file-shield"></i></div>
                <h3>Expert Recommendations</h3>
                <p>Receive a detailed report reviewed by our IT specialists</p>
            </div>
        </div>
    </div>
</section>



<!-- FORM SECTION -->
<section class="eden-assess-form-section" id="assessment-form-section">
    <div class="eden-container">

        <!-- Progress Bar -->
        <div class="eden-progress-bar">
            <div class="progress-track">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-steps">
                <div class="progress-step active" data-step="1">
                    <div class="step-circle">1</div>
                    <span>Organization</span>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="step-circle">2</div>
                    <span>Location Infrastructure</span>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-circle">3</div>
                    <span>Security &amp; Operations</span>
                </div>
                <div class="progress-step" data-step="4">
                    <div class="step-circle">4</div>
                    <span>Review &amp; Submit</span>
                </div>
            </div>
        </div>

        <form id="edenAssessmentForm" novalidate>

            <!-- ══════ STEP 1: Organization ══════ -->
            <div class="form-step active" data-step="1">
                <div class="step-header">
                    <h2><i class="fas fa-building"></i> Step 1: Organization Details</h2>
                    <p>Tell us about your organization.</p>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group required"><label for="client_name">Client / Organization Name</label>
                        <input type="text" id="client_name" name="client_name" placeholder="e.g. Acme Corp"><span
                            class="field-error"></span>
                    </div>
                    <div class="form-group required"><label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" placeholder="you@company.com"><span
                            class="field-error"></span>
                    </div>
                    <div class="form-group required"><label for="contact_phone">Contact Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone" placeholder="+91 98765 43210"><span
                            class="field-error"></span>
                    </div>
                    <div class="form-group"><label for="designation">Designation</label>
                        <input type="text" id="designation" name="designation" placeholder="e.g. IT Manager">
                    </div>
                </div>

                <div class="form-divider"><span>Organization Size</span></div>

                <div class="form-grid cols-3">
                    <div class="form-group"><label for="num_employees">No. of Employees</label>
                        <input type="number" id="num_employees" name="num_employees" min="1" placeholder="e.g. 50">
                    </div>
                    <div class="form-group"><label for="total_employees">Total Employees (All Locations)</label>
                        <input type="number" id="total_employees" name="total_employees" min="1" placeholder="e.g. 200">
                    </div>
                    <div class="form-group required"><label for="num_locations">No. of Locations</label>
                        <input type="number" id="num_locations" name="num_locations" min="1" max="20"
                            placeholder="e.g. 3"><span class="field-error"></span>
                    </div>
                    <div class="form-group"><label for="num_departments">No. of Departments</label>
                        <input type="number" id="num_departments" name="num_departments" min="1" placeholder="e.g. 8">
                    </div>
                    <div class="form-group"><label for="num_vendors">No. of Vendors</label>
                        <input type="number" id="num_vendors" name="num_vendors" min="0" placeholder="e.g. 5">
                    </div>
                    <div class="form-group"><label for="work_days">Work Days per Week</label>
                        <select id="work_days" name="work_days">
                            <option value="">Select</option>
                            <option value="5">5 Days</option>
                            <option value="6">6 Days</option>
                            <option value="7">7 Days</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group"><label for="departments_list">Departments Across the Org</label>
                        <textarea id="departments_list" name="departments_list" rows="2"
                            placeholder="e.g. IT, HR, Finance, Sales..."></textarea>
                    </div>
                    <div class="form-group"><label for="vendors_list">Vendors Across the Org</label>
                        <textarea id="vendors_list" name="vendors_list" rows="2"
                            placeholder="e.g. Microsoft, AWS, Dell..."></textarea>
                    </div>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group"><label for="total_working_hours">Total Working Hours/Day (All
                            Shifts)</label>
                        <input type="number" id="total_working_hours" name="total_working_hours" min="1" max="24"
                            placeholder="e.g. 9">
                    </div>
                    <div class="form-group"><label>Inhouse IT Support</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="inhouse_it_support" value="yes"
                                    class="eden-yn-trigger" data-target="it_team_field"> Yes</label>
                            <label class="radio-label"><input type="radio" name="inhouse_it_support" value="no"
                                    class="eden-yn-trigger" data-target="it_team_field"> No</label>
                        </div>
                    </div>
                </div>

                <div class="conditional-field" id="it_team_field" style="display:none;">
                    <div class="form-grid cols-2">
                        <div class="form-group"><label for="it_team_strength">IT Team Strength</label>
                            <input type="number" id="it_team_strength" name="it_team_strength" min="0"
                                placeholder="e.g. 5">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <div></div>
                    <button type="button" class="btn-next">Next <i class="fas fa-arrow-right"></i></button>
                </div>
            </div><!-- ══════ STEP 2: Location Infrastructure ══════ -->
            <div class="form-step" data-step="2">
                <div class="step-header">
                    <h2><i class="fas fa-map-marker-alt"></i> Step 2: Location Infrastructure</h2>
                    <p>Fill details for each location. Use tabs to switch between locations.</p>
                </div>

                <!-- Location Copy Toolbar -->
                <div class="location-copy-toolbar" id="locationCopyToolbar" style="display:none;">
                    <div class="copy-toolbar-content">
                        <i class="fa-solid fa-copy"></i>
                        <span class="copy-toolbar-text">Save time! Copy data from another location:</span>
                        <select id="copyFromLocSelect" class="copy-from-select">
                            <option value="">— Select a location —</option>
                        </select>
                        <button type="button" id="copyFromLocBtn" class="btn-copy-loc">
                            <i class="fa-solid fa-clone"></i> Copy Data
                        </button>
                    </div>
                    <div class="copy-toolbar-hint">
                        <i class="fa-solid fa-circle-info"></i> This will copy all field values from the selected
                        location into the current one. You can then edit only what's different.
                    </div>
                </div>

                <!-- JS generates tab buttons here -->
                <div class="location-tabs" id="locationTabs"></div>
                <!-- JS generates location panels here from template -->
                <div class="location-contents" id="locationContents"></div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <div class="form-step" data-step="3">
                <div class="step-header">
                    <h2><i class="fa-solid fa-shield-halved"></i> Step 3: Security & Operations</h2>
                    <p>Organization-wide security posture, identity, email, and IT operations.</p>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 1. IDENTITY & ACCESS MANAGEMENT (with Endpoint Security inside) -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-user-shield"></i></div>
                        <div>
                            <h3>Identity & Access Management</h3>
                            <p>Directory services, authentication, endpoint security & data protection</p>
                        </div>
                    </div>

                    <!-- AD / Workgroup -->
                    <div class="form-grid cols-2">
                        <div class="form-group">
                            <label>AD / Workgroup</label>
                            <select name="ad_workgroup">
                                <option value="">Select</option>
                                <option value="Active Directory">Active Directory</option>
                                <option value="Workgroup">Workgroup</option>
                                <option value="Both">Both</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type of AD</label>
                            <select name="ad_type">
                                <option value="">Select</option>
                                <option value="On-Prem">On-Prem AD</option>
                                <option value="Azure AD">Azure AD</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- MFA / SSO -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-key"></i> MFA / SSO Solution Implemented?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="mfa_sso" value="yes"
                                    class="eden-yn-trigger" data-target="mfa-details"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="mfa_sso" value="no"
                                    class="eden-yn-trigger" data-target="mfa-details"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="mfa-details" style="display:none;">
                        <div class="form-group"><label>MFA/SSO Solution Name</label><input type="text"
                                name="mfa_solution" placeholder="e.g. Okta, Microsoft Entra"></div>
                    </div>

                    <!-- DLP -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-shield-virus"></i> DLP (Data Leak
                            Prevention)?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="dlp" value="yes"
                                    class="eden-yn-trigger" data-target="dlp-details"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="dlp" value="no"
                                    class="eden-yn-trigger" data-target="dlp-details"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="dlp-details" style="display:none;">
                        <div class="form-group">
                            <label>Where is DLP Implemented?</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label"><input type="checkbox" name="dlp_where[]" value="Email">
                                    Email</label>
                                <label class="checkbox-label"><input type="checkbox" name="dlp_where[]"
                                        value="Endpoint"> Endpoint</label>
                                <label class="checkbox-label"><input type="checkbox" name="dlp_where[]"
                                        value="Cloud Apps"> Cloud Apps</label>
                                <label class="checkbox-label"><input type="checkbox" name="dlp_where[]" value="Network">
                                    Network</label>
                            </div>
                        </div>
                    </div>

                    <!-- PIM/PAM -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-user-lock"></i> PIM/PAM — Admin Access</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="pim_pam" value="yes">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="pim_pam" value="no"> No</label>
                        </div>
                    </div>

                    <!-- Data Classification -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-tags"></i> Data Classification?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="data_classification"
                                    value="yes" class="eden-yn-trigger" data-target="classification-details">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="data_classification" value="no"
                                    class="eden-yn-trigger" data-target="classification-details"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="classification-details" style="display:none;">
                        <div class="form-group">
                            <label>Classification Type</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="classification_type"
                                        value="Automatic"> Automatic</label>
                                <label class="radio-label"><input type="radio" name="classification_type"
                                        value="Manual"> Manual</label>
                            </div>
                        </div>
                    </div>

                    <!-- ───── ENDPOINT SECURITY (NESTED INSIDE IAM) ───── -->
                    <!-- ───── ENDPOINT SECURITY (NESTED INSIDE IAM) ───── -->
                    <div class="subsection-label" style="margin-top:24px;">Endpoint Security</div>

                    <div class="security-table-wrapper">
                        <table class="security-table">
                            <thead>
                                <tr>
                                    <th>Feature</th>
                                    <th style="width:140px;">Status</th>
                                    <th>Remarks / Solution Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                foreach ($sec_features as $key => $label):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo esc_html($label); ?>
                                        </td>
                                        <td>
                                            <div class="radio-group toggle-group">
                                                <label class="radio-label compact"><input type="radio"
                                                        name="<?php echo $key; ?>" value="yes"> Yes</label>
                                                <label class="radio-label compact"><input type="radio"
                                                        name="<?php echo $key; ?>" value="no"> No</label>
                                            </div>
                                        </td>
                                        <td><input type="text" name="<?php echo $key; ?>_remarks"
                                                placeholder="Solution name / remarks"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 2. IT OPERATIONS & TOOLS -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                        <div>
                            <h3>IT Operations & Tools</h3>
                            <p>Tools used for day-to-day IT management</p>
                        </div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label>Encryption Tool</label><input type="text" name="encryption_tool"
                                placeholder="e.g. BitLocker"></div>
                        <div class="form-group"><label>Patch Management Solution</label><input type="text"
                                name="patch_mgmt_solution" placeholder="e.g. WSUS, ManageEngine"></div>
                        <div class="form-group"><label>Remote Support Tool</label><input type="text"
                                name="remote_support_tool" placeholder="e.g. TeamViewer, AnyDesk"></div>
                        <div class="form-group"><label>Asset Management System</label><input type="text"
                                name="asset_mgmt_system" placeholder="e.g. ServiceNow"></div>
                        <div class="form-group"><label>Log / SIEM System</label><input type="text" name="siem_system"
                                placeholder="e.g. Splunk, Wazuh"></div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 3. EMAIL & COLLABORATION                    -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
                        <div>
                            <h3>Email & Collaboration</h3>
                            <p>Email platform, security, and awareness training</p>
                        </div>
                    </div>

                    <!-- Email Platform + Licenses -->
                    <div class="form-grid cols-2">
                        <div class="form-group">
                            <label>Email & Collab Platform</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="email_platform"
                                        value="Microsoft 365" class="eden-yn-trigger" data-target="email-other"
                                        data-show-value="Other"> Microsoft 365</label>
                                <label class="radio-label"><input type="radio" name="email_platform" value="G-Suite"
                                        class="eden-yn-trigger" data-target="email-other" data-show-value="Other">
                                    G-Suite</label>
                                <label class="radio-label"><input type="radio" name="email_platform" value="Other"
                                        class="eden-yn-trigger" data-target="email-other" data-show-value="Other">
                                    Other</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>No. of Email Licenses</label>
                            <input type="number" name="num_email_users" min="0" placeholder="0">
                        </div>
                    </div>

                    <div class="conditional-field" id="email-other" style="display:none;">
                        <div class="form-group">
                            <label>Other Email Platform Name</label>
                            <input type="text" name="email_platform_other" placeholder="e.g. Zoho Mail">
                        </div>
                    </div>

                    <!-- Email Security Inbuilt → conditionally shows "Other Email Security" if No -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-shield"></i> Email Security Inbuilt
                            (M365)?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact">
                                <input type="radio" name="email_sec_inbuilt" value="yes" class="eden-yn-trigger"
                                    data-target="email-sec-other" data-show-value="no"> Yes
                            </label>
                            <label class="radio-label compact">
                                <input type="radio" name="email_sec_inbuilt" value="no" class="eden-yn-trigger"
                                    data-target="email-sec-other" data-show-value="no"> No
                            </label>
                        </div>
                    </div>

                    <div class="conditional-field" id="email-sec-other" style="display:none;">
                        <div class="form-group">
                            <label>Any Other Email Security Solution</label>
                            <input type="text" name="email_security_solution" placeholder="e.g. Proofpoint, Mimecast">
                        </div>
                    </div>

                    <!-- Email Backup -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-cloud-arrow-up"></i> Email Backup?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="email_backup" value="yes">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="email_backup" value="no">
                                No</label>
                        </div>
                    </div>

                    <!-- Email Archival -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-box-archive"></i> Email Archival?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="email_archival" value="yes">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="email_archival" value="no">
                                No</label>
                        </div>
                    </div>

                    <!-- Email Encryption (conditional) -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-lock"></i> Email Encryption?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact">
                                <input type="radio" name="email_encryption" value="yes" class="eden-yn-trigger"
                                    data-target="email-enc-details"> Yes
                            </label>
                            <label class="radio-label compact">
                                <input type="radio" name="email_encryption" value="no" class="eden-yn-trigger"
                                    data-target="email-enc-details"> No
                            </label>
                        </div>
                    </div>

                    <div class="conditional-field" id="email-enc-details" style="display:none;">
                        <div class="form-group">
                            <label>Encryption Solution</label>
                            <input type="text" name="email_encryption_solution" placeholder="e.g. Virtru, PGP">
                        </div>
                    </div>

                    <!-- Security Awareness Training -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-graduation-cap"></i> Security Awareness
                            Training?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="security_awareness_training"
                                    value="yes"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="security_awareness_training"
                                    value="no"> No</label>
                        </div>
                    </div>

                    <!-- Phishing Simulation -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-fish"></i> Phishing Simulation?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="phishing_sim" value="yes">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="phishing_sim" value="no">
                                No</label>
                        </div>
                    </div>

                    <!-- DMARC -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-envelope-circle-check"></i> DMARC?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="dmarc" value="yes"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="dmarc" value="no"> No</label>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 4. SIEM / SOC -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-radar"></i></div>
                        <div>
                            <h3>SIEM / Security Operations Center (SOC)</h3>
                            <p>Monitoring and incident response capabilities</p>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-magnifying-glass-chart"></i> SIEM Solution
                            Deployed?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="siem_deployed" value="yes"
                                    class="eden-yn-trigger" data-target="siem-details"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="siem_deployed" value="no"
                                    class="eden-yn-trigger" data-target="siem-details"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="siem-details" style="display:none;">
                        <div class="form-grid cols-2">
                            <div class="form-group">
                                <label>SIEM Deployment</label>
                                <div class="radio-group">
                                    <label class="radio-label"><input type="radio" name="siem_deployment"
                                            value="On-Prem"> On-Prem</label>
                                    <label class="radio-label"><input type="radio" name="siem_deployment" value="Cloud">
                                        Cloud</label>
                                    <label class="radio-label"><input type="radio" name="siem_deployment"
                                            value="Hybrid"> Hybrid</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>SIEM OEM Name</label>
                                <input type="text" name="siem_oem" placeholder="e.g. Splunk, IBM QRadar, Wazuh">
                            </div>
                        </div>
                    </div>

                    <!-- SOC 24/7 FIRST, then SOC Type conditional -->
                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-clock"></i> SOC Monitoring 24/7?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="soc_247" value="yes"
                                    class="eden-yn-trigger" data-target="soc-type-details"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="soc_247" value="no"
                                    class="eden-yn-trigger" data-target="soc-type-details"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="soc-type-details" style="display:none;">
                        <div class="form-grid cols-2">
                            <div class="form-group">
                                <label>SOC Type</label>
                                <div class="radio-group">
                                    <label class="radio-label"><input type="radio" name="soc_type" value="In-house">
                                        In-house</label>
                                    <label class="radio-label"><input type="radio" name="soc_type" value="Managed">
                                        Managed</label>
                                    <label class="radio-label"><input type="radio" name="soc_type" value="Hybrid">
                                        Hybrid</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>SOC OEM Name</label>
                                <input type="text" name="soc_oem" placeholder="e.g. Splunk, ArcSight, Sentinel">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 5. BACKUP & DISASTER RECOVERY -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-cloud-arrow-down"></i></div>
                        <div>
                            <h3>Backup & Disaster Recovery</h3>
                            <p>Data protection and recovery solutions</p>
                        </div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label>Server Backup Solution</label><input type="text"
                                name="server_backup_solution" placeholder="e.g. Veeam, Acronis"></div>
                        <div class="form-group"><label>Endpoint Backup Solution</label><input type="text"
                                name="endpoint_backup_solution" placeholder="e.g. Druva, CrashPlan"></div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-hard-drive"></i> NAS Backup?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="nas_backup" value="yes">
                                Yes</label>
                            <label class="radio-label compact"><input type="radio" name="nas_backup" value="no">
                                No</label>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-users-rectangle"></i> M365 / G-Suite Collab
                            Backup?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="m365_collab_backup"
                                    value="yes"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="m365_collab_backup" value="no">
                                No</label>
                        </div>
                    </div>
                </div>

                <!-- ═══════════════════════════════════════════ -->
                <!-- 6. COMPLIANCE -->
                <!-- ═══════════════════════════════════════════ -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fa-solid fa-file-contract"></i></div>
                        <div>
                            <h3>Compliance & Standards</h3>
                            <p>Regulatory and industry compliances followed</p>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fa-solid fa-clipboard-check"></i> Does your organization
                            follow any compliances?</label>
                        <div class="radio-group toggle-group">
                            <label class="radio-label compact"><input type="radio" name="has_compliance" value="yes"
                                    class="eden-yn-trigger" data-target="compliance-details"> Yes</label>
                            <label class="radio-label compact"><input type="radio" name="has_compliance" value="no"
                                    class="eden-yn-trigger" data-target="compliance-details"> No</label>
                        </div>
                    </div>

                    <div class="conditional-field" id="compliance-details" style="display:none;">
                        <div class="form-group">
                            <label>Select all that apply</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]"
                                        value="ISO 27001"> ISO 27001</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]"
                                        value="SOC Type 1"> SOC Type 1</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]"
                                        value="SOC Type 2"> SOC Type 2</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="GDPR">
                                    GDPR</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="HIPAA">
                                    HIPPA</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="CSCRF">
                                    CSCRF</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="RBI">
                                    RBI</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="SEBI">
                                    SEBI</label>
                                <label class="checkbox-label"><input type="checkbox" name="compliances[]" value="DPDP">
                                    DPDP</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consent + Buttons (KEEP YOUR EXISTING ONES BELOW THIS) -->



                <!-- ─── Actions ─── -->
                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Review &amp; Submit <i
                            class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div> <!-- end form-step data-step="3" -->
            <!-- ═══════════════════════════════════════════ -->
            <!-- STEP 4: REVIEW & SUBMIT                     -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="form-step" data-step="4">
                <div class="step-header">
                    <h2><i class="fa-solid fa-clipboard-check"></i> Step 4: Review Your Information</h2>
                    <p>Please review everything below. Click <strong>Edit</strong> on any section to make changes before
                        submitting.</p>
                </div>

                <!-- Review Container — populated by JS -->
                <div id="reviewContainer" class="review-container">
                    <div class="review-loading">
                        <i class="fa-solid fa-spinner fa-spin"></i> Generating review...
                    </div>
                </div>

                <!-- Consent — moved here from Step 3 -->
                <div class="form-consent">
                    <label class="checkbox-label">
                        <input type="checkbox" id="consent_checkbox" name="consent">
                        <span>I consent to Eden Infosol collecting and processing this data for IT assessment purposes.
                    </label>
                    <div class="field-error" id="consent-error"></div>
                </div>

                <!-- Final Actions -->
                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Back to Edit</button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text"><i class="fa-solid fa-paper-plane"></i> Submit Assessment</span>
                        <span class="btn-loading" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i>
                            Submitting...</span>
                    </button>
                </div>
            </div>
    </div>
    </form>

    <!-- Save Progress -->
    <div class="save-progress-bar">
        <button type="button" class="btn-save" id="saveProgressBtn"><i class="fas fa-floppy-disk"></i> Save
            Progress</button>
        <span class="save-status" id="saveStatus"></span>
    </div>

    </div>
</section>

<!-- ===== RESULTS SECTION ===== -->
<!-- ===== THANK YOU / CONFIRMATION SECTION ===== -->
<section class="eden-results-section" id="resultsSection" style="display:none;">
    <div class="eden-container">
        <div class="results-card">
            <div class="results-header">
                <div class="results-checkmark"><i class="fas fa-circle-check"></i></div>
                <h2>Submission Received!</h2>
                <p>Thank you, <strong id="resultClientName"></strong>. Your assessment has been submitted successfully.
                </p>
            </div>

            <div class="thank-you-message">
                <div class="thank-you-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                <h3>What Happens Next?</h3>
                <p>Our IT specialists will carefully analyze your infrastructure and security details. We'll reach out
                    to you within <strong>24 hours</strong> with a personalized analysis and tailored recommendations
                    for your organization.</p>
            </div>

            <div class="thank-you-steps">
                <div class="thank-you-step">
                    <div class="step-number">1</div>
                    <div>
                        <h4>Confirmation Email</h4>
                        <p>You'll receive a confirmation email at the address you provided.</p>
                    </div>
                </div>
                <div class="thank-you-step">
                    <div class="step-number">2</div>
                    <div>
                        <h4>Expert Review</h4>
                        <p>Our team reviews your IT environment and security posture.</p>
                    </div>
                </div>
                <div class="thank-you-step">
                    <div class="step-number">3</div>
                    <div>
                        <h4>Personalized Insights</h4>
                        <p>Within 24 hours, we'll share recommendations tailored to your needs.</p>
                    </div>
                </div>
            </div>

            <div class="results-actions">
                <a href="<?php echo esc_url($contact_url); ?>" class="btn-consult">
                    <i class="fas fa-calendar-check"></i> Book Free Consultation
                </a>
                <a href="<?php echo esc_url($home_url); ?>" class="btn-download">
                    <i class="fas fa-home"></i> Back to Home
                </a>
            </div>

            <div class="results-footer">
                <p><i class="fas fa-envelope"></i> Questions? Reach us at <a
                        href="mailto:management@edeninfosol.com">management@edeninfosol.com</a></p>
            </div>
        </div>
    </div>
</section>

<script type="text/html" id="eden-loc-template">
<div class="location-panel" data-loc="{{IDX}}">

<div class="form-divider"><span>Location {{NUM}} — Basic Info</span></div>
<div class="form-grid cols-3">
<div class="form-group"><label>Location Name</label><input type="text" name="loc_{{IDX}}_name" placeholder="e.g. Mumbai HQ"></div>
<div class="form-group"><label>No. of Users</label><input type="number" name="loc_{{IDX}}_users" min="1" placeholder="e.g. 50"></div>
<div class="form-group"><label>Work Setup</label><select name="loc_{{IDX}}_work_setup"><option value="">Select</option><option value="Owned">Owned</option><option value="Rented">Rented</option><option value="Shared">Shared</option><option value="Business Center">Business Center</option></select></div>
</div>

<div class="section-toggles-grid">
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_connectivity"><i class="fas fa-globe"></i> <span>Connectivity &amp; WAN</span></label>
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_network"><i class="fas fa-network-wired"></i> <span>Network Infrastructure</span></label>
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_dc"><i class="fas fa-server"></i> <span>Data Centre &amp; Servers</span></label>
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_power"><i class="fas fa-bolt"></i> <span>Power &amp; Electrical</span></label>
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_security"><i class="fas fa-video"></i> <span>Physical Security</span></label>
<label class="section-toggle-card"><input type="checkbox" class="section-toggle" data-target="loc_{{IDX}}_sec_comms"><i class="fas fa-phone"></i> <span>Communication &amp; Collab</span></label>
</div>

<div class="toggle-section" id="loc_{{IDX}}_sec_connectivity">
<div class="form-divider"><span>Connectivity &amp; WAN Solutions</span></div>
<h4 class="sub-heading">Internet Connections</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of Internet Connections</label>
<input type="number" name="loc_{{IDX}}_num_internet" min="0" placeholder="e.g. 2" class="eden-qty-trigger" data-container="loc_{{IDX}}_internet_rows" data-tpl="internet" data-prefix="loc_{{IDX}}_internet"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_internet_rows"></div>
<h4 class="sub-heading">P2P Leased Lines</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of P2P Leased Lines</label>
<input type="number" name="loc_{{IDX}}_num_p2p" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_p2p_rows" data-tpl="p2p" data-prefix="loc_{{IDX}}_p2p"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_p2p_rows"></div>
<h4 class="sub-heading">Leased Lines</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of Leased Lines</label>
<input type="number" name="loc_{{IDX}}_num_leased" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_leased_rows" data-tpl="leased" data-prefix="loc_{{IDX}}_leased"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_leased_rows"></div>
</div>

<div class="toggle-section" id="loc_{{IDX}}_sec_network">
<div class="form-divider"><span>Network Infrastructure</span></div>
<div class="form-group"><label>Server / Network Room?</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_server_room" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_rack_section"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_server_room" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_rack_section"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_rack_section" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>No. of Racks</label>
<input type="number" name="loc_{{IDX}}_num_racks" min="0" placeholder="e.g. 2" class="eden-qty-trigger" data-container="loc_{{IDX}}_rack_rows" data-tpl="rack" data-prefix="loc_{{IDX}}_rack"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_rack_rows"></div>
</div>
<h4 class="sub-heading">Routers & Firewalls</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:35%;">Device</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-route"></i> Owned Routers</td>
                <td><input type="number" name="loc_{{IDX}}_num_owned_routers" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_owned_routers_oem" placeholder="e.g. Cisco, MikroTik"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-cloud-arrow-down"></i> ISP-Provided Routers</td>
                <td><input type="number" name="loc_{{IDX}}_num_isp_routers" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_isp_routers_oem" placeholder="e.g. ISP-provided model"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-shield-halved"></i> Firewalls</td>
                <td><input type="number" name="loc_{{IDX}}_num_firewalls" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_firewalls_oem" placeholder="e.g. SonicWall, Fortinet"></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- VPN & SD-WAN — kept as Y/N rows since they're capability questions, not devices -->
<div class="subsection-label" style="margin-top:18px;">Network Features</div>

<div class="yn-row">
    <label class="yn-label"><i class="fa-solid fa-network-wired"></i> Firewall-based SD-WAN?</label>
    <div class="radio-group toggle-group">
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_sd_wan" value="yes"> Yes</label>
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_sd_wan" value="no"> No</label>
    </div>
</div>

<div class="yn-row">
    <label class="yn-label"><i class="fa-solid fa-arrows-left-right-to-line"></i> Site-to-Site VPN?</label>
    <div class="radio-group toggle-group">
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_s2s_vpn" value="yes"> Yes</label>
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_s2s_vpn" value="no"> No</label>
    </div>
</div>

<div class="yn-row">
    <label class="yn-label"><i class="fa-solid fa-laptop-arrow-down"></i> Point-to-Site VPN?</label>
    <div class="radio-group toggle-group">
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_p2s_vpn" value="yes"> Yes</label>
        <label class="radio-label compact"><input type="radio" name="loc_{{IDX}}_p2s_vpn" value="no"> No</label>
    </div>
</div>

<h4 class="sub-heading">Network Switches</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:35%;">Switch Type</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-network-wired"></i> Core Switches (L3)</td>
                <td><input type="number" name="loc_{{IDX}}_core_sw_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_core_sw_oem" placeholder="e.g. Cisco, HP Aruba"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-sitemap"></i> Distribution Switches</td>
                <td><input type="number" name="loc_{{IDX}}_dist_sw_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_dist_sw_oem" placeholder="e.g. Cisco, Juniper"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-diagram-project"></i> Access Layer Switches</td>
                <td><input type="number" name="loc_{{IDX}}_access_sw_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_access_sw_oem" placeholder="e.g. Cisco, HP, Netgear"></td>
            </tr>
        </tbody>
    </table>
</div>
<h4 class="sub-heading">WiFi / Access Points</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:35%;">AP Type</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-wifi"></i> Standalone AP</td>
                <td><input type="number" name="loc_{{IDX}}_standalone_ap_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_standalone_ap_oem" placeholder="e.g. Ubiquiti, TP-Link"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-tower-broadcast"></i> Controller-Based AP</td>
                <td><input type="number" name="loc_{{IDX}}_controller_ap_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_controller_ap_oem" placeholder="e.g. Cisco Meraki, Aruba"></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<div class="toggle-section" id="loc_{{IDX}}_sec_dc">
<div class="form-divider"><span>Data Centre &amp; Server Infrastructure</span></div>
<div class="form-grid cols-2">
<div class="form-group"><label><input type="checkbox" name="loc_{{IDX}}_has_phys_nonvirt" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_phys_nonvirt_sec"> Physical Servers (Non-Virtualized)</label></div>
<div class="form-group"><label><input type="checkbox" name="loc_{{IDX}}_has_phys_virt" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_phys_virt_sec"> Physical Servers (Virtualized)</label></div>
</div>
<div class="conditional-field" id="loc_{{IDX}}_phys_nonvirt_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>Quantity</label><input type="number" name="loc_{{IDX}}_phys_nonvirt_qty" min="0" placeholder="0"></div></div>
</div>
<div class="conditional-field" id="loc_{{IDX}}_phys_virt_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>Quantity</label><input type="number" name="loc_{{IDX}}_phys_virt_qty" min="0" placeholder="0"></div></div>
</div>
<div class="form-grid cols-3">
<div class="form-group"><label>Hypervisor</label><select name="loc_{{IDX}}_hypervisor"><option value="">Select</option><option value="VMware">VMware vSphere/ESXi</option><option value="Hyper-V">Microsoft Hyper-V</option><option value="Citrix">Citrix XenServer</option><option value="KVM">KVM</option><option value="Proxmox">Proxmox</option><option value="Other">Other</option><option value="None">None</option></select></div>
<div class="form-group"><label>Windows VMs</label><input type="number" name="loc_{{IDX}}_vm_windows" min="0" placeholder="0"></div>
<div class="form-group"><label>Linux VMs</label><input type="number" name="loc_{{IDX}}_vm_linux" min="0" placeholder="0"></div>
</div>
<!-- SAN Storage -->
<div class="subsection-label">SAN Storage</div>
<div class="yn-row">
    <label class="yn-label"><i class="fa-solid fa-server"></i> Do you have SAN Storage?</label>
    <div class="radio-group toggle-group">
        <label class="radio-label compact">
            <input type="radio" name="has_san_{{IDX}}" value="yes" class="eden-yn-trigger" data-target="san-details-{{IDX}}"> Yes
        </label>
        <label class="radio-label compact">
            <input type="radio" name="has_san_{{IDX}}" value="no" class="eden-yn-trigger" data-target="san-details-{{IDX}}"> No
        </label>
    </div>
</div>

<div class="conditional-field" id="san-details-{{IDX}}" style="display:none;">
    <div class="form-grid cols-3">
        <div class="form-group">
            <label>No. of Drives</label>
            <input type="number" name="san_num_drives_{{IDX}}" min="0" placeholder="e.g. 12"
                   class="eden-qty-trigger"
                   data-container="san-drives-{{IDX}}"
                   data-tpl="sandrive"
                   data-prefix="san_drive_{{IDX}}">
        </div>
        <div class="form-group">
            <label>Total Raw Capacity</label>
            <input type="text" name="san_raw_capacity_{{IDX}}" placeholder="e.g. 100 TB">
        </div>
        <div class="form-group">
            <label>Total Usable Capacity</label>
            <input type="text" name="san_usable_capacity_{{IDX}}" placeholder="e.g. 80 TB">
        </div>
    </div>

    <div class="subsection-label" style="margin-top:14px;">Drive Type (per drive)</div>
    <div id="san-drives-{{IDX}}" class="dynamic-rows"></div>
</div>
<div class="form-group"><label>NAS Storage</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_nas" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_nas_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_nas" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_nas_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_nas_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>NAS Make &amp; Model</label><input type="text" name="loc_{{IDX}}_nas_makemodel" placeholder="e.g. Synology RS3621"></div></div>
</div>
<div class="form-group"><label>Hyper-Converged Infrastructure (HCI)</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_hci" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_hci_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_hci" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_hci_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_hci_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>HCI Solution</label><input type="text" name="loc_{{IDX}}_hci_solution" placeholder="e.g. Nutanix, vSAN"></div></div>
</div>
<div class="form-group"><label>IP-Based KVM</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_kvm" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_kvm_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_kvm" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_kvm_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_kvm_sec" style="display:none;">
<div class="form-grid cols-4">
<div class="form-group"><label>No. of Ports</label><input type="number" name="loc_{{IDX}}_kvm_ports" min="0" placeholder="0"></div>
<div class="form-group"><label>No. of Remote Users</label><input type="number" name="loc_{{IDX}}_kvm_remote" min="0" placeholder="0"></div>
<div class="form-group"><label>Make</label><input type="text" name="loc_{{IDX}}_kvm_make" placeholder="Make"></div>
<div class="form-group"><label>Model</label><input type="text" name="loc_{{IDX}}_kvm_model" placeholder="Model"></div>
</div></div>
<div class="form-group"><label>Serial Console Devices</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_serial" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_serial_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_serial" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_serial_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_serial_sec" style="display:none;">
<div class="form-grid cols-3">
<div class="form-group"><label>No. of Ports</label><input type="number" name="loc_{{IDX}}_serial_ports" min="0" placeholder="0"></div>
<div class="form-group"><label>Make</label><input type="text" name="loc_{{IDX}}_serial_make" placeholder="Make"></div>
<div class="form-group"><label>Model</label><input type="text" name="loc_{{IDX}}_serial_model" placeholder="Model"></div>
</div></div>
</div>

<!-- ═══════════════════════════════════════════ -->
<!-- POWER & ELECTRICAL                          -->
<!-- ═══════════════════════════════════════════ -->
<div class="toggle-section" id="loc_{{IDX}}_sec_power">
    <div class="form-divider"><span>Power &amp; Electrical Infrastructure</span></div>

    <!-- UPS / Power Backup -->
    <div class="subsection-label">UPS &amp; Power Backup</div>

    <div class="yn-row">
        <label class="yn-label"><i class="fa-solid fa-plug-circle-bolt"></i> Do you have UPS installed?</label>
        <div class="radio-group toggle-group">
            <label class="radio-label compact">
                <input type="radio" name="has_ups_{{IDX}}" value="yes" class="eden-yn-trigger" data-target="ups-details-{{IDX}}"> Yes
            </label>
            <label class="radio-label compact">
                <input type="radio" name="has_ups_{{IDX}}" value="no" class="eden-yn-trigger" data-target="ups-details-{{IDX}}"> No
            </label>
        </div>
    </div>

    <div class="conditional-field" id="ups-details-{{IDX}}" style="display:none;">
        <div class="form-grid cols-3">
            <div class="form-group">
                <label>Quantity (No. of UPS Units)</label>
                <input type="number" name="ups_quantity_{{IDX}}" min="0" placeholder="e.g. 2">
            </div>
            <div class="form-group">
                <label>UPS Type</label>
                <select name="ups_type_{{IDX}}">
                    <option value="">Select</option>
                    <option value="Online">Online</option>
                    <option value="Line-Interactive">Line-Interactive</option>
                    <option value="Offline">Offline / Standby</option>
                </select>
            </div>
            <div class="form-group">
                <label>UPS Mode</label>
                <select name="ups_mode_{{IDX}}">
                    <option value="">Select</option>
                    <option value="Single-Phase">Single-Phase</option>
                    <option value="Three-Phase">Three-Phase</option>
                </select>
            </div>
            <div class="form-group">
                <label>Total UPS Capacity</label>
                <input type="text" name="ups_capacity_{{IDX}}" placeholder="e.g. 10 KVA">
            </div>
            <div class="form-group">
                <label>Backup Time</label>
                <input type="text" name="ups_backup_time_{{IDX}}" placeholder="e.g. 30 minutes">
            </div>
            <div class="form-group">
                <label>UPS Make / Model</label>
                <input type="text" name="ups_make_model_{{IDX}}" placeholder="e.g. APC Smart-UPS 3000">
            </div>
        </div>
    </div>
</div>
<!-- ↑↑↑ END POWER & ELECTRICAL ↑↑↑ -->


<!-- ═══════════════════════════════════════════ -->
<!-- PHYSICAL SECURITY & SAFETY                  -->
<!-- ═══════════════════════════════════════════ -->
<div class="toggle-section" id="loc_{{IDX}}_sec_security">
    <div class="form-divider"><span>Physical Security &amp; Safety</span></div>

    <h4 class="sub-heading">CCTV Surveillance</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:35%;">Equipment</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-hard-drive"></i> NVR / DVR Units</td>
                <td><input type="number" name="loc_{{IDX}}_nvr_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_nvr_oem" placeholder="e.g. Hikvision, Dahua"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-video"></i> IP Cameras</td>
                <td><input type="number" name="loc_{{IDX}}_ip_cameras" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_ip_cameras_oem" placeholder="e.g. Hikvision, Axis"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-camera-retro"></i> Analog Cameras</td>
                <td><input type="number" name="loc_{{IDX}}_analog_cameras" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_analog_cameras_oem" placeholder="e.g. CP Plus, Honeywell"></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Storage & Retention details below table -->
<div class="form-grid cols-2" style="margin-top:14px;">
    <div class="form-group">
        <label>Total Storage Capacity</label>
        <input type="text" name="loc_{{IDX}}_cctv_storage" placeholder="e.g. 4 TB">
    </div>
    <div class="form-group">
        <label>Retention Period</label>
        <input type="text" name="loc_{{IDX}}_cctv_retention" placeholder="e.g. 30 days">
    </div>
</div>

    <h4 class="sub-heading">Biometric / Access Control</h4>
    <div class="form-grid cols-4">
        <div class="form-group">
            <label>Type</label>
            <select name="loc_{{IDX}}_bio_type">
                <option value="">Select</option>
                <option value="Standalone">Standalone</option>
                <option value="Centralised">Centralised</option>
            </select>
        </div>
        <div class="form-group"><label>No. of Devices</label><input type="number" name="loc_{{IDX}}_bio_qty" min="0" placeholder="0"></div>
        <div class="form-group"><label>Make &amp; Model</label><input type="text" name="loc_{{IDX}}_bio_makemodel" placeholder="Make Model"></div>
        <div class="form-group"><label>Areas Covered</label><input type="text" name="loc_{{IDX}}_bio_areas" placeholder="e.g. Main entry, Server room"></div>
    </div>

    <!-- Fire Safety -->
    <div class="subsection-label">Fire Safety</div>

    <div class="yn-row">
        <label class="yn-label"><i class="fa-solid fa-fire-flame-curved"></i> Fire Alarm System</label>
        <div class="radio-group toggle-group">
            <label class="radio-label compact"><input type="radio" name="fire_alarm_system_{{IDX}}" value="yes"> Yes</label>
            <label class="radio-label compact"><input type="radio" name="fire_alarm_system_{{IDX}}" value="no"> No</label>
        </div>
    </div>
    <div class="yn-row">
    <label class="yn-label"><i class="fa-solid fa-fire-flame-curved"></i> Fire Alarm System Office</label>
    <div class="radio-group toggle-group">
        <label class="radio-label compact"><input type="radio" name="fire_alarm_system_office_{{IDX}}" value="yes"> Yes</label>
        <label class="radio-label compact"><input type="radio" name="fire_alarm_system_office_{{IDX}}" value="no"> No</label>
    </div>
</div>
    <div class="yn-row">
        <label class="yn-label"><i class="fa-solid fa-fire-extinguisher"></i> Fire Extinguishers Present?</label>
        <div class="radio-group toggle-group">
            <label class="radio-label compact">
                <input type="radio" name="has_extinguishers_{{IDX}}" value="yes" class="eden-yn-trigger" data-target="ext-details-{{IDX}}"> Yes
            </label>
            <label class="radio-label compact">
                <input type="radio" name="has_extinguishers_{{IDX}}" value="no" class="eden-yn-trigger" data-target="ext-details-{{IDX}}"> No
            </label>
        </div>
    </div>
    

    <div class="conditional-field" id="ext-details-{{IDX}}" style="display:none;">
        <div class="form-grid cols-2">
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="ext_quantity_{{IDX}}" min="0" placeholder="e.g. 4"
                       class="eden-qty-trigger"
                       data-container="ext-rows-{{IDX}}"
                       data-tpl="extinguisher"
                       data-prefix="ext_{{IDX}}"
                       data-label="Extinguisher">
            </div>
        </div>
        <div class="subsection-label" style="margin-top:10px;">Make &amp; Model (per extinguisher)</div>
        <div id="ext-rows-{{IDX}}" class="dynamic-rows"></div>
    </div>
</div>
<!-- ↑↑↑ END PHYSICAL SECURITY & SAFETY ↑↑↑ -->


<!-- ═══════════════════════════════════════════ -->
<!-- COMMUNICATION & COLLABORATION               -->
<!-- ═══════════════════════════════════════════ -->
<div class="toggle-section" id="loc_{{IDX}}_sec_comms">
    <div class="form-divider"><span>Communication &amp; Collaboration</span></div>

    <div class="form-grid cols-2">
        <div class="form-group">
            <label>EPABX</label>
            <div class="radio-group">
                <label class="radio-label"><input type="radio" name="loc_{{IDX}}_epabx" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_epabx_sec"> Yes</label>
                <label class="radio-label"><input type="radio" name="loc_{{IDX}}_epabx" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_epabx_sec"> No</label>
            </div>
        </div>
        <div class="form-group">
            <label>IP-PBX</label>
            <div class="radio-group">
                <label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_pbx" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_ip_pbx_sec"> Yes</label>
                <label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_pbx" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_ip_pbx_sec"> No</label>
            </div>
        </div>
    </div>

    <div class="conditional-field" id="loc_{{IDX}}_epabx_sec" style="display:none;">
        <div class="form-grid cols-2">
            <div class="form-group"><label>EPABX Make</label><input type="text" name="loc_{{IDX}}_epabx_make" placeholder="Make"></div>
            <div class="form-group"><label>EPABX Model</label><input type="text" name="loc_{{IDX}}_epabx_model" placeholder="Model"></div>
        </div>
    </div>

    <div class="conditional-field" id="loc_{{IDX}}_ip_pbx_sec" style="display:none;">
        <div class="form-grid cols-2">
            <div class="form-group"><label>IP-PBX Make</label><input type="text" name="loc_{{IDX}}_ip_pbx_make" placeholder="Make"></div>
            <div class="form-group"><label>IP-PBX Model</label><input type="text" name="loc_{{IDX}}_ip_pbx_model" placeholder="Model"></div>
        </div>
    </div>

    <h4 class="sub-heading">Phones</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:35%;">Phone Type</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-phone"></i> Analog Phones</td>
                <td><input type="number" name="loc_{{IDX}}_analog_phones" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_analog_phones_oem" placeholder="e.g. Panasonic, Beetel"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-phone-volume"></i> IP Phones</td>
                <td><input type="number" name="loc_{{IDX}}_ip_phones" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_ip_phones_oem" placeholder="e.g. Cisco, Yealink"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-mobile-screen-button"></i> Soft Phones</td>
                <td><input type="number" name="loc_{{IDX}}_soft_phones" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_soft_phones_oem" placeholder="e.g. Zoom Phone, Teams"></td>
            </tr>
        </tbody>
    </table>
</div>
    <div class="form-group">
        <label>PA System</label>
        <div class="radio-group">
            <label class="radio-label"><input type="radio" name="loc_{{IDX}}_pa" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_pa_sec"> Yes</label>
            <label class="radio-label"><input type="radio" name="loc_{{IDX}}_pa" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_pa_sec"> No</label>
        </div>
    </div>

    <div class="conditional-field" id="loc_{{IDX}}_pa_sec" style="display:none;">
        <div class="form-grid cols-1">
            <div class="form-group"><label>PA Make &amp; Model</label><input type="text" name="loc_{{IDX}}_pa_mm" placeholder="Make Model"></div>
        </div>
    </div>

    <h4 class="sub-heading">Video Conferencing</h4>
    <div class="form-grid cols-1">
        <div class="form-group">
            <label>No. of Meeting Rooms (with VC)</label>
            <input type="number" name="loc_{{IDX}}_vc_rooms" data-label="Meeting Room" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_vc_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_vc">
        </div>
    </div>
    <div class="dynamic-rows" id="loc_{{IDX}}_vc_rows"></div>

   
<h4 class="sub-heading">End User Computing</h4>

<div class="security-table-wrapper">
    <table class="security-table eden-device-table">
        <thead>
            <tr>
                <th style="width:30%;">Device</th>
                <th style="width:120px;">Quantity</th>
                <th>OEM / Vendor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><i class="fa-solid fa-laptop"></i> Laptops</td>
                <td><input type="number" name="loc_{{IDX}}_laptops_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_laptops_oem" placeholder="e.g. Dell, HP, Lenovo"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-desktop"></i> Desktops</td>
                <td><input type="number" name="loc_{{IDX}}_desktops_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_desktops_oem" placeholder="e.g. Dell, HP, Lenovo"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-display"></i> Workstations</td>
                <td><input type="number" name="loc_{{IDX}}_workstations_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_workstations_oem" placeholder="e.g. HP Z-Series, Dell Precision"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-server"></i> Thin Clients</td>
                <td><input type="number" name="loc_{{IDX}}_thin_clients_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_thin_clients_oem" placeholder="e.g. Wyse, IGEL"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-tablet-screen-button"></i> Tablets</td>
                <td><input type="number" name="loc_{{IDX}}_tablets_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_tablets_oem" placeholder="e.g. iPad, Samsung"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-mobile-screen"></i> Phones (Company-Owned)</td>
                <td><input type="number" name="loc_{{IDX}}_co_phones_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_co_phones_oem" placeholder="e.g. Apple, Samsung"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-print"></i> Printers</td>
                <td><input type="number" name="loc_{{IDX}}_printers_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_printers_oem" placeholder="e.g. HP, Canon, Epson"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-scanner"></i> Scanners</td>
                <td><input type="number" name="loc_{{IDX}}_scanners_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_scanners_oem" placeholder="e.g. Canon, Epson"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-copy"></i> Multifunction Devices</td>
                <td><input type="number" name="loc_{{IDX}}_mfp_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_mfp_oem" placeholder="e.g. Xerox, Canon, Ricoh"></td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-headset"></i> Headsets</td>
                <td><input type="number" name="loc_{{IDX}}_headsets_qty" min="0" placeholder="0"></td>
                <td><input type="text" name="loc_{{IDX}}_headsets_oem" placeholder="e.g. Jabra, Plantronics"></td>
            </tr>
        </tbody>
    </table>
</div>
    </div>

    <div class="dynamic-rows" id="loc_{{IDX}}_laptops_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_desktops_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_workstations_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_thin_clients_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_tablets_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_co_phones_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_printers_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_scanners_rows"></div>
    <div class="dynamic-rows" id="loc_{{IDX}}_mfp_rows"></div>

   
</div>
<!-- ↑↑↑ END COMMUNICATION & COLLABORATION ↑↑↑ -->
 </div>
</script><?php get_footer(); ?>