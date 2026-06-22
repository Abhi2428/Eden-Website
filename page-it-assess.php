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

<!-- TRUST BAR -->
<div class="eden-trust-bar">
    <div class="eden-container">
        <div class="trust-item"><i class="fas fa-circle-check"></i> <strong>500+</strong> Assessments</div>
        <div class="trust-item"><i class="fas fa-building"></i> <strong>200+</strong> Clients</div>
        <div class="trust-item"><i class="fas fa-star"></i> <strong>99%</strong> Satisfaction</div>
        <div class="trust-item"><i class="fas fa-lock"></i> <strong>100%</strong> Secure</div>
    </div>
</div>

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
                    <div class="step-circle">1</div><span>Organization</span>
                </div>
                <div class="progress-step" data-step="2">
                    <div class="step-circle">2</div><span>Location Infrastructure</span>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-circle">3</div><span>Security &amp; Operations</span>
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

                <!-- JS generates tab buttons here -->
                <div class="location-tabs" id="locationTabs"></div>
                <!-- JS generates location panels here from template -->
                <div class="location-contents" id="locationContents"></div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fas fa-arrow-right"></i></button>
                </div>
            </div>

            <!-- ══════ STEP 3: Security & Operations ══════ -->
            <div class="form-step" data-step="3">
                <div class="step-header">
                    <h2><i class="fas fa-shield-halved"></i> Step 3: Security &amp; Operations</h2>
                    <p>Organization-wide security posture, email, and IT operations.</p>
                </div>

                <!-- ─── CARD: Endpoint Security ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-shield-halved"></i></div>
                        <div>
                            <h3>Endpoint Security</h3>
                            <p>Security solutions protecting your endpoints</p>
                        </div>
                    </div>

                    <div class="form-grid cols-2">
                        <div class="form-group"><label>AD / Workgroup</label>
                            <select name="ad_workgroup">
                                <option value="">Select</option>
                                <option value="Active Directory">Active Directory</option>
                                <option value="Workgroup">Workgroup</option>
                                <option value="Both">Both</option>
                            </select>
                        </div>
                        <div class="form-group"><label>Type of AD</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="On-Prem">
                                    On-Prem</label>
                                <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="Azure AD">
                                    Azure AD</label>
                                <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="Hybrid">
                                    Hybrid</label>
                            </div>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fas fa-shield-check"></i> Do you have an Endpoint Security
                            Solution?</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="endpoint_security" value="yes"
                                    class="eden-yn-trigger" data-target="endpoint_sec_details"> Yes</label>
                            <label class="radio-label"><input type="radio" name="endpoint_security" value="no"
                                    class="eden-yn-trigger" data-target="endpoint_sec_details"> No</label>
                        </div>
                    </div>

                    <div class="conditional-field" id="endpoint_sec_details" style="display:none;">
                        <div class="security-table-wrapper">
                            <table class="security-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-shield-halved"></i> Feature</th>
                                        <th>Status</th>
                                        <th>Remarks / Solution Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Antivirus / Anti-malware</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_antivirus" value="yes"> Yes</label><label
                                                    class="radio-label compact"><input type="radio" name="sec_antivirus"
                                                        value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_antivirus_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Endpoint Firewall</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_endpoint_firewall" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_endpoint_firewall" value="no" checked> No</label>
                                            </div>
                                        </td>
                                        <td><input type="text" name="sec_endpoint_firewall_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Application Control</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_app_control" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_app_control" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_app_control_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Device Control</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_device_control" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_device_control" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_device_control_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Vulnerability Assessment</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_vuln_assessment" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_vuln_assessment" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_vuln_assessment_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Patch Management</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_patch_mgmt" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_patch_mgmt" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_patch_mgmt_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> SIEM Integration</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_siem" value="yes"> Yes</label><label
                                                    class="radio-label compact"><input type="radio" name="sec_siem"
                                                        value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_siem_remarks" placeholder="Solution name...">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Encryption</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_encryption" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_encryption" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_encryption_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> EDR / XDR</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_edr_xdr" value="yes"> Yes</label><label
                                                    class="radio-label compact"><input type="radio" name="sec_edr_xdr"
                                                        value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_edr_xdr_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Software Control</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_software_control" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_software_control" value="no" checked> No</label></div>
                                        </td>
                                        <td><input type="text" name="sec_software_control_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-shield-halved"></i> Inventory Tracking</td>
                                        <td>
                                            <div class="toggle-group"><label class="radio-label compact"><input
                                                        type="radio" name="sec_inventory_tracking" value="yes">
                                                    Yes</label><label class="radio-label compact"><input type="radio"
                                                        name="sec_inventory_tracking" value="no" checked> No</label>
                                            </div>
                                        </td>
                                        <td><input type="text" name="sec_inventory_tracking_remarks"
                                                placeholder="Solution name..."></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ─── CARD: IT Operations & Tools ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-toolbox"></i></div>
                        <div>
                            <h3>IT Operations &amp; Tools</h3>
                            <p>Tools used for day-to-day IT management</p>
                        </div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label for="encryption_tool">Encryption Tool</label><input type="text"
                                id="encryption_tool" name="encryption_tool" placeholder="e.g. BitLocker, VeraCrypt">
                        </div>
                        <div class="form-group"><label for="patch_mgmt_solution">Patch Management Solution</label><input
                                type="text" id="patch_mgmt_solution" name="patch_mgmt_solution"
                                placeholder="e.g. WSUS, ManageEngine"></div>
                        <div class="form-group"><label for="remote_support_tool">Remote Support Tool</label><input
                                type="text" id="remote_support_tool" name="remote_support_tool"
                                placeholder="e.g. AnyDesk, TeamViewer"></div>
                        <div class="form-group"><label for="asset_mgmt_system">Asset Management System</label><input
                                type="text" id="asset_mgmt_system" name="asset_mgmt_system"
                                placeholder="e.g. ServiceNow, GLPI"></div>
                        <div class="form-group"><label for="siem_system">Log / SIEM System</label><input type="text"
                                id="siem_system" name="siem_system" placeholder="e.g. Splunk, Wazuh"></div>
                    </div>
                </div>

                <!-- ─── CARD: Identity & Access Management ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-user-shield"></i></div>
                        <div>
                            <h3>Identity &amp; Access Management</h3>
                            <p>Directory services, authentication, and data protection</p>
                        </div>
                    </div>

                    <div class="form-grid cols-2">
                        <div class="form-group"><label for="ad_type_select">Type of AD</label>
                            <select id="ad_type_select" name="ad_type_select">
                                <option value="">Select</option>
                                <option value="On-Prem AD">On-Prem AD</option>
                                <option value="Azure AD">Azure AD</option>
                                <option value="Hybrid">Hybrid</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group"><label for="other_iam">Other IAM Solution</label>
                            <input type="text" id="other_iam" name="other_iam"
                                placeholder="e.g. ScaleFusion / Okta / JumpCloud">
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fas fa-sitemap"></i> Active Directory</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="active_directory" value="yes"
                                    class="eden-yn-trigger" data-target="ad_details_sec"> Yes</label>
                            <label class="radio-label"><input type="radio" name="active_directory" value="no"
                                    class="eden-yn-trigger" data-target="ad_details_sec"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="ad_details_sec" style="display:none;">
                        <div class="form-group"><label>Microsoft AD Deployment</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="ms_ad_deployment" value="On-Prem">
                                    On-Prem</label>
                                <label class="radio-label"><input type="radio" name="ms_ad_deployment" value="Cloud">
                                    Cloud</label>
                            </div>
                        </div>
                        <div class="form-group"><label>Directory Services</label>
                            <div class="checkbox-group">
                                <label class="checkbox-label"><input type="checkbox" name="dir_services[]"
                                        value="Entra-ID-Free"> Entra-ID-Free</label>
                                <label class="checkbox-label"><input type="checkbox" name="dir_services[]"
                                        value="Entra-ID-P1"> Entra-ID-P1</label>
                                <label class="checkbox-label"><input type="checkbox" name="dir_services[]"
                                        value="Entra-ID-P2"> Entra-ID-P2</label>
                                <label class="checkbox-label"><input type="checkbox" name="dir_services[]"
                                        value="G-Suite"> G-Suite</label>
                                <label class="checkbox-label"><input type="checkbox" name="dir_services[]"
                                        value="Other LDAP"> Other LDAP</label>
                            </div>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fas fa-key"></i> MFA / SSO Solution</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="mfa_sso" value="yes"
                                    class="eden-yn-trigger" data-target="mfa_details_sec"> Yes</label>
                            <label class="radio-label"><input type="radio" name="mfa_sso" value="no"
                                    class="eden-yn-trigger" data-target="mfa_details_sec"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="mfa_details_sec" style="display:none;">
                        <div class="form-grid cols-2">
                            <div class="form-group"><label for="mfa_solution">MFA/SSO Solution</label><input type="text"
                                    id="mfa_solution" name="mfa_solution" placeholder="e.g. Duo, Azure MFA"></div>
                            <div class="form-group"><label>Company Data Only on Company Devices?</label>
                                <div class="radio-group">
                                    <label class="radio-label"><input type="radio" name="company_devices_only"
                                            value="yes"> Yes</label>
                                    <label class="radio-label"><input type="radio" name="company_devices_only"
                                            value="no"> No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fas fa-eye-slash"></i> DLP (Data Leak Prevention)</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="dlp_enabled" value="yes"
                                    class="eden-yn-trigger" data-target="dlp_details_sec"> Yes</label>
                            <label class="radio-label"><input type="radio" name="dlp_enabled" value="no"
                                    class="eden-yn-trigger" data-target="dlp_details_sec"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="dlp_details_sec" style="display:none;">
                        <div class="form-group"><label>Where is DLP Implemented?</label>
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

                    <div class="form-grid cols-2" style="margin-top:10px;">
                        <div class="yn-row">
                            <label class="yn-label"><i class="fas fa-user-lock"></i> PIM/PAM — Admin Access</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="pim_pam" value="yes"> Yes</label>
                                <label class="radio-label"><input type="radio" name="pim_pam" value="no"> No</label>
                            </div>
                        </div>
                        <div class="yn-row">
                            <label class="yn-label"><i class="fas fa-tags"></i> Data Classification</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="data_classification" value="yes"
                                        class="eden-yn-trigger" data-target="data_class_sec"> Yes</label>
                                <label class="radio-label"><input type="radio" name="data_classification" value="no"
                                        class="eden-yn-trigger" data-target="data_class_sec"> No</label>
                            </div>
                        </div>
                    </div>
                    <div class="conditional-field" id="data_class_sec" style="display:none;">
                        <div class="form-group"><label>Classification Type</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="classification_type"
                                        value="Automatic"> Automatic</label>
                                <label class="radio-label"><input type="radio" name="classification_type"
                                        value="Manual"> Manual</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ─── CARD: Email & Collaboration ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h3>Email &amp; Collaboration</h3>
                            <p>Email platform, security, and awareness training</p>
                        </div>
                    </div>

                    <div class="form-group"><label>Email Platform</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="email_platform[]" value="M365">
                                Microsoft 365</label>
                            <label class="checkbox-label"><input type="checkbox" name="email_platform[]"
                                    value="G-Suite"> G-Suite</label>
                            <label class="checkbox-label"><input type="checkbox" name="email_platform[]" value="Other">
                                Other</label>
                        </div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label for="email_platform_other">Other Email Platform</label><input
                                type="text" id="email_platform_other" name="email_platform_other"
                                placeholder="e.g. Zoho Mail"></div>
                        <div class="form-group"><label for="num_email_licenses">No. of Email Licenses</label><input
                                type="number" id="num_email_licenses" name="num_email_licenses" min="0"
                                placeholder="e.g. 50"></div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label>Email Security Inbuilt (M365)?</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="email_security_inbuilt"
                                        value="yes"> Yes</label>
                                <label class="radio-label"><input type="radio" name="email_security_inbuilt" value="no">
                                    No</label>
                            </div>
                        </div>
                        <div class="form-group"><label for="email_security_other">Other Email Security
                                Solution</label><input type="text" id="email_security_other" name="email_security_other"
                                placeholder="e.g. Mimecast, Proofpoint"></div>
                    </div>

                    <div class="form-grid cols-3" style="margin-top:10px;">
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-database"></i> Email Backup</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio" name="email_backup"
                                        value="yes"> Yes</label><label class="radio-label"><input type="radio"
                                        name="email_backup" value="no"> No</label></div>
                        </div>
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-archive"></i> Email
                                Archival</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio"
                                        name="email_archival" value="yes"> Yes</label><label class="radio-label"><input
                                        type="radio" name="email_archival" value="no"> No</label></div>
                        </div>
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-lock"></i> Email Encryption</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio"
                                        name="email_encryption" value="yes" class="eden-yn-trigger"
                                        data-target="email_enc_sec"> Yes</label><label class="radio-label"><input
                                        type="radio" name="email_encryption" value="no" class="eden-yn-trigger"
                                        data-target="email_enc_sec"> No</label></div>
                        </div>
                    </div>
                    <div class="conditional-field" id="email_enc_sec" style="display:none;">
                        <div class="form-group"><label for="email_enc_solution">Encryption Solution</label><input
                                type="text" id="email_enc_solution" name="email_enc_solution"
                                placeholder="e.g. Virtru, OME"></div>
                    </div>

                    <div class="form-grid cols-3" style="margin-top:10px;">
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-graduation-cap"></i> Security
                                Training</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio"
                                        name="security_awareness" value="yes"> Yes</label><label
                                    class="radio-label"><input type="radio" name="security_awareness" value="no">
                                    No</label></div>
                        </div>
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-fish"></i> Phishing
                                Simulation</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio"
                                        name="phishing_simulation" value="yes"> Yes</label><label
                                    class="radio-label"><input type="radio" name="phishing_simulation" value="no">
                                    No</label></div>
                        </div>
                        <div class="yn-row"><label class="yn-label"><i class="fas fa-check-double"></i> DMARC</label>
                            <div class="radio-group"><label class="radio-label"><input type="radio" name="dmarc"
                                        value="yes"> Yes</label><label class="radio-label"><input type="radio"
                                        name="dmarc" value="no"> No</label></div>
                        </div>
                    </div>
                </div>

                <!-- ─── CARD: SIEM / SOC ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-radar"></i></div>
                        <div>
                            <h3>SIEM / Security Operations Center (SOC)</h3>
                            <p>Monitoring and incident response capabilities</p>
                        </div>
                    </div>

                    <div class="yn-row">
                        <label class="yn-label"><i class="fas fa-satellite-dish"></i> SIEM Solution Deployed?</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="siem_deployed" value="yes"
                                    class="eden-yn-trigger" data-target="siem_details_sec"> Yes</label>
                            <label class="radio-label"><input type="radio" name="siem_deployed" value="no"
                                    class="eden-yn-trigger" data-target="siem_details_sec"> No</label>
                        </div>
                    </div>
                    <div class="conditional-field" id="siem_details_sec" style="display:none;">
                        <div class="form-group"><label>SIEM Deployment</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="siem_type" value="On-Prem">
                                    On-Prem</label>
                                <label class="radio-label"><input type="radio" name="siem_type" value="Cloud">
                                    Cloud</label>
                                <label class="radio-label"><input type="radio" name="siem_type" value="Hybrid">
                                    Hybrid</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid cols-2" style="margin-top:10px;">
                        <div class="form-group"><label>SOC Type</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="soc_type" value="In-house">
                                    In-house</label>
                                <label class="radio-label"><input type="radio" name="soc_type" value="Managed">
                                    Managed</label>
                                <label class="radio-label"><input type="radio" name="soc_type" value="None">
                                    None</label>
                            </div>
                        </div>
                        <div class="yn-row" style="align-self:start;">
                            <label class="yn-label"><i class="fas fa-clock"></i> SOC Monitoring 24/7?</label>
                            <div class="radio-group">
                                <label class="radio-label"><input type="radio" name="soc_24x7" value="yes"> Yes</label>
                                <label class="radio-label"><input type="radio" name="soc_24x7" value="no"> No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ─── CARD: Backup & DR ─── -->
                <div class="section-card">
                    <div class="section-card-header">
                        <div class="section-card-icon"><i class="fas fa-cloud-arrow-up"></i></div>
                        <div>
                            <h3>Backup &amp; Disaster Recovery</h3>
                            <p>Data protection and recovery solutions</p>
                        </div>
                    </div>
                    <div class="form-grid cols-2">
                        <div class="form-group"><label for="server_backup_solution">Server Backup Solution</label><input
                                type="text" id="server_backup_solution" name="server_backup_solution"
                                placeholder="e.g. Veeam, Acronis"></div>
                        <div class="form-group"><label for="endpoint_backup_solution">Endpoint Backup
                                Solution</label><input type="text" id="endpoint_backup_solution"
                                name="endpoint_backup_solution" placeholder="e.g. CrashPlan, Druva"></div>
                    </div>
                </div>

                <!-- ─── Consent ─── -->
                <div class="form-consent">
                    <label class="checkbox-label">
                        <input type="checkbox" id="consent_checkbox" name="consent" value="yes">
                        <span>I consent to Eden Infosol collecting and processing this data for IT assessment purposes.
                            <a href="/privacy-policy" target="_blank">Privacy Policy</a></span>
                    </label>
                    <span class="field-error" id="consent-error"></span>
                </div>

                <!-- ─── Actions ─── -->
                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fas fa-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text"><i class="fas fa-paper-plane"></i> Submit Assessment</span>
                        <span class="btn-loading" style="display:none;"><i class="fas fa-spinner fa-spin"></i>
                            Submitting...</span>
                    </button>
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
<section class="eden-results-section" id="resultsSection" style="display:none;">
    <div class="eden-container">
        <div class="results-card">
            <div class="results-header">
                <div class="results-checkmark"><i class="fas fa-circle-check"></i></div>
                <h2>Assessment Complete!</h2>
                <p>Thank you, <strong id="resultClientName"></strong>. Here's your preliminary IT Risk Summary.</p>
            </div>

            <div class="results-score-area">
                <div class="score-ring-container">
                    <svg class="score-ring" viewBox="0 0 120 120">
                        <circle class="score-ring-bg" cx="60" cy="60" r="52" />
                        <circle class="score-ring-fill" id="scoreRingFill" cx="60" cy="60" r="52" />
                    </svg>
                    <div class="score-ring-text">
                        <span class="score-percentage" id="scorePercentage">0</span><span
                            class="score-percent-sign">%</span>
                        <span class="score-label">Risk</span>
                    </div>
                </div>
                <div class="score-details">
                    <div id="scoreLevelBadge" class="score-level level-unknown">
                        <span id="scoreLevelText">Unknown</span>
                    </div>
                    <div class="score-breakdown">
                        <div class="breakdown-item"><span class="breakdown-label">Risk Score</span> <span
                                class="breakdown-value" id="riskScoreValue">0</span></div>
                        <div class="breakdown-item"><span class="breakdown-label">Max Possible</span> <span
                                class="breakdown-value" id="maxScoreValue">0</span></div>
                        <div class="breakdown-item"><span class="breakdown-label">Assessment ID</span> <span
                                class="breakdown-value" id="assessmentIdValue">#&mdash;</span></div>
                    </div>
                </div>
            </div>

            <div class="results-message" id="resultsMessage"></div>

            <div class="results-actions">
                <a href="<?php echo esc_url($contact_url); ?>" class="btn-consult"><i class="fas fa-calendar-check"></i>
                    Book Free Consultation</a>
                <button type="button" class="btn-download" id="downloadReportBtn"><i class="fas fa-download"></i>
                    Download Summary</button>
            </div>

            <div class="results-footer">
                <p><i class="fas fa-envelope"></i> A detailed report has been sent to your email. Our team will reach
                    out within 24 hours.</p>
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
<h4 class="sub-heading">Routers</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of Owned Routers</label>
<input type="number" name="loc_{{IDX}}_num_owned_routers" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_router_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_router"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_router_rows"></div>
<div class="form-grid cols-1"><div class="form-group"><label>No. of ISP Provided Routers</label><input type="number" name="loc_{{IDX}}_num_isp_routers" min="0" placeholder="0"></div></div>
<h4 class="sub-heading">Firewalls</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of Firewalls</label>
<input type="number" name="loc_{{IDX}}_num_firewalls" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_fw_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_fw"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_fw_rows"></div>
<div class="form-grid cols-3">
<div class="form-group"><label>Firewall-based SD-WAN</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_sd_wan" value="yes"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_sd_wan" value="no"> No</label>
</div></div>
<div class="form-group"><label>Site-to-Site VPN</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_s2s_vpn" value="yes"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_s2s_vpn" value="no"> No</label>
</div></div>
<div class="form-group"><label>Point-to-Site VPN</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_p2s_vpn" value="yes"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_p2s_vpn" value="no"> No</label>
</div></div>
</div>
<h4 class="sub-heading">Network Switches</h4>
<div class="form-grid cols-1"><div class="form-group"><label>Core Switches — Quantity</label>
<input type="number" name="loc_{{IDX}}_core_sw_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_core_sw_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_core_sw"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_core_sw_rows"></div>
<div class="form-grid cols-1"><div class="form-group"><label>Distribution Switches — Quantity</label>
<input type="number" name="loc_{{IDX}}_dist_sw_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_dist_sw_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_dist_sw"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_dist_sw_rows"></div>
<div class="form-grid cols-1"><div class="form-group"><label>Access Layer Switches — Quantity</label>
<input type="number" name="loc_{{IDX}}_access_sw_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_access_sw_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_access_sw"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_access_sw_rows"></div>
<h4 class="sub-heading">WiFi Solutions</h4>
<div class="form-group"><label>Standalone AP</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_standalone_ap" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_standalone_ap_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_standalone_ap" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_standalone_ap_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_standalone_ap_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>Standalone AP Quantity</label>
<input type="number" name="loc_{{IDX}}_standalone_ap_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_standalone_ap_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_standalone_ap"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_standalone_ap_rows"></div>
</div>
<div class="form-group"><label>Controller-Based AP</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_controller_ap" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_controller_ap_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_controller_ap" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_controller_ap_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_controller_ap_sec" style="display:none;">
<div class="form-grid cols-1"><div class="form-group"><label>Controller-Based AP Quantity</label>
<input type="number" name="loc_{{IDX}}_controller_ap_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_controller_ap_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_controller_ap"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_controller_ap_rows"></div>
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
<div class="form-group"><label>SAN Storage</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_san" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_san_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_san" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_san_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_san_sec" style="display:none;">
<div class="form-grid cols-2">
<div class="form-group"><label>SAN Interface</label><div class="checkbox-group">
<label class="checkbox-label"><input type="checkbox" name="loc_{{IDX}}_san_if[]" value="SAS"> SAS</label>
<label class="checkbox-label"><input type="checkbox" name="loc_{{IDX}}_san_if[]" value="iSCSI"> iSCSI</label>
<label class="checkbox-label"><input type="checkbox" name="loc_{{IDX}}_san_if[]" value="FC"> FC</label>
</div></div>
<div class="form-group"><label>SAN Make &amp; Model</label><input type="text" name="loc_{{IDX}}_san_makemodel" placeholder="e.g. Dell PowerVault"></div>
</div></div>
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

