<?php
/**
 * Template Name: IT Assessment (Secret)
 * Description: Multi-step IT Infrastructure & Security Assessment Form for Eden Infosol
 */

// ─── SECRET KEY PROTECTION ───
// Only accessible with: yoursite.com/it-assess-eden/?key=eden2026secure
// Change the key below to whatever you want
$eden_secret_key = 'eden2026secure';
if ( !isset($_GET['key']) || $_GET['key'] !== $eden_secret_key ) {
    wp_redirect( home_url('/') );
    exit;
}

// Block search engines from indexing this page
add_action('wp_head', function() {
    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
}, 1);

get_header();
?>

<!-- Font Awesome 6 CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<!-- ============================================================ -->
<!-- HERO SECTION                                                  -->
<!-- ============================================================ -->
<section class="eden-assess-hero">
    <div class="eden-container">
        <div class="hero-badge"><i class="fa-solid fa-shield-halved"></i> Free Assessment</div>
        <h1>Get Your IT Infrastructure &amp; Security Assessment</h1>
        <p class="hero-subtitle">Complete this assessment in <strong>5–7 minutes</strong> and receive a personalized IT
            health report with actionable recommendations.</p>

        <div class="hero-benefits">
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <h3>Identify Security Gaps</h3>
                <p>Discover vulnerabilities across your entire IT infrastructure</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-server"></i></div>
                <h3>Optimize Infrastructure</h3>
                <p>Get recommendations to improve performance &amp; reduce costs</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon"><i class="fa-solid fa-user-tie"></i></div>
                <h3>Expert Recommendations</h3>
                <p>Receive a detailed report reviewed by our IT specialists</p>
            </div>
        </div>
    </div>
</section>



