<?php
/**
 * Template Name: Products Page
 */
if (!defined('ABSPATH'))
    exit;
get_header();
$contact_url = eden_get_page_url('contact-us', home_url('/contact-us/'));
$assess_url = eden_get_page_url('assessment', home_url('/assessment/'));
?>

<section class="page-header">
    <div class="page-header-content">
        <span class="section-label">PRODUCTS & SERVICES</span>
        <h1>Our Full-Stack IT Portfolio</h1>
        <p>Every offering is backed by certified expertise and a commitment
            to real business outcomes.</p>
    </div>
</section>
<section class="service-category" id="digital-connectivity">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-satellite-dish"></i></div>
            <h2>Connectivity & Digital Transformation</h2>
        </div>
        <div class="category-tagline fade-in">Communicate smarter. Stay connected. Stay operational.</div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Connectivity Solutions (ILL /
                        MPLS / SD-WAN)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Enterprise-grade internet and private network connectivity — reliable, secure,
                    and built for business continuity.</div>
                <div class="service-details">
                    <p>We provision enterprise internet leased lines (ILL), MPLS circuits, point-to-point links, and
                        SD-WAN solutions from leading ISPs. Our team handles circuit design, redundancy planning, SLA
                        management, and ongoing performance monitoring.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Voice Solutions (PRI / SIP /
                        Toll-Free)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Scalable business voice infrastructure including PRI lines, SIP trunking, and
                    toll-free number services.</div>
                <div class="service-details">
                    <p>We deploy PRI lines, SIP trunking, and toll-free number services integrated with your existing
                        PBX or unified communications platform. Our solutions support call routing, IVR, call recording,
                        and scalable voice infrastructure.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> WhatsApp Business
                        Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Deploy verified WhatsApp Business APIs to automate customer communication at
                    scale.</div>
                <div class="service-details">
                    <p>We integrate the official WhatsApp Business API into your customer communication workflows,
                        enabling automated notifications, two-way messaging, chatbot integration, and template-based
                        campaigns at enterprise scale.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> SMS Communication</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Reliable transactional and promotional SMS delivery for customer notifications
                    and engagement.</div>
                <div class="service-details">
                    <p>We provide reliable bulk SMS delivery for transactional alerts, OTP verification, promotional
                        campaigns, and customer notifications through direct operator connections with DLT compliance
                        and delivery tracking.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Customer Engagement
                        Enablement</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Tools and platforms that help your teams connect, respond, and retain
                    customers more effectively.</div>
                <div class="service-details">
                    <p>We implement customer engagement platforms including CRM integration, omnichannel communication
                        tools, feedback systems, and analytics dashboards that help your teams respond faster and retain
                        customers more effectively.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-category" id="it-infrastructure">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-server"></i></div>
            <h2>IT Infrastructure</h2>
        </div>
        <div class="category-tagline fade-in">Build the backbone of your organisation</div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Networking </span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Build a high-performance network backbone with structured cabling, racks, LAN,
                    WAN, and wireless infrastructure designed for reliability and scalability.</div>
                <div class="service-details">
                    <p>We deliver complete network infrastructure solutions—from structured cabling and racks to
                        switching and Wi-Fi—leveraging leading platforms from D-Link, Cisco, Aruba, and Fortinet.
                        Designed for performance, scalability, and security, our solutions support campus networks,
                        branch connectivity, and modern Wi-Fi deployments with built-in segmentation.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> UPS & Power Backup</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Reliable power backup solutions designed to ensure uninterrupted operations
                    and protect critical IT infrastructure.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end UPS and power infrastructure solutions to ensure uninterrupted
                        operations for critical IT environments. Our offerings include online UPS, backup power systems,
                        and integrated power setups, covering sizing, deployment, and lifecycle support. Built for
                        reliability and performance, our solutions protect servers, networks, and business-critical
                        systems from power fluctuations and outages.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> End-User Computing</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Desktops, laptops, workstations, thin clients, headsets, and workplace devices
                    designed to enable a productive, secure, and modern workforce</div>
                <div class="service-details">
                    <p>We deliver end-to-end end-user computing solutions—from device procurement and deployment to
                        lifecycle support—leveraging leading platforms from Dell, HP, ASUS, Lenovo, Microsoft, and Apple
                        , Jabra and Poly. Our offerings include bulk supply, configuration, imaging, and rollout of
                        laptops, desktops, workstations, thin clients, and user headsets. Designed for performance,
                        reliability, and security, our solutions enable seamless user experiences across office, remote,
                        and hybrid work environments.”</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Printers, Scanners &
                        MFPs</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Efficient and reliable document management solutions designed to support
                    everyday business operations and enterprise printing needs.</div>
                <div class="service-details">
                    <p>We deliver end-to-end printing and imaging solutions—from standalone printers to multifunction
                        devices (MFPs)—leveraging leading platforms from HP, Canon, Epson, and other global brands. Our
                        offerings include supply, deployment, and lifecycle support for office and enterprise
                        environments. Designed for performance, cost efficiency, and ease of management, our solutions
                        enable seamless printing, scanning, and document handling across your organization.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Compute & Servers</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">High-performance compute and server platforms designed to support your
                    critical workloads, scalability needs, and future growth</div>
                <div class="service-details">
                    <p>We design and deliver enterprise compute infrastructure using leading platforms from Dell, HPE,
                        and Lenovo. Our solutions span rack, tower, and blade servers optimized for virtualization,
                        databases, AI workloads, and business-critical applications. From capacity planning and
                        architecture design to deployment and lifecycle support, we build scalable, high-performance
                        compute environments tailored to your business needs.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Storage Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Scalable SAN, NAS, and storage platforms designed for high availability,
                    performance, and secure data access.</div>
                <div class="service-details">
                    <p>We design and deliver enterprise storage solution from entry-level NAS to high-performance SAN
                        arrays—leveraging leading platforms from Dell EMC, Hitachi, and other global vendors. Our
                        architectures are optimized for performance, redundancy, and cost efficiency, supporting both
                        structured and unstructured data. From solution design and sizing to deployment and ongoing
                        support, we ensure reliable, scalable, and resilient storage environments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Virtualization & HCI</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Modern virtualization and hyper-converged infrastructure (HCI) solutions
                    designed to optimise performance, simplify management, and enable scalable IT environments.</div>
                <div class="service-details">
                    <p>We design and deliver virtualization and hyper-converged infrastructure (HCI) solutions using
                        leading platforms such as VMware, Microsoft Hyper-V, and KVM-based environments, along with
                        industry-leading HCI platforms. Our solutions enable efficient workload consolidation,
                        integrated compute-storage networking, and simplified infrastructure management. From
                        architecture design and deployment to migration and optimisation, we help organisations
                        modernise their IT environments while improving performance, scalability, and cost efficiency.
                    </p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Software Licensing</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Flexible and optimized software licensing solutions designed to support your
                    business applications, productivity, and infrastructure needs.</div>
                <div class="service-details">
                    <p>We deliver end-to-end software licensing solutions across leading platforms including Microsoft
                        (Server & subscriptions), Gsuite , Adobe, Autodesk, Zoom, TeamViewer, Red Hat, and SUSE. Our
                        services cover license procurement, renewals, compliance management, and optimization—ensuring
                        you have the right licenses aligned to your usage and growth plans. From initial selection to
                        lifecycle management, we help organizations control costs, maintain compliance, and maximize
                        value from their software investments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Lights-Out Data Center &
                        Infrastructure Management</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Advanced power distribution and intelligent infrastructure management
                    solutions designed for remote access, control, and uninterrupted operations.</div>
                <div class="service-details">
                    <p>We design and deliver lights-out data center solutions that enable complete remote visibility and
                        control of critical IT infrastructure. Our offerings include intelligent and non-intelligent
                        Power Distribution Units (PDUs) for efficient power management, along with IPKVM and serial
                        console devices for secure, out-of-band access to servers, network devices, and infrastructure.
                        These solutions allow administrators to monitor, manage, and troubleshoot systems remotely—even
                        at the BIOS and console level—ensuring faster response times, reduced downtime, and enhanced
                        operational efficiency.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Video Conferencing
                        Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Professional video conferencing and meeting room solutions designed to enable
                    seamless collaboration across offices, remote teams, and hybrid work environments.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end video conferencing solutions—from huddle room setups to large
                        boardroom deployments—leveraging leading platforms such as Microsoft Teams Rooms, Zoom Rooms,
                        and enterprise-grade hardware from global vendors. Our solutions include cameras, microphones,
                        display integration, and room control systems, ensuring high-quality audio and video
                        experiences. Designed for reliability and ease of use, we enable effective communication and
                        collaboration across geographically distributed teams.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-category" id="cybersecurity">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-shield-halved"></i></div>
            <h2>Cybersecurity</h2>
        </div>
        <div class="category-tagline fade-in">Defend every layer of your digital estate</div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Network & Perimeter
                        Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Next-generation network security solutions designed to protect your
                    infrastructure, prevent threats, and control access across your environment.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end network and perimeter security solutions leveraging leading
                        platforms from Sonicwall, Fortinet, Sophos, Check Point, and Palo Alto. Our offerings include
                        next-generation firewalls, intrusion prevention systems (IPS), and advanced network segmentation
                        strategies. By implementing segmentation and micro-segmentation, we help contain lateral
                        movement and safeguard critical assets—ensuring strong security posture, controlled access, and
                        resilient network architecture.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Endpoint & Device
                        Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Advanced endpoint security solutions designed to protect every device, detect
                    threats in real time, and ensure rapid response across your IT environment.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end endpoint security solutions leveraging leading EDR and XDR
                        platforms such as Microsoft Defender , Kaspersky , Bitdefender, CrowdStrike and SentinelOne for
                        Endpoint. Our solutions provide real-time threat detection, automated response, and advanced
                        threat hunting across endpoints. From deployment and policy configuration to continuous
                        monitoring and optimization, we help organizations strengthen security posture, reduce risk, and
                        protect critical devices against evolving cyber threats.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Email & Collaboration
                        Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Comprehensive protection for email and collaboration platforms to prevent
                    phishing, spoofing, malware, and data leakage.</div>
                <div class="service-details">
                    <p>We design and implement enterprise-grade email and collaboration security solutions across
                        Microsoft 365, Google Workspace, and on-premise platforms. Our approach includes advanced threat
                        protection, anti-phishing mechanisms, and secure email gateway configurations, complemented by
                        DMARC, DKIM, and SPF to prevent spoofing and business email compromise. With integrated DLP and
                        policy-driven controls, we help organisations secure communication channels, reduce risk, and
                        maintain compliance across email and collaboration platforms</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Security Awareness Training &
                        Phishing Simulation</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Strengthen your human firewall by training users to recognise, prevent, and
                    respond to cyber threats.</div>
                <div class="service-details">
                    <p>We design and deliver structured security awareness and phishing simulation programs to help
                        organisations reduce human risk. Our solutions include user training modules, simulated phishing
                        campaigns, and real-time reporting to assess employee readiness against threats such as
                        phishing, social engineering, and business email compromise. By combining continuous education
                        with measurable insights, we help build a security-aware culture and significantly lower the
                        risk of successful cyber attacks.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Data Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Comprehensive data protection solutions designed to safeguard sensitive
                    information across endpoints, networks, and cloud environments.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end data security solutions leveraging leading platforms. Our
                        offerings include data classification, encryption, and Data Loss Prevention (DLP) to protect
                        sensitive information at rest, in transit, and in use. By implementing robust data protection
                        policies and controls, we help organisations reduce risk, ensure compliance, and maintain full
                        visibility and control over critical data assets.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Application Security</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Comprehensive application security solutions designed to identify
                    vulnerabilities, protect applications, and prevent exploitation.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end application security solutions covering vulnerability
                        assessment, penetration testing, and runtime protection. Our services include SAST, DAST, and
                        manual penetration testing to identify security gaps across web applications, APIs, and mobile
                        platforms. In addition, we implement Web Application Firewalls (WAF) to protect applications
                        from real-time threats such as injection attacks, bots, and zero-day exploits. By combining
                        proactive testing with continuous protection, we help organisations secure their applications,
                        reduce risk, and ensure resilient digital platforms.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Identity & Access
                        Management</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Secure and manage user identities and access across your organisation with
                    centralized control, governance, and authentication frameworks.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end identity and access management (IAM) solutions using leading
                        platforms such as Microsoft Entra ID (Azure AD) and other leading industry solutions. Our
                        solutions include user provisioning, identity lifecycle management, single sign-on (SSO), and
                        role-based access control to ensure secure and efficient access to business applications. By
                        implementing strong authentication mechanisms, governance policies, and centralized identity
                        control, we help organisations reduce risk, improve user experience, and maintain compliance
                        across IT environments.
                    </p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> PIM and PAM</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Secure and control privileged access to critical systems with advanced
                    identity governance and zero-trust access controls.</div>
                <div class="service-details">
                    <p>We design and deliver privileged identity and access management (PIM & PAM) solutions to secure
                        administrator and high-risk accounts across your IT environment. Leveraging leading platforms
                        such as Microsoft Entra PIM and Arcon, our solutions provide just-in-time access, least
                        privilege enforcement, credential vaulting, session monitoring, and detailed audit trails. By
                        controlling privileged access and continuously monitoring activities, we help organisations
                        reduce insider risk, prevent credential misuse, and strengthen overall security posture.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> CASB, ZTNA & SASE</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Secure access to applications, users, and data with cloud-native security
                    frameworks and zero-trust connectivity models.</div>
                <div class="service-details">
                    <p>We design and deliver next-generation access and cloud security solutions including Cloud Access
                        Security Broker (CASB), Zero Trust Network Access (ZTNA), and Secure Access Service Edge (SASE).
                        Our solutions provide secure, identity-driven access to applications across cloud and on-prem
                        environments, replacing traditional VPN-based architectures. By enforcing zero-trust principles,
                        enabling continuous user verification, and securing data flow across networks and cloud
                        applications, we help organisations protect remote access, reduce attack surfaces, and ensure
                        consistent security across distributed environments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> RMM (Remote Monitoring &
                        Management)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Proactive monitoring and management of your IT infrastructure to ensure
                    performance, availability, and operational continuity.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end remote monitoring and management (RMM) solutions that provide
                        real-time visibility and control across servers, networks, endpoints, and critical IT systems.
                        Our solutions enable proactive issue detection, automated alerting, performance monitoring,
                        secure remote control, patch management, and automation—helping minimise downtime and improve
                        operational efficiency. From deployment and configuration to ongoing management and
                        optimisation, we help organisations maintain stable, secure, and high-performing IT
                        environments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> MDM (Mobile Device
                        Management)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Centralised management and security for mobile devices and endpoints to ensure
                    control, compliance, and data protection.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end mobile device management (MDM) solutions to securely manage
                        smartphones, tablets, and corporate endpoints across your organisation. Leveraging leading
                        platforms, our solutions provide device enrollment, policy enforcement, application management,
                        and remote monitoring. From secure device configuration and compliance enforcement to remote
                        wipe and lifecycle management, we help organisations maintain control, protect corporate data,
                        and enable secure access across mobile and distributed work environments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> MDR, SIEM & Managed SOC</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">24×7 threat detection, monitoring, and response services to protect your
                    organisation against evolving cyber threats.</div>
                <div class="service-details">
                    <p>We design and implement enterprise-grade MDR, SIEM, and Managed SOC services to provide
                        comprehensive security monitoring and response. Our solutions deliver real-time log collection,
                        correlation, and threat detection across your entire IT environment. Through 24×7 SOC
                        operations, advanced analytics, and threat intelligence, we enable rapid incident detection,
                        investigation, and response—helping organisations minimise risk, reduce dwell time, and
                        strengthen overall security resilience.</p>
                </div>
            </div>
        </div>

        <!-- Audits, Compliance & Risk Sub-Section -->
        <div class="services-sub-header fade-in">
            <div class="sub-header-divider"></div>
            <div class="sub-header-content">
                <div class="sub-header-icon"><i class="fas fa-clipboard-check"></i></div>
                <h3>Audits, Compliance & Risk</h3>
                <p>Know your risks. Meet your obligations.</p>
            </div>
        </div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Security Testing / VAPT</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Identify, assess, and remediate security vulnerabilities across your IT
                    environment before they can be exploited.</div>
                <div class="service-details">
                    <p>We design and deliver comprehensive vulnerability assessment and penetration testing (VAPT)
                        services across networks, applications, and infrastructure. Our assessments are conducted in
                        collaboration with CERT-In empanelled partners, ensuring adherence to industry standards and
                        regulatory expectations. Leveraging globally recognised frameworks such as OWASP, NIST, and
                        PTES, we identify security gaps, validate exploitability, and provide actionable remediation
                        guidance to strengthen your overall security posture.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> IT & Network Audit</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Comprehensive assessment of your IT and network environment to identify gaps,
                    optimise performance, and strengthen reliability and security.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end IT and network audit services via our partners covering
                        infrastructure health, configuration reviews, performance benchmarking, and gap analysis. Our
                        audits provide deep visibility into your existing environment—highlighting risks,
                        inefficiencies, and areas for improvement. With detailed reporting and actionable
                        recommendations, we help organisations enhance performance, improve security posture, and ensure
                        stable, efficient IT operations.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Compliance Audits &
                        Readiness</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Structured assessments and advisory services to help organisations meet
                    regulatory, industry, and certification requirements.</div>
                <div class="service-details">
                    <p>We design and deliver comprehensive compliance audit and readiness services in coordination with
                        our Risk and Compliance partners to help organisations align with standards such as ISO 27001,
                        SOC 2, GDPR, RBI, SEBI, and CSCRF. Our approach includes structured gap assessments, control
                        evaluations, and detailed remediation planning to ensure audit readiness. From policy
                        development and documentation to risk assessment and implementation guidance, we help
                        organisations strengthen governance, meet regulatory obligations, and achieve successful
                        certification outcomes.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Risk Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Identify, assess, and prioritise technology and operational risks through a
                    structured and governance-driven risk management approach.</div>
                <div class="service-details">
                    <p>We design and implement enterprise-grade risk management services in partnership with
                        specialised risk and compliance experts. Our structured approach covers risk identification,
                        assessment, quantification, and prioritisation across technology and operational domains. By
                        building risk registers, defining treatment strategies, and enabling board-level reporting, we
                        help organisations strengthen governance frameworks, reduce exposure, and ensure alignment with
                        regulatory and compliance requirements.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-category" id="cloud-datacenter">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-cloud"></i></div>
            <h2>Cloud & Data Centre</h2>
        </div>
        <div class="category-tagline fade-in">Scale with agility and confidence</div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Public Cloud (Azure /
                        AWS)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Design, deploy, and manage cloud environments with secure, scalable, and
                    cost-optimised architectures.</div>
                <div class="service-details">
                    <p>We design and deliver end-to-end public cloud solutions leveraging certified expertise across
                        Microsoft Azure and Amazon Web Services (AWS). Our services include cloud architecture design,
                        workload migration, cost optimisation, reserved instance planning, and ongoing cloud operations
                        management. By combining best practices with deep technical expertise, we help organisations
                        build secure, scalable, and high-performance cloud environments while optimising cost and
                        operational efficiency.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Private Cloud</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Dedicated cloud environments with full control over security, performance, and
                    data sovereignty.</div>
                <div class="service-details">
                    <p>For organisations with strict compliance, data residency, or performance requirements, we design
                        and deploy private cloud environments using VMware Cloud Foundation, Azure Stack HCI, and
                        OpenStack. Hosted on-premise or in colocation facilities, our private cloud solutions deliver
                        complete control, enhanced security, and predictable performance.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Hybrid Cloud</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Seamlessly integrate on-premise infrastructure with cloud platforms for
                    maximum flexibility.</div>
                <div class="service-details">
                    <p>We architect hybrid cloud environments that connect on-premise infrastructure with public cloud
                        services, enabling workload portability, unified management, and consistent security. Our
                        solutions provide the flexibility to run applications where they perform best—while maintaining
                        control and visibility across environments.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Cloud Migration</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Migrate your workloads to the cloud with minimal disruption and maximum
                    efficiency.</div>
                <div class="service-details">
                    <p>We deliver structured cloud migration services to help organisations move applications, data,
                        and workloads securely to the cloud. Our approach includes discovery, dependency mapping,
                        migration planning, execution, and post-migration validation—ensuring minimal downtime, reduced
                        risk, and optimal performance.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Backup & Disaster
                        Recovery</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Ensure business continuity with robust backup and disaster recovery solutions
                    across cloud and on-prem environments.</div>
                <div class="service-details">
                    <p>We design and implement comprehensive backup and disaster recovery solutions using platforms
                        such as Acronis, Veeam, and Azure Backupand Opentext. Our services include RTO/RPO planning,
                        automated backups, cloud replication, and DR testing—ensuring rapid recovery, minimal downtime,
                        and complete data protection in the event of disruptions.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Co-Location / Data Center
                        Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Host your infrastructure in secure, high-availability data center
                    environments.</div>
                <div class="service-details">
                    <p>We provide enterprise-grade colocation services across Tier III and Tier IV data centers,
                        offering secure rack space with redundant power, cooling, connectivity, and physical security.
                        Our solutions ensure high availability, compliance readiness, and optimal hosting environments
                        for critical infrastructure.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="service-category" id="managed-services">
    <div class="container">
        <div class="category-header fade-in">
            <div class="category-icon"><i class="fas fa-headset"></i></div>
            <h2>Professional Services</h2>
        </div>
        <div class="category-tagline fade-in">Your IT, running — so your business can keep moving</div>
        <div class="services-grid">
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> IT Consulting</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Strategic technology advisory to align your IT with business goals</div>
                <div class="service-details">
                    <p>Technology decisions shouldn't be made in isolation. Our consulting practice helps you plan,
                        design, and optimise your IT environment, whether you're scaling up, migrating, or starting
                        fresh.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Annual Maintenance Contracts
                        (AMC)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Predictable, hassle-free maintenance for your entire IT infrastructure.</div>
                <div class="service-details">
                    <p>An AMC gives you peace of mind, your hardware, software, and network devices are covered
                        year-round with guaranteed response times, preventive care, and expert support. No surprises. No
                        downtime anxiety.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Facility Management Services
                        (FMS)</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Dedicated on-site IT engineers embedded in your organisation, recruited,
                    trained, and managed by us.</div>
                <div class="service-details">
                    <p>Your business needs reliable, skilled IT support on the ground every day, every shift. But
                        hiring, training, retaining, and managing IT staff is expensive, time-consuming, and
                        distracting. Our FMS model gives you a fully managed IT workforce that operates as a seamless
                        extension of your team without the HR overhead.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Managed Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Proactive, always-on IT management, delivered remotely with 24/7 monitoring.
                </div>
                <div class="service-details">
                    <p>Managed Services goes beyond break-fix. We proactively monitor, manage, and optimise your entire
                        IT environment remotely, preventing issues before they become problems. Think of it as having a
                        full-scale IT operations centre working for you around the clock without the cost of building
                        one.</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Break-Fix Solutions</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Expert intervention when you need it fast, flexible, and no strings attached.
                </div>
                <div class="service-details">
                    <p>Not every IT challenge requires a long-term contract. Sometimes you just need a skilled engineer
                        to show up, diagnose the problem, and fix it fast. Our Break-Fix Solutions give you on-demand
                        access to certified professionals who resolve issues quickly so your business keeps moving</p>
                </div>
            </div>
            <div class="service-card fade-in">
                <div class="service-name">
                    <span class="service-name-text"><i class="fas fa-chevron-right"></i> Professional Services</span>
                    <i class="fas fa-chevron-right service-toggle-icon"></i>
                </div>
                <div class="service-desc">Expert hands to design, deploy, migrate, and transform, from blueprint to
                    production.
                </div>
                <div class="service-details">
                    <p>When your business needs to implement something new, upgrade what exists, or migrate to what's
                        next, our Professional Services team brings the deep technical expertise, structured
                        methodology, and project discipline to deliver on time, on budget, and on spec.</p>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="cta-section">
    <div class="container">
        <div class="cta-content anim anim-scale">
            <h2>Ready to Transform Your IT?</h2>
            <p>Let's discuss how Eden Infosol can help you build, secure and manage your technology environment end to
                end.</p>
            <a href="<?php echo esc_url($assess_url); ?>" class="btn btn-primary">Get Your Assessment</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>