<div class="toggle-section" id="loc_{{IDX}}_sec_power">
<div class="form-divider"><span>Power &amp; Electrical Infrastructure</span></div>
<div class="form-group"><label>Centralised UPS</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ups_central" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_ups_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ups_central" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_ups_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_ups_sec" style="display:none;">
<div class="form-grid cols-4">
<div class="form-group"><label>KVA</label><input type="text" name="loc_{{IDX}}_ups_kva" placeholder="e.g. 10 KVA"></div>
<div class="form-group"><label>Backup Time</label><input type="text" name="loc_{{IDX}}_ups_backup" placeholder="e.g. 30 mins"></div>
<div class="form-group"><label>Make</label><input type="text" name="loc_{{IDX}}_ups_make" placeholder="Make"></div>
<div class="form-group"><label>Model</label><input type="text" name="loc_{{IDX}}_ups_model" placeholder="Model"></div>
</div></div>
</div>

<div class="toggle-section" id="loc_{{IDX}}_sec_security">
<div class="form-divider"><span>Physical Security &amp; Safety</span></div>
<h4 class="sub-heading">CCTV Surveillance</h4>
<div class="form-grid cols-1"><div class="form-group"><label>NVR/DVR Quantity</label>
<input type="number" name="loc_{{IDX}}_nvr_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_nvr_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_nvr"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_nvr_rows"></div>
<div class="form-grid cols-4">
<div class="form-group"><label>Storage Capacity</label><input type="text" name="loc_{{IDX}}_cctv_storage" placeholder="e.g. 4 TB"></div>
<div class="form-group"><label>Retention Period</label><input type="text" name="loc_{{IDX}}_cctv_retention" placeholder="e.g. 30 days"></div>
<div class="form-group"><label>IP Cameras</label><input type="number" name="loc_{{IDX}}_ip_cameras" min="0" placeholder="0"></div>
<div class="form-group"><label>Analog Cameras</label><input type="number" name="loc_{{IDX}}_analog_cameras" min="0" placeholder="0"></div>
</div>
<h4 class="sub-heading">Biometric / Access Control</h4>
<div class="form-grid cols-4">
<div class="form-group"><label>Type</label><select name="loc_{{IDX}}_bio_type"><option value="">Select</option><option value="Standalone">Standalone</option><option value="Centralised">Centralised</option></select></div>
<div class="form-group"><label>No. of Devices</label><input type="number" name="loc_{{IDX}}_bio_qty" min="0" placeholder="0"></div>
<div class="form-group"><label>Make &amp; Model</label><input type="text" name="loc_{{IDX}}_bio_makemodel" placeholder="Make Model"></div>
<div class="form-group"><label>Areas Covered</label><input type="text" name="loc_{{IDX}}_bio_areas" placeholder="e.g. Main entry, Server room"></div>
</div>
<div class="form-grid cols-2">
<div class="form-group"><label>Fire Alarm System</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_fire_alarm" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_fire_alarm_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_fire_alarm" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_fire_alarm_sec"> No</label>
</div></div>
<div class="form-group"><label>Fire Extinguishers (Server Room)</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_fire_ext" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_fire_ext_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_fire_ext" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_fire_ext_sec"> No</label>
</div></div>
</div>
<div class="conditional-field" id="loc_{{IDX}}_fire_alarm_sec" style="display:none;"><div class="form-grid cols-1"><div class="form-group"><label>Fire Alarm Make &amp; Model</label><input type="text" name="loc_{{IDX}}_fire_alarm_mm" placeholder="Make Model"></div></div></div>
<div class="conditional-field" id="loc_{{IDX}}_fire_ext_sec" style="display:none;"><div class="form-grid cols-1"><div class="form-group"><label>Fire Extinguisher Make &amp; Model</label><input type="text" name="loc_{{IDX}}_fire_ext_mm" placeholder="Make Model"></div></div></div>
</div>