<!-- ============================================================ -->
<!-- ASSESSMENT FORM                                               -->
<!-- ============================================================ -->
<section class="eden-assess-form-section" id="assessment-form-section">
    <div class="eden-container">

        <!-- ─── PROGRESS BAR ─── -->
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
                    <span>Location</span>
                </div>
                <div class="progress-step" data-step="3">
                    <div class="step-circle">3</div>
                    <span>Network</span>
                </div>
                <div class="progress-step" data-step="4">
                    <div class="step-circle">4</div>
                    <span>Servers &amp; Devices</span>
                </div>
                <div class="progress-step" data-step="5">
                    <div class="step-circle">5</div>
                    <span>Peripherals</span>
                </div>
                <div class="progress-step" data-step="6">
                    <div class="step-circle">6</div>
                    <span>Security</span>
                </div>
                <div class="progress-step" data-step="7">
                    <div class="step-circle">7</div>
                    <span>Email &amp; Backup</span>
                </div>
            </div>
        </div>

        <!-- ─── FORM START ─── -->
        <form id="edenAssessmentForm" novalidate>

            <!-- ============================================== -->
            <!-- STEP 1: ORGANIZATION DETAILS                   -->
            <!-- ============================================== -->
            <div class="form-step active" data-step="1">
                <div class="step-header">
                    <h2><i class="fa-solid fa-building"></i> Section 1: Organization Details</h2>
                    <p>Tell us about your organization so we can tailor the assessment.</p>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group required">
                        <label for="client_name">Client / Organization Name</label>
                        <input type="text" id="client_name" name="client_name" placeholder="e.g. Acme Corp" required>
                        <span class="field-error"></span>
                    </div>
                    <div class="form-group required">
                        <label for="contact_email">Contact Email</label>
                        <input type="email" id="contact_email" name="contact_email" placeholder="you@company.com"
                            required>
                        <span class="field-error"></span>
                    </div>
                    <div class="form-group required">
                        <label for="contact_phone">Contact Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone" placeholder="+91 98XXX XXXXX"
                            required>
                        <span class="field-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" id="designation" name="designation" placeholder="e.g. IT Manager">
                    </div>
                </div>

                <div class="form-divider"><span>Organization Size</span></div>

                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="num_employees">No. of Employees</label>
                        <input type="number" id="num_employees" name="num_employees" placeholder="e.g. 150" min="1">
                    </div>
                    <div class="form-group">
                        <label for="total_employees_all_locations">Total Employees (All Locations)</label>
                        <input type="number" id="total_employees_all_locations" name="total_employees_all_locations"
                            placeholder="e.g. 500" min="1">
                    </div>
                    <div class="form-group">
                        <label for="num_locations">No. of Locations</label>
                        <input type="number" id="num_locations" name="num_locations" placeholder="e.g. 3" min="1">
                    </div>
                    <div class="form-group">
                        <label for="num_departments">No. of Departments</label>
                        <input type="number" id="num_departments" name="num_departments" placeholder="e.g. 8" min="1">
                    </div>
                    <div class="form-group">
                        <label for="num_vendors">No. of Vendors</label>
                        <input type="number" id="num_vendors" name="num_vendors" placeholder="e.g. 5" min="0">
                    </div>
                    <div class="form-group">
                        <label for="work_days_per_week">Work Days per Week</label>
                        <select id="work_days_per_week" name="work_days_per_week">
                            <option value="">Select</option>
                            <option value="5">5 Days</option>
                            <option value="6">6 Days</option>
                            <option value="7">7 Days</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="departments_list">Departments Across the Org</label>
                        <textarea id="departments_list" name="departments_list" rows="2"
                            placeholder="e.g. HR, Finance, IT, Sales, Operations"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="vendors_list">Vendors Across the Org</label>
                        <textarea id="vendors_list" name="vendors_list" rows="2"
                            placeholder="e.g. Dell, Microsoft, Kaspersky"></textarea>
                    </div>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="total_working_hours">Total Working Hours per Day (All Shifts)</label>
                        <input type="text" id="total_working_hours" name="total_working_hours"
                            placeholder="e.g. 9 hours or 16 hours (2 shifts)">
                    </div>
                    <div class="form-group">
                        <label>Inhouse IT Support</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="inhouse_it_support" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="inhouse_it_support" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Conditional: IT Support Staff count -->
                <div class="form-grid cols-2 conditional-field" id="it_staff_field" style="display:none;">
                    <div class="form-group">
                        <label for="num_it_support_staff">No. of IT Support Staff</label>
                        <input type="number" id="num_it_support_staff" name="num_it_support_staff" placeholder="e.g. 3"
                            min="0">
                    </div>
                </div>

                <div class="form-actions">
                    <div></div>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 2: LOCATION & INFRASTRUCTURE              -->
            <!-- ============================================== -->
            <div class="form-step" data-step="2">
                <div class="step-header">
                    <h2><i class="fa-solid fa-location-dot"></i> Section 2: Location-Wise Infrastructure</h2>
                    <p>Describe your primary location's physical infrastructure. For multiple locations, fill in the
                        primary one.</p>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="location_name">Location Name</label>
                        <input type="text" id="location_name" name="location_name" placeholder="e.g. Mumbai HQ">
                    </div>
                    <div class="form-group">
                        <label for="num_users_location">No. of Users in Location</label>
                        <input type="number" id="num_users_location" name="num_users_location" placeholder="e.g. 100"
                            min="0">
                    </div>
                </div>

                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label>Work Setup</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="work_setup[]" value="Shared">
                                <span>Shared</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="work_setup[]" value="Owned">
                                <span>Owned</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="work_setup[]" value="Rented">
                                <span>Rented</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="work_setup[]"
                                    value="Business Center"> <span>Business Center</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Dedicated Server / Network Room</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="dedicated_server_room" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="dedicated_server_room" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Conditional: Rack details -->
                <div class="conditional-field" id="rack_details_field" style="display:none;">
                    <div class="form-divider"><span>Rack Details</span></div>
                    <div class="form-grid cols-3">
                        <div class="form-group">
                            <label for="num_racks">No. of Racks</label>
                            <input type="number" id="num_racks" name="num_racks" placeholder="e.g. 2" min="0">
                        </div>
                        <div class="form-group">
                            <label for="num_patch_panels">No. of Patch Panels</label>
                            <input type="number" id="num_patch_panels" name="num_patch_panels" placeholder="e.g. 4"
                                min="0">
                        </div>
                        <div class="form-group">
                            <label for="num_pdus_per_rack">No. of PDUs per Rack</label>
                            <input type="number" id="num_pdus_per_rack" name="num_pdus_per_rack" placeholder="e.g. 2"
                                min="0">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 3: NETWORK & CONNECTIVITY                 -->
            <!-- ============================================== -->
            <div class="form-step" data-step="3">
                <div class="step-header">
                    <h2><i class="fa-solid fa-network-wired"></i> Section 3: Network &amp; Connectivity</h2>
                    <p>Provide details about your internet, leased lines, and network devices.</p>
                </div>

                <!-- Internet & ISP -->
                <div class="form-divider"><span>Internet &amp; ISP</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="isp_names">ISP Name(s)</label>
                        <input type="text" id="isp_names" name="isp_names" placeholder="e.g. Airtel, Jio">
                    </div>
                    <div class="form-group">
                        <label for="isp1_bandwidth">ISP 1 Bandwidth</label>
                        <input type="text" id="isp1_bandwidth" name="isp1_bandwidth" placeholder="e.g. 100 Mbps">
                    </div>
                    <div class="form-group">
                        <label for="isp2_bandwidth">ISP 2 Bandwidth</label>
                        <input type="text" id="isp2_bandwidth" name="isp2_bandwidth" placeholder="e.g. 50 Mbps">
                    </div>
                    <div class="form-group">
                        <label>ISP Router Provided</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="isp_router_provided" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="isp_router_provided" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Leased Lines -->
                <div class="form-divider"><span>Leased Lines</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="num_leased_lines">No. of Leased Lines</label>
                        <input type="number" id="num_leased_lines" name="num_leased_lines" placeholder="e.g. 2" min="0">
                    </div>
                    <div class="form-group">
                        <label for="leased_bandwidth">Bandwidth (Point A ↔ Point B)</label>
                        <input type="text" id="leased_bandwidth" name="leased_bandwidth"
                            placeholder="e.g. 10 Mbps Mumbai ↔ Delhi">
                    </div>
                    <div class="form-group">
                        <label for="leased_line_details">Additional Leased Line Details</label>
                        <textarea id="leased_line_details" name="leased_line_details" rows="2"
                            placeholder="Any additional details about leased lines"></textarea>
                    </div>
                    <div class="form-group">
                        <label>SP Router Provided</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="sp_router_provided" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="sp_router_provided" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Network Devices -->
                <div class="form-divider"><span>Network Devices</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="num_owned_routers">No. of Owned Routers</label>
                        <input type="number" id="num_owned_routers" name="num_owned_routers" placeholder="e.g. 3"
                            min="0">
                    </div>
                    <div class="form-group">
                        <label for="firewalls">Firewalls (Nos + Model + Warranty)</label>
                        <input type="text" id="firewalls" name="firewalls"
                            placeholder="e.g. 2x FortiGate 60F, 3yr warranty">
                    </div>
                    <div class="form-group">
                        <label for="num_vpn_users">No. of VPN Users</label>
                        <input type="number" id="num_vpn_users" name="num_vpn_users" placeholder="e.g. 25" min="0">
                    </div>
                </div>

                <!-- Switching -->
                <div class="form-divider"><span>Switching Infrastructure</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="num_switches">No. of Switches</label>
                        <input type="number" id="num_switches" name="num_switches" placeholder="e.g. 10" min="0">
                    </div>
                    <div class="form-group">
                        <label for="core_switches_l3">Core Switches (L3)</label>
                        <input type="text" id="core_switches_l3" name="core_switches_l3"
                            placeholder="e.g. 2x Cisco Catalyst 9300">
                    </div>
                    <div class="form-group">
                        <label for="access_switches">Distribution / Access Switches (L2/L1)</label>
                        <input type="text" id="access_switches" name="access_switches"
                            placeholder="e.g. 8x HP Aruba 2530">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 4: SERVER, STORAGE & END-USER DEVICES     -->
            <!-- ============================================== -->
            <div class="form-step" data-step="4">
                <div class="step-header">
                    <h2><i class="fa-solid fa-hard-drive"></i> Section 4: Server, Storage &amp; End-User Devices</h2>
                    <p>Details about your servers, storage systems, and user devices.</p>
                </div>

                <!-- Servers -->
                <div class="form-divider"><span>Server Infrastructure</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="physical_servers_non_virt">Physical Servers (Non-Virtualized)</label>
                        <input type="number" id="physical_servers_non_virt" name="physical_servers_non_virt"
                            placeholder="e.g. 2" min="0">
                    </div>
                    <div class="form-group">
                        <label for="physical_servers_virt">Physical Servers (Virtualized)</label>
                        <input type="number" id="physical_servers_virt" name="physical_servers_virt"
                            placeholder="e.g. 4" min="0">
                    </div>
                    <div class="form-group">
                        <label for="hypervisor_platform">Hypervisor Platform</label>
                        <select id="hypervisor_platform" name="hypervisor_platform">
                            <option value="">Select</option>
                            <option value="VMware vSphere/ESXi">VMware vSphere / ESXi</option>
                            <option value="Microsoft Hyper-V">Microsoft Hyper-V</option>
                            <option value="Citrix XenServer">Citrix XenServer</option>
                            <option value="KVM">KVM</option>
                            <option value="Proxmox">Proxmox</option>
                            <option value="Other">Other</option>
                            <option value="None">None</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_vms">Total No. of Virtual Machines</label>
                        <input type="number" id="total_vms" name="total_vms" placeholder="e.g. 20" min="0">
                    </div>
                </div>

                <!-- Storage -->
                <div class="form-divider"><span>Storage</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="num_nas_devices">No. of NAS Devices</label>
                        <input type="number" id="num_nas_devices" name="num_nas_devices" placeholder="e.g. 2" min="0">
                    </div>
                    <div class="form-group">
                        <label for="nas_capacity">NAS Capacity</label>
                        <input type="text" id="nas_capacity" name="nas_capacity" placeholder="e.g. 20 TB">
                    </div>
                    <div class="form-group">
                        <label for="num_san_devices">No. of SAN Devices</label>
                        <input type="number" id="num_san_devices" name="num_san_devices" placeholder="e.g. 1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="san_capacity">SAN Capacity</label>
                        <input type="text" id="san_capacity" name="san_capacity" placeholder="e.g. 50 TB">
                    </div>
                </div>

                <!-- End-User Devices -->
                <div class="form-divider"><span>End-User Devices</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="company_desktops">Company-owned Desktops</label>
                        <input type="number" id="company_desktops" name="company_desktops" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="company_laptops">Company-owned Laptops</label>
                        <input type="number" id="company_laptops" name="company_laptops" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="company_tablets">Company-owned Tablets</label>
                        <input type="number" id="company_tablets" name="company_tablets" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="byod_desktops">BYOD Desktops</label>
                        <input type="number" id="byod_desktops" name="byod_desktops" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="byod_laptops">BYOD Laptops</label>
                        <input type="number" id="byod_laptops" name="byod_laptops" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="byod_mobile_tablets">BYOD Mobile / Tablets</label>
                        <input type="number" id="byod_mobile_tablets" name="byod_mobile_tablets" placeholder="0"
                            min="0">
                    </div>
                    <div class="form-group">
                        <label for="thin_clients">Thin Clients</label>
                        <input type="number" id="thin_clients" name="thin_clients" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="vdi_instances">VDI Instances</label>
                        <input type="number" id="vdi_instances" name="vdi_instances" placeholder="0" min="0">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 5: PERIPHERALS, CCTV, TELEPHONY & POWER  -->
            <!-- ============================================== -->
            <div class="form-step" data-step="5">
                <div class="step-header">
                    <h2><i class="fa-solid fa-print"></i> Section 5: Peripherals, CCTV, Telephony &amp; Power</h2>
                    <p>Peripheral devices, surveillance, communication, and power systems.</p>
                </div>

                <!-- Peripherals -->
                <div class="form-divider"><span>Peripherals &amp; Other Devices</span></div>
                <div class="form-grid cols-4">
                    <div class="form-group">
                        <label for="printers">Printers</label>
                        <input type="number" id="printers" name="printers" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="scanners">Scanners</label>
                        <input type="number" id="scanners" name="scanners" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="mfp_devices">MFP Devices</label>
                        <input type="number" id="mfp_devices" name="mfp_devices" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="biometric_devices">Biometric Devices</label>
                        <input type="number" id="biometric_devices" name="biometric_devices" placeholder="0" min="0">
                    </div>
                </div>

                <!-- CCTV -->
                <div class="form-divider"><span>CCTV &amp; Security Systems</span></div>
                <div class="form-grid cols-4">
                    <div class="form-group">
                        <label for="ip_cameras">IP Cameras</label>
                        <input type="number" id="ip_cameras" name="ip_cameras" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="analog_cameras">Analog Cameras</label>
                        <input type="number" id="analog_cameras" name="analog_cameras" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="dvr_nvr_units">DVR / NVR Units</label>
                        <input type="number" id="dvr_nvr_units" name="dvr_nvr_units" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="cctv_storage_capacity">Storage Capacity</label>
                        <input type="text" id="cctv_storage_capacity" name="cctv_storage_capacity"
                            placeholder="e.g. 4 TB">
                    </div>
                </div>

                <!-- Telephony -->
                <div class="form-divider"><span>Telephony</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label>Type of Phone Lines</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="phone_line_type[]" value="PSTN">
                                <span>PSTN</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="phone_line_type[]" value="PRI">
                                <span>PRI</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="phone_line_type[]" value="IP">
                                <span>IP</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>EPABX Type</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="epabx_type[]" value="Analog">
                                <span>Analog</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="epabx_type[]" value="Digital">
                                <span>Digital</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="epabx_type[]" value="IP">
                                <span>IP</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone Types</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="phone_types[]" value="Analog">
                                <span>Analog</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="phone_types[]" value="IP Phones">
                                <span>IP Phones</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="phone_types[]"
                                    value="Softphones"> <span>Softphones</span></label>
                        </div>
                    </div>
                </div>

                <!-- Power & Safety -->
                <div class="form-divider"><span>Power &amp; Safety</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="fire_extinguishers">Fire Extinguishers</label>
                        <input type="number" id="fire_extinguishers" name="fire_extinguishers" placeholder="0" min="0">
                    </div>
                    <div class="form-group">
                        <label>Fire Alarm System</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="fire_alarm_system" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="fire_alarm_system" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label>UPS Type</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="ups_type" value="Shared">
                                <span>Shared</span></label>
                            <label class="radio-label"><input type="radio" name="ups_type" value="Owned">
                                <span>Owned</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>UPS Mode</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="ups_mode" value="Central">
                                <span>Central</span></label>
                            <label class="radio-label"><input type="radio" name="ups_mode" value="Individual">
                                <span>Individual</span></label>
                            <label class="radio-label"><input type="radio" name="ups_mode" value="Server Room Only">
                                <span>Server Room Only</span></label>
                        </div>
                    </div>
                </div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="ups_capacity">UPS Capacity</label>
                        <input type="text" id="ups_capacity" name="ups_capacity" placeholder="e.g. 10 KVA">
                    </div>
                    <div class="form-group">
                        <label for="ups_backup_time">UPS Backup Time</label>
                        <input type="text" id="ups_backup_time" name="ups_backup_time" placeholder="e.g. 30 minutes">
                    </div>
                </div>

                <!-- Video Conferencing & Collaboration -->
                <div class="form-divider"><span>Collaboration &amp; VC</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="vc_devices">Video Conferencing Devices (Hardware)</label>
                        <input type="text" id="vc_devices" name="vc_devices"
                            placeholder="e.g. 2x Poly Studio, 1x Jabra PanaCast">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 6: IDENTITY, SECURITY & IT OPERATIONS     -->
            <!-- ============================================== -->
            <div class="form-step" data-step="6">
                <div class="step-header">
                    <h2><i class="fa-solid fa-shield-halved"></i> Section 6: Identity, Security &amp; IT Operations</h2>
                    <p>This is the most critical section. Provide your endpoint security posture and IT tools.</p>
                </div>

                <!-- Identity & Directory -->
                <div class="form-divider"><span>Identity &amp; Directory</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="ad_workgroup">AD / Workgroup</label>
                        <select id="ad_workgroup" name="ad_workgroup">
                            <option value="">Select</option>
                            <option value="Active Directory">Active Directory</option>
                            <option value="Workgroup">Workgroup</option>
                            <option value="Both">Both</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type of AD</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="On-Prem">
                                <span>On-Prem</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="Azure AD">
                                <span>Azure AD</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="ad_type[]" value="Hybrid">
                                <span>Hybrid</span></label>
                        </div>
                    </div>
                </div>

                <!-- Endpoint Security Table -->
                <div class="form-divider"><span>Endpoint Security</span></div>
                <div class="security-table-wrapper">
                    <table class="security-table">
                        <thead>
                            <tr>
                                <th>Feature</th>
                                <th>Status</th>
                                <th>Remarks / Solution Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa-solid fa-virus-slash"></i> Antivirus / Anti-malware</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_antivirus"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_antivirus"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_antivirus_remarks"
                                        placeholder="e.g. Kaspersky Endpoint Security"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-fire-flame-curved"></i> Endpoint Firewall</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_endpoint_firewall" value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_endpoint_firewall" value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_endpoint_firewall_remarks" placeholder="Solution name">
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-cubes"></i> Application Control</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_app_control"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_app_control"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_app_control_remarks" placeholder="Solution name"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-usb"></i> Device Control</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_device_control"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_device_control"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_device_control_remarks" placeholder="Solution name">
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-bug"></i> Vulnerability Assessment</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_vuln_assessment" value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_vuln_assessment" value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_vuln_assessment_remarks" placeholder="Solution name">
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-download"></i> Patch Management</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_patch_mgmt"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_patch_mgmt"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_patch_mgmt_remarks" placeholder="Solution name"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-chart-line"></i> SIEM Integration</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_siem"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_siem"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_siem_remarks" placeholder="Solution name"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-lock"></i> Encryption</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_encryption"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_encryption"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_encryption_remarks" placeholder="e.g. BitLocker"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-crosshairs"></i> EDR / XDR</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio" name="sec_edr_xdr"
                                                value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio" name="sec_edr_xdr"
                                                value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_edr_xdr_remarks" placeholder="Solution name"></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-gears"></i> Software Control</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_software_control" value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_software_control" value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_software_control_remarks" placeholder="Solution name">
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-boxes-stacked"></i> Inventory Tracking</td>
                                <td>
                                    <div class="toggle-group">
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_inventory_tracking" value="yes"> <span>Yes</span></label>
                                        <label class="radio-label compact"><input type="radio"
                                                name="sec_inventory_tracking" value="no"> <span>No</span></label>
                                    </div>
                                </td>
                                <td><input type="text" name="sec_inventory_tracking_remarks"
                                        placeholder="Solution name"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- IT Operations & Tools -->
                <div class="form-divider"><span>IT Operations &amp; Tools</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="encryption_tool">Encryption Tool</label>
                        <input type="text" id="encryption_tool" name="encryption_tool"
                            placeholder="e.g. BitLocker, VeraCrypt">
                    </div>
                    <div class="form-group">
                        <label for="patch_mgmt_solution">Patch Management Solution</label>
                        <input type="text" id="patch_mgmt_solution" name="patch_mgmt_solution"
                            placeholder="e.g. WSUS, Pulseway">
                    </div>
                    <div class="form-group">
                        <label for="remote_support_tool">Remote Support Tool</label>
                        <input type="text" id="remote_support_tool" name="remote_support_tool"
                            placeholder="e.g. AnyDesk, TeamViewer">
                    </div>
                    <div class="form-group">
                        <label for="asset_mgmt_system">Asset Management System</label>
                        <input type="text" id="asset_mgmt_system" name="asset_mgmt_system"
                            placeholder="e.g. Freshservice, Snipe-IT">
                    </div>
                    <div class="form-group">
                        <label for="log_siem_system">Log / SIEM System</label>
                        <input type="text" id="log_siem_system" name="log_siem_system"
                            placeholder="e.g. Splunk, SolarWinds">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="button" class="btn-next">Next <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>


            <!-- ============================================== -->
            <!-- STEP 7: EMAIL, BACKUP, APPS & WEBSITE          -->
            <!-- ============================================== -->
            <div class="form-step" data-step="7">
                <div class="step-header">
                    <h2><i class="fa-solid fa-envelope"></i> Section 7: Email, Backup, Applications &amp; Website</h2>
                    <p>Final section — almost done! Tell us about your email, backup, applications, and web presence.
                    </p>
                </div>

                <!-- Email & Collaboration -->
                <div class="form-divider"><span>Email &amp; Collaboration</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="email_platform">Email Platform</label>
                        <select id="email_platform" name="email_platform">
                            <option value="">Select</option>
                            <option value="Microsoft 365">Microsoft 365</option>
                            <option value="Google Workspace">Google Workspace</option>
                            <option value="On-Prem Exchange">On-Prem Exchange</option>
                            <option value="Zoho Mail">Zoho Mail</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="num_email_users">No. of Email Users</label>
                        <input type="number" id="num_email_users" name="num_email_users" placeholder="e.g. 100" min="0">
                    </div>
                    <div class="form-group">
                        <label for="email_backup">Email Backup / Archival</label>
                        <input type="text" id="email_backup" name="email_backup" placeholder="e.g. Veeam for M365">
                    </div>
                    <div class="form-group">
                        <label for="email_security_solution">Email Security Solution</label>
                        <input type="text" id="email_security_solution" name="email_security_solution"
                            placeholder="e.g. Microsoft Defender, Barracuda">
                    </div>
                </div>

                <!-- File Server & OS -->
                <div class="form-divider"><span>File Server &amp; OS</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label>File Server Type</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="file_server_type" value="On-Prem">
                                <span>On-Prem</span></label>
                            <label class="radio-label"><input type="radio" name="file_server_type" value="Cloud">
                                <span>Cloud</span></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="server_os_types">Server OS Types</label>
                        <input type="text" id="server_os_types" name="server_os_types"
                            placeholder="e.g. Windows Server 2022, Ubuntu 22.04">
                    </div>
                    <div class="form-group">
                        <label for="endpoint_os_types">Endpoint OS Types</label>
                        <input type="text" id="endpoint_os_types" name="endpoint_os_types"
                            placeholder="e.g. Windows 11, macOS Sonoma">
                    </div>
                </div>

                <!-- Backup & DR -->
                <div class="form-divider"><span>Backup &amp; Disaster Recovery</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="server_backup_solution">Server Backup Solution</label>
                        <input type="text" id="server_backup_solution" name="server_backup_solution"
                            placeholder="e.g. Veeam, Acronis">
                    </div>
                    <div class="form-group">
                        <label for="endpoint_backup_solution">Endpoint Backup Solution</label>
                        <input type="text" id="endpoint_backup_solution" name="endpoint_backup_solution"
                            placeholder="e.g. OneDrive, Acronis">
                    </div>
                    <div class="form-group">
                        <label>MFA / SSO Implemented</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="mfa_sso" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="mfa_sso" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Applications & Databases -->
                <div class="form-divider"><span>Applications &amp; Databases</span></div>
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label for="total_applications">Total Applications</label>
                        <input type="number" id="total_applications" name="total_applications" placeholder="e.g. 12"
                            min="0">
                    </div>
                    <div class="form-group">
                        <label for="web_applications">Web Applications</label>
                        <input type="number" id="web_applications" name="web_applications" placeholder="e.g. 5" min="0">
                    </div>
                    <div class="form-group">
                        <label for="databases_count">Databases Count</label>
                        <input type="number" id="databases_count" name="databases_count" placeholder="e.g. 8" min="0">
                    </div>
                    <div class="form-group">
                        <label for="database_types">Database Types</label>
                        <input type="text" id="database_types" name="database_types"
                            placeholder="e.g. SQL Server, MySQL, PostgreSQL">
                    </div>
                </div>

                <!-- Website & Domain -->
                <div class="form-divider"><span>Website &amp; Domain</span></div>
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label for="domain_provider">Domain Provider</label>
                        <input type="text" id="domain_provider" name="domain_provider"
                            placeholder="e.g. GoDaddy, Namecheap">
                    </div>
                    <div class="form-group">
                        <label for="website_url">Website URL</label>
                        <input type="url" id="website_url" name="website_url" placeholder="https://www.example.com">
                    </div>
                    <div class="form-group">
                        <label>SSL Certificate</label>
                        <div class="radio-group">
                            <label class="radio-label"><input type="radio" name="ssl_certificate" value="yes">
                                <span>Yes</span></label>
                            <label class="radio-label"><input type="radio" name="ssl_certificate" value="no">
                                <span>No</span></label>
                        </div>
                    </div>
                </div>

                <!-- Privacy & Consent -->
                <div class="form-consent">
                    <label class="checkbox-label">
                        <input type="checkbox" id="consent_checkbox" name="consent" value="yes" required>
                        <span>I consent to Eden Infosol collecting and processing this data for the purpose of IT
                            assessment. <a href="/privacy-policy" target="_blank">Privacy Policy</a></span>
                    </label>
                    <span class="field-error" id="consent-error"></span>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-prev"><i class="fa-solid fa-arrow-left"></i> Previous</button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="btn-text"><i class="fa-solid fa-paper-plane"></i> Submit Assessment</span>
                        <span class="btn-loading" style="display:none;"><i class="fa-solid fa-spinner fa-spin"></i>
                            Submitting...</span>
                    </button>
                </div>
            </div>

        </form>

        <!-- Save Progress Button (floating) -->
        <div class="save-progress-bar" id="saveProgressBar">
            <button type="button" class="btn-save" id="saveProgressBtn"><i class="fa-solid fa-floppy-disk"></i> Save
                Progress</button>
            <span class="save-status" id="saveStatus"></span>
        </div>

    </div>
