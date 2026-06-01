<?php
/*
Template Name: Products Page
*/
if (!defined('ABSPATH')) exit;
get_header();

$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="section-label">PRODUCTS &amp; SERVICES</span>
        <h1>Our Full-Stack IT Portfolio</h1>
        <p>Click any product or service to learn more. Every offering is backed by certified expertise and a commitment to real business outcomes.</p>
    </div>
</section>

<!-- IT INFRASTRUCTURE -->
<div class="service-category" id="it-infrastructure">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-server"></i></div>
            <h2>IT Infrastructure</h2>
        </div>
        <p class="category-tagline fade-in">Build the backbone of your organisation</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Compute &amp; Servers</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">High-performance servers and compute platforms tailored to your workload requirements and growth roadmap.</div>
                <div class="service-details"><p>We partner with Dell, HP, and Lenovo to deliver rack, tower, and blade servers optimised for virtualisation, databases, AI workloads, and general-purpose computing. Our team handles capacity planning, configuration, deployment, and post-deployment support.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Storage Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Scalable SAN, NAS, and object storage designed for reliability, performance, and data accessibility.</div>
                <div class="service-details"><p>From entry-level NAS for SMEs to enterprise SAN arrays from Dell EMC and NetApp, we design storage architectures that balance performance, redundancy, and cost. We also support object storage for unstructured data and cloud-tiered storage strategies.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Networking</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">LAN, WAN, and wireless networking infrastructure built for speed, resilience, and seamless connectivity.</div>
                <div class="service-details"><p>We design and deploy enterprise networks using Cisco, Aruba, and Fortinet switching and wireless platforms. Our solutions cover campus LAN, branch connectivity, Wi-Fi 6/6E deployments, and network segmentation for security.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Virtualization</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">VMware, Hyper-V, and open-source virtualization solutions to maximise resource efficiency and flexibility.</div>
                <div class="service-details"><p>We implement VMware vSphere, Microsoft Hyper-V, and KVM-based virtualisation platforms to consolidate workloads, improve disaster recovery, and reduce hardware costs. We also handle licensing optimisation and migration from legacy environments.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Server Licensing</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Optimised licensing advisory and procurement for Microsoft, VMware, Red Hat, and more.</div>
                <div class="service-details"><p>Navigating Microsoft, VMware, and Red Hat licensing can be complex. We provide advisory services to ensure you are properly licensed, cost-optimised, and audit-ready — whether you are running on-premise, hybrid, or cloud workloads.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> End-User Computing</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Desktops, laptops, thin clients, and VDI solutions for a productive and modern workforce.</div>
                <div class="service-details"><p>From bulk laptop and desktop procurement to VDI deployments using Citrix or VMware Horizon, we equip your workforce with the right devices and virtual desktop environments for productivity, security, and flexibility.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- CLOUD & DATA CENTRE -->
<div class="service-category" id="cloud-datacenter">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-cloud"></i></div>
            <h2>Cloud &amp; Data Centre</h2>
        </div>
        <p class="category-tagline fade-in">Scale with agility and confidence</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Public Cloud (Azure / AWS)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Design, deploy, and manage workloads on Microsoft Azure and Amazon Web Services with certified expertise.</div>
                <div class="service-details"><p>We are certified partners for both Microsoft Azure and AWS. Our services include cloud architecture design, workload migration, cost optimisation, reserved instance planning, and ongoing cloud operations management.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Private Cloud</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Dedicated cloud environments that give you full control over data sovereignty, security, and compliance.</div>
                <div class="service-details"><p>For organisations with strict data sovereignty or compliance requirements, we design and deploy private cloud environments using VMware Cloud Foundation, Azure Stack HCI, or OpenStack — hosted on-premise or in a colocation facility.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Hybrid Cloud</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Seamlessly connect on-premise and cloud environments for maximum operational flexibility.</div>
                <div class="service-details"><p>We architect hybrid environments that seamlessly connect your on-premise infrastructure with public cloud services, enabling workload portability, unified management, and a consistent security posture across environments.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Cloud Migration</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Proven migration frameworks that move your workloads safely and efficiently with minimal disruption.</div>
                <div class="service-details"><p>Using proven frameworks and tools like Azure Migrate and AWS Migration Hub, we assess, plan, and execute cloud migrations with minimal downtime. We handle application dependency mapping, data migration, and post-migration validation.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Backup &amp; DR</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Business continuity through robust backup strategies and comprehensive disaster recovery planning.</div>
                <div class="service-details"><p>We implement backup solutions using Veeam, Acronis, and Azure Backup, combined with disaster recovery planning that includes RTO/RPO analysis, automated failover testing, and documented recovery procedures.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Co-Location / Data Center Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Secure colocation rack space with guaranteed power, cooling, and high-availability connectivity.</div>
                <div class="service-details"><p>We provide access to Tier III and Tier IV data centre facilities with guaranteed uptime SLAs, redundant power and cooling, physical security, and high-speed connectivity options for your critical infrastructure.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- CYBERSECURITY -->