<div class="toggle-section" id="loc_{{IDX}}_sec_comms">
<div class="form-divider"><span>Communication &amp; Collaboration</span></div>
<div class="form-grid cols-2">
<div class="form-group"><label>EPABX</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_epabx" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_epabx_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_epabx" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_epabx_sec"> No</label>
</div></div>
<div class="form-group"><label>IP-PBX</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_pbx" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_ip_pbx_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_ip_pbx" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_ip_pbx_sec"> No</label>
</div></div>
</div>
<div class="conditional-field" id="loc_{{IDX}}_epabx_sec" style="display:none;"><div class="form-grid cols-2">
<div class="form-group"><label>EPABX Make</label><input type="text" name="loc_{{IDX}}_epabx_make" placeholder="Make"></div>
<div class="form-group"><label>EPABX Model</label><input type="text" name="loc_{{IDX}}_epabx_model" placeholder="Model"></div>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_ip_pbx_sec" style="display:none;"><div class="form-grid cols-2">
<div class="form-group"><label>IP-PBX Make</label><input type="text" name="loc_{{IDX}}_ip_pbx_make" placeholder="Make"></div>
<div class="form-group"><label>IP-PBX Model</label><input type="text" name="loc_{{IDX}}_ip_pbx_model" placeholder="Model"></div>
</div></div>
<h4 class="sub-heading">Phones</h4>
<div class="form-grid cols-3">
<div class="form-group"><label>Analog Phones Qty</label><input type="number" name="loc_{{IDX}}_analog_phones" min="0" placeholder="0"></div>
<div class="form-group"><label>IP Phones Qty</label><input type="number" name="loc_{{IDX}}_ip_phones" min="0" placeholder="0"></div>
<div class="form-group"><label>Soft Phones Qty</label><input type="number" name="loc_{{IDX}}_soft_phones" min="0" placeholder="0"></div>
</div>
<div class="form-group"><label>PA System</label><div class="radio-group">
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_pa" value="yes" class="eden-yn-trigger" data-target="loc_{{IDX}}_pa_sec"> Yes</label>
<label class="radio-label"><input type="radio" name="loc_{{IDX}}_pa" value="no" class="eden-yn-trigger" data-target="loc_{{IDX}}_pa_sec"> No</label>
</div></div>
<div class="conditional-field" id="loc_{{IDX}}_pa_sec" style="display:none;"><div class="form-grid cols-1"><div class="form-group"><label>PA Make &amp; Model</label><input type="text" name="loc_{{IDX}}_pa_mm" placeholder="Make Model"></div></div></div>
<h4 class="sub-heading">Video Conferencing</h4>
<div class="form-grid cols-1"><div class="form-group"><label>No. of Meeting Rooms (with VC)</label>
<input type="number" name="loc_{{IDX}}_vc_rooms" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_vc_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_vc"></div></div>
<div class="dynamic-rows" id="loc_{{IDX}}_vc_rows"></div>
<h4 class="sub-heading">End User Computing</h4>
<div class="form-grid cols-3">
<div class="form-group"><label>Laptops</label>
<input type="number" name="loc_{{IDX}}_laptops_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_laptops_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_laptops"></div>
<div class="form-group"><label>Desktops</label>
<input type="number" name="loc_{{IDX}}_desktops_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_desktops_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_desktops"></div>
<div class="form-group"><label>Workstations</label>
<input type="number" name="loc_{{IDX}}_workstations_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_workstations_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_workstations"></div>
<div class="form-group"><label>Thin Clients</label>
<input type="number" name="loc_{{IDX}}_thin_clients_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_thin_clients_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_thin_clients"></div>
<div class="form-group"><label>Tablets</label>
<input type="number" name="loc_{{IDX}}_tablets_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_tablets_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_tablets"></div>
<div class="form-group"><label>Phones (Company-Owned)</label>
<input type="number" name="loc_{{IDX}}_co_phones_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_co_phones_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_co_phones"></div>
<div class="form-group"><label>Printers</label>
<input type="number" name="loc_{{IDX}}_printers_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_printers_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_printers"></div>
<div class="form-group"><label>Scanners</label>
<input type="number" name="loc_{{IDX}}_scanners_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_scanners_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_scanners"></div>
<div class="form-group"><label>Multifunction Devices</label>
<input type="number" name="loc_{{IDX}}_mfp_qty" min="0" placeholder="0" class="eden-qty-trigger" data-container="loc_{{IDX}}_mfp_rows" data-tpl="makemodel" data-prefix="loc_{{IDX}}_mfp"></div>
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
<div class="form-grid cols-1"><div class="form-group"><label>Headsets Qty</label><input type="number" name="loc_{{IDX}}_headsets_qty" min="0" placeholder="0"></div></div>
</div>



</div><!-- end location-panel -->
</script><?php get_footer(); ?>