</section>


<!-- ============================================================ -->
<!-- RESULTS SECTION (hidden by default)                           -->
<!-- ============================================================ -->
<section class="eden-results-section" id="resultsSection" style="display:none;">
    <div class="eden-container">
        <div class="results-card">
            <div class="results-header">
                <div class="results-checkmark">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h2>Assessment Complete!</h2>
                <p>Thank you, <span id="resultClientName"></span>. Here's your preliminary IT Risk Summary.</p>
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
                    <div class="score-level" id="scoreLevelBadge">
                        <span class="level-text" id="scoreLevelText">Unknown</span>
                    </div>
                    <div class="score-breakdown">
                        <div class="breakdown-item">
                            <span class="breakdown-label">Risk Score</span>
                            <span class="breakdown-value" id="riskScoreValue">0</span>
                        </div>
                        <div class="breakdown-item">
                            <span class="breakdown-label">Max Possible</span>
                            <span class="breakdown-value" id="maxScoreValue">0</span>
                        </div>
                        <div class="breakdown-item">
                            <span class="breakdown-label">Assessment ID</span>
                            <span class="breakdown-value" id="assessmentIdValue">#—</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="results-message" id="resultsMessage">
                <!-- Dynamic message based on risk level -->
            </div>

            <div class="results-actions">
                <a href="#" class="btn-consult"
                    onclick="window.open('https://calendly.com/edeninfosol', '_blank'); return false;">
                    <i class="fa-solid fa-calendar-check"></i> Book Free Consultation
                </a>
                <button type="button" class="btn-download" id="downloadReportBtn">
                    <i class="fa-solid fa-file-pdf"></i> Download Summary
                </button>
            </div>

            <div class="results-footer">
                <p><i class="fa-solid fa-envelope"></i> A detailed report has been sent to your email. Our team will
                    reach out within 24 hours.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>