<div class="service-category" id="cybersecurity">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-shield-halved"></i></div>
            <h2>Cybersecurity</h2>
        </div>
        <p class="category-tagline fade-in">Defend every layer of your digital estate</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Identity &amp; Access Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Control who accesses what — with MFA, PAM, and zero-trust identity frameworks across your organisation.</div>
                <div class="service-details"><p>We deploy identity governance solutions including Azure AD, Okta, and CyberArk for privileged access management. Our zero-trust implementations cover conditional access policies, MFA enforcement, and identity lifecycle automation.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Email &amp; Collaboration Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Protect your inboxes and collaboration tools from phishing, spoofing, malware, and data leakage.</div>
                <div class="service-details"><p>We secure Microsoft 365, Google Workspace, and on-premise email with advanced threat protection, anti-phishing, DMARC/DKIM/SPF configuration, and data loss prevention policies to protect against business email compromise.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Endpoint &amp; Device Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">EDR and XDR solutions that detect, respond to, and neutralise threats across every device.</div>
                <div class="service-details"><p>We deploy and manage EDR/XDR platforms from CrowdStrike, SentinelOne, and Microsoft Defender for Endpoint, providing real-time threat detection, automated response, and threat hunting across all your devices.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Network &amp; Perimeter Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Next-gen firewalls, IPS, and segmentation to keep threats out and contain risks within your network.</div>
                <div class="service-details"><p>We design and deploy next-generation firewalls from Fortinet, Check Point, and Palo Alto, along with IPS, network segmentation, and micro-segmentation strategies to contain lateral movement and protect critical assets.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Application Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Identify and remediate vulnerabilities in your applications before attackers can exploit them.</div>
                <div class="service-details"><p>We conduct application security assessments including SAST, DAST, and manual penetration testing to identify vulnerabilities in your web applications, APIs, and mobile apps before they can be exploited.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Data Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">DLP, encryption, and data classification to protect sensitive information wherever it lives.</div>
                <div class="service-details"><p>We implement data classification, encryption, and DLP solutions from Microsoft Purview, Symantec, and Forcepoint to protect sensitive data at rest, in transit, and in use across your organisation.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Cloud Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Purpose-built security controls and posture management for your cloud workloads and environments.</div>
                <div class="service-details"><p>We deploy cloud security posture management (CSPM), cloud workload protection (CWPP), and cloud access security broker (CASB) solutions to secure your Azure, AWS, and multi-cloud environments.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> SOC / SIEM / Detection</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">24/7 threat monitoring, detection, and response powered by SIEM and a dedicated security operations centre.</div>
                <div class="service-details"><p>Our managed SOC services include 24/7 monitoring using SIEM platforms like Microsoft Sentinel, Splunk, and IBM QRadar, with automated alerting, incident triage, threat intelligence integration, and monthly reporting.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- MANAGED SERVICES -->
<div class="service-category" id="managed-services">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-headset"></i></div>
            <h2>Managed Services</h2>
        </div>
        <p class="category-tagline fade-in">Your IT, running — so your business can keep moving</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Managed Infrastructure Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Proactive monitoring and management of your servers, storage, and networking infrastructure.</div>
                <div class="service-details"><p>Our team provides 24/7 monitoring and management of your servers, storage, and network devices with proactive alerting, patch management, performance optimisation, and capacity planning — all backed by defined SLAs.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Managed Security Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Continuous security monitoring, threat response, and compliance management as a fully managed service.</div>
                <div class="service-details"><p>We deliver fully managed security operations including continuous monitoring, vulnerability management, incident response, compliance reporting, and regular security posture assessments as a subscription service.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Managed Cloud Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">End-to-end management of your cloud environment — optimised for performance, cost, and security.</div>
                <div class="service-details"><p>We manage your entire cloud environment end-to-end — from infrastructure provisioning and cost governance to security hardening, backup management, and performance tuning across Azure, AWS, or hybrid setups.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> General Managed IT Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Day-to-day IT operations, helpdesk support, and technology management for your entire organisation.</div>
                <div class="service-details"><p>From helpdesk support and user onboarding to asset management and vendor coordination, we handle your day-to-day IT operations so your internal team can focus on strategic initiatives.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- CONNECTIVITY & VOICE -->
<div class="service-category" id="connectivity-voice">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-phone-volume"></i></div>
            <h2>Connectivity &amp; Voice</h2>
        </div>
        <p class="category-tagline fade-in">Stay connected. Stay operational.</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Connectivity Solutions (ILL / MPLS / P2P / SD-WAN)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Enterprise-grade internet and private network connectivity — reliable, secure, and built for business continuity.</div>
                <div class="service-details"><p>We provision enterprise internet leased lines (ILL), MPLS circuits, point-to-point links, and SD-WAN solutions from leading ISPs. Our team handles circuit design, redundancy planning, SLA management, and ongoing performance monitoring.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Voice Solutions (PRI / SIP / Toll-Free)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Scalable business voice infrastructure including PRI lines, SIP trunking, and toll-free number services.</div>
                <div class="service-details"><p>We deploy PRI lines, SIP trunking, and toll-free number services integrated with your existing PBX or unified communications platform. Our solutions support call routing, IVR, call recording, and scalable voice infrastructure.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- AUDITS & COMPLIANCE -->
<div class="service-category" id="audits-compliance">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-clipboard-check"></i></div>
            <h2>Audits &amp; Compliance</h2>
        </div>
        <p class="category-tagline fade-in">Know your risks. Meet your obligations.</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Security Testing / VAPT</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Vulnerability assessments and penetration testing to uncover and address security gaps before they are exploited.</div>
                <div class="service-details"><p>We conduct comprehensive vulnerability assessments and penetration testing across your network, applications, and infrastructure using industry-standard tools and methodologies including OWASP, NIST, and PTES frameworks.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> IT &amp; Network Audit</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Comprehensive review of your IT environment to assess performance, gaps, and improvement opportunities.</div>
                <div class="service-details"><p>Our IT and network audits cover infrastructure health, configuration reviews, performance benchmarking, and gap analysis with actionable recommendations to improve reliability, security, and operational efficiency.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Compliance Audits / Readiness</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Structured readiness assessments to help you meet ISO, GDPR, RBI, SEBI, and other regulatory requirements.</div>
                <div class="service-details"><p>We help organisations prepare for and achieve compliance with ISO 27001, SOC 2, GDPR, RBI, SEBI, and IRDAI regulations through structured readiness assessments, gap remediation, and documentation support.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Risk Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Identify, quantify, and prioritise technology and operational risks with a structured risk management approach.</div>
                <div class="service-details"><p>We provide structured risk assessments that identify, quantify, and prioritise technology and operational risks, with risk treatment plans, risk register development, and board-level reporting.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- DIGITAL SOLUTIONS -->
<div class="service-category" id="digital-solutions">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-laptop-code"></i></div>
            <h2>Digital Solutions</h2>
        </div>
        <p class="category-tagline fade-in">Engage customers. Communicate smarter.</p>
        <div class="services-grid">

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> WhatsApp Business Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Deploy verified WhatsApp Business APIs to automate customer communication at scale.</div>
                <div class="service-details"><p>We integrate the official WhatsApp Business API into your customer communication workflows, enabling automated notifications, two-way messaging, chatbot integration, and template-based campaigns at enterprise scale.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> SMS Communication</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Reliable transactional and promotional SMS delivery for customer notifications and engagement.</div>
                <div class="service-details"><p>We provide reliable bulk SMS delivery for transactional alerts, OTP verification, promotional campaigns, and customer notifications through direct operator connections with DLT compliance and delivery tracking.</p></div>
            </div>

            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Customer Engagement Enablement</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Tools and platforms that help your teams connect, respond, and retain customers more effectively.</div>
                <div class="service-details"><p>We implement customer engagement platforms including CRM integration, omnichannel communication tools, feedback systems, and analytics dashboards that help your teams respond faster and retain customers more effectively.</p></div>
            </div>

        </div>
    </div>
</div>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content fade-in">
            <h2>Ready to Transform Your IT?</h2>
            <p>Let's discuss how Eden Infosol can help you build, secure and manage your technology environment — end to end.</p>
            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-primary">Get Your Free Assessment</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>