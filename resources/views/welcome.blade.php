<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Affillink - Affiliate Marketing Platform</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #10b981;
            --secondary: #3b82f6;
            --secondary-dark: #2563eb;
            --dark: #1e293b;
            --gray-dark: #475569;
            --gray: #64748b;
            --gray-light: #e2e8f0;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
            --shadow-primary: 0 10px 30px rgba(5, 150, 105, 0.2);
            --radius: 12px;
            --radius-lg: 20px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-weight: 700;
            line-height: 1.2;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.75rem;
            margin-bottom: 1rem;
            color: var(--dark);
            text-align: center;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--gray);
            text-align: center;
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 1rem;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            box-shadow: var(--shadow-primary);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(5, 150, 105, 0.3);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(5, 150, 105, 0.05);
        }

        /* Navigation - Fixed */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            padding: 18px 0;
            transition: var(--transition);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
            transition: var(--transition);
        }

        .nav-links a {
            color: var(--gray-dark);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a:hover::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            z-index: 1001;
        }

        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Hero Section */
        .hero {
            padding-top: 140px;
            padding-bottom: 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0) 70%);
            border-radius: 50%;
            z-index: -1;
        }

        .hero-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content h1 {
            font-size: 3.25rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-content p {
            font-size: 1.125rem;
            color: var(--gray);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .payment-icons {
            display: flex;
            align-items: center;
            gap: 24px;
            color: var(--gray);
            font-size: 0.875rem;
        }

        .payment-icons span {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            padding: 8px 16px;
            border-radius: 6px;
            box-shadow: var(--shadow);
        }

        /* Dashboard Preview */
        .dashboard-preview {
            background: var(--white);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            border: 1px solid var(--gray-light);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .dashboard-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            padding: 20px;
            border-radius: var(--radius);
            border: 1px solid #86efac;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(5, 150, 105, 0.15);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--primary);
            margin-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #166534;
        }

        .chart-area {
            background: linear-gradient(180deg, #dcfce7 0%, #f0fdf4 100%);
            height: 200px;
            border-radius: var(--radius);
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .chart-line {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            height: 120px;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 160' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M 0 120 Q 50 100 100 80 T 200 60 T 300 40 T 400 20' stroke='%2310b981' stroke-width='4' fill='none'/%3E%3Ccircle cx='0' cy='120' r='4' fill='%2310b981'/%3E%3Ccircle cx='100' cy='80' r='4' fill='%2310b981'/%3E%3Ccircle cx='200' cy='60' r='4' fill='%2310b981'/%3E%3Ccircle cx='300' cy='40' r='4' fill='%2310b981'/%3E%3Ccircle cx='400' cy='20' r='4' fill='%2310b981'/%3E%3C/svg%3E") no-repeat center;
            background-size: cover;
        }

        /* Features Section */
        .features {
            background: var(--white);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: var(--white);
            padding: 32px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--gray-light);
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-primary);
            border-color: var(--primary-light);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #dcfce7 0%, #86efac 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
            color: var(--primary-dark);
        }

        .feature-title {
            font-size: 1.25rem;
            margin-bottom: 12px;
            color: var(--dark);
        }

        .feature-desc {
            font-size: 0.9375rem;
            color: var(--gray);
            line-height: 1.6;
        }

        /* Analytics Section */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .analytics-preview {
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
            padding: 40px;
            border-radius: var(--radius-lg);
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .analytics-preview h3 {
            font-size: 1.5rem;
            margin-bottom: 24px;
        }

        .analytics-stats {
            background: rgba(255, 255, 255, 0.1);
            padding: 24px;
            border-radius: var(--radius);
            margin-bottom: 20px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .stat-row span:last-child {
            font-weight: 700;
        }

        /* Testimonials */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: var(--white);
            padding: 32px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--secondary) 0%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .testimonial-info h4 {
            font-size: 1.125rem;
            margin-bottom: 4px;
        }

        .testimonial-role {
            font-size: 0.875rem;
            color: var(--gray);
        }

        .testimonial-stars {
            color: #fbbf24;
            margin-bottom: 16px;
        }

        .testimonial-text {
            font-size: 0.9375rem;
            color: var(--gray);
            line-height: 1.7;
            font-style: italic;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .cta::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .cta h2 {
            font-size: 2.75rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .cta p {
            font-size: 1.125rem;
            max-width: 700px;
            margin: 0 auto 2.5rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .cta .btn-primary {
            background: var(--white);
            color: var(--primary);
            position: relative;
            z-index: 1;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: var(--gray-light);
            padding: 60px 0 30px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
        }

        .footer-column h3 {
            color: var(--white);
            font-size: 1.25rem;
            margin-bottom: 20px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--gray-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-light);
            padding-left: 5px;
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--gray);
            font-size: 0.875rem;
        }

        /* ===========================================
           RESPONSIVE STYLES
        =========================================== */

        /* Tablet (max-width: 1024px) */
        @media (max-width: 1024px) {
            .section-title {
                font-size: 2.5rem;
            }
            
            .hero-content h1 {
                font-size: 2.75rem;
            }
            
            .hero-container,
            .analytics-grid {
                gap: 40px;
            }
        }

        /* Tablet (max-width: 992px) */
        @media (max-width: 992px) {
            .hero-container,
            .analytics-grid {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero {
                padding-top: 120px;
            }
            
            .payment-icons {
                flex-wrap: wrap;
            }
        }

        /* Tablet (max-width: 768px) */
        @media (max-width: 768px) {
            /* Navigation Mobile */
            .nav-links {
                position: fixed;
                top: 0;
                right: -300px;
                width: 280px;
                height: 100vh;
                background: var(--white);
                flex-direction: column;
                justify-content: flex-start;
                padding-top: 100px;
                padding-left: 30px;
                gap: 25px;
                box-shadow: -5px 0 20px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                transition: right 0.3s ease;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .nav-links a {
                font-size: 1.125rem;
                color: var(--dark);
            }
            
            .nav-links a.btn-primary {
                margin-top: 20px;
                width: 80%;
                text-align: center;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .mobile-menu-overlay.active {
                display: block;
            }
            
            /* Hero Section */
            .hero-buttons {
                flex-direction: column;
                align-items: stretch;
            }
            
            .hero-buttons .btn {
                width: 100%;
                text-align: center;
                margin-bottom: 10px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2.25rem;
            }
            
            /* Features & Testimonials */
            .features-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            
            /* Footer */
            .footer-content {
                flex-direction: column;
                gap: 30px;
            }
            
            .footer-column {
                width: 100%;
            }
        }

        /* Mobile (max-width: 576px) */
        @media (max-width: 576px) {
            .container {
                padding: 0 16px;
            }
            
            section {
                padding: 60px 0;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.875rem;
            }
            
            .cta h2 {
                font-size: 2rem;
            }
            
            .hero-content p,
            .section-subtitle,
            .cta p {
                font-size: 1rem;
            }
            
            .btn {
                padding: 12px 24px;
                font-size: 0.9375rem;
            }
            
            .dashboard-preview,
            .feature-card,
            .testimonial-card {
                padding: 20px;
            }
            
            .analytics-preview {
                padding: 25px;
            }
            
            /* Hide dashboard chart on very small screens */
            .chart-area {
                height: 150px;
            }
            
            .payment-icons {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        /* Small Mobile (max-width: 400px) */
        @media (max-width: 400px) {
            .hero-content h1 {
                font-size: 1.75rem;
            }
            
            .section-title {
                font-size: 1.625rem;
            }
            
            .cta h2 {
                font-size: 1.75rem;
            }
            
            .feature-card,
            .testimonial-card {
                padding: 16px;
            }
            
            .analytics-preview {
                padding: 20px;
            }
            
            .footer-column h3 {
                font-size: 1.125rem;
            }
        }

        /* Landscape Mode */
        @media (max-height: 600px) and (orientation: landscape) {
            .hero {
                padding-top: 100px;
                padding-bottom: 60px;
            }
            
            .nav-links {
                padding-top: 80px;
                gap: 15px;
            }
        }

        /* Animation for elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Scroll padding untuk fixed navbar */
        html {
            scroll-padding-top: 80px;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Navigation -->
    <nav id="mainNav">
        <div class="container nav-container">
            <a href="#" class="logo">
                <div>
                    <img src="/images/logoAffilllink2.png" alt="Affilink Logo" style="height: 40px; width: auto; display: block;" />
                </div>
                <span style="margin-left: 8px;"></span>
            </a>
            
            <div class="nav-links" id="navLinks">
                <a href="#home">Home</a>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="#blog">Blog</a>
                <a href="#login">Login</a>
                <a href="#signup" class="btn btn-primary">Get Started</a>
            </div>
            
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-container">
            <div class="hero-content animate-fade-in-up">
                <h1>Grow Your Revenue with Smart Affiliate Marketing</h1>
                <p>Join our powerful affiliate platform to boost your income by partnering with top brands and earning commissions easily. Access advanced analytics, intuitive tools, and dedicated support.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-primary">Get Started Free</a>
                    <a href="#" class="btn btn-secondary">Watch Demo</a>
                </div>
                <div class="payment-icons">
                    <span><i class="fab fa-paypal"></i> PayPal</span>
                    <span><i class="fas fa-credit-card"></i> Stripe</span>
                    <span><i class="fas fa-university"></i> Bank Transfer</span>
                </div>
            </div>
            
            <div class="dashboard-preview animate-fade-in-up">
                <div class="dashboard-content">
                    <div class="dashboard-header">
                        <div class="dashboard-title">Affiliate Dashboard</div>
                        <div style="font-size: 14px; color: var(--gray); background: var(--gray-light); padding: 4px 12px; border-radius: 20px;">Last 30 Days</div>
                    </div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-label">Total Earnings</div>
                            <div class="stat-value">$5,472.50</div>
                            <div style="font-size: 12px; color: var(--primary); margin-top: 5px;"><i class="fas fa-arrow-up"></i> 12.5% from last month</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Clicks</div>
                            <div class="stat-value">12,980</div>
                            <div style="font-size: 12px; color: var(--primary); margin-top: 5px;"><i class="fas fa-arrow-up"></i> 8.2% from last month</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Conversion Rate</div>
                            <div class="stat-value">3.8%</div>
                            <div style="font-size: 12px; color: var(--primary); margin-top: 5px;"><i class="fas fa-arrow-up"></i> 1.2% from last month</div>
                        </div>
                    </div>
                    <div class="chart-area">
                        <div class="chart-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Everything You Need to Succeed</h2>
            <p class="section-subtitle">Maximize your earnings with powerful analytics and easy-to-use tools designed for affiliate marketers of all levels.</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Real-Time Tracking</h3>
                    <p class="feature-desc">Monitor clicks, conversions, and earnings in real time with our intuitive dashboard and detailed reports.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3 class="feature-title">Marketing Tools</h3>
                    <p class="feature-desc">Access a suite of promotional tools, including banners, links, landing pages, and social media integrations.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="feature-title">Easy Payouts</h3>
                    <p class="feature-desc">Get paid fast with multiple payout options, including PayPal, Stripe, and direct bank transfers.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">Dedicated Support</h3>
                    <p class="feature-desc">Our expert team is here to assist you 24/7 with any questions, strategy advice, or technical issues.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Analytics Section -->
    <section class="analytics">
        <div class="container">
            <div class="analytics-grid">
                <div class="analytics-content animate-fade-in-up">
                    <h2 class="section-title" style="text-align: left;">Optimize Your Affiliate Performance</h2>
                    <p style="margin-bottom: 20px; font-size: 1.125rem;">Maximize your earnings with powerful analytics and easy-to-use tools designed to help you track, analyze, and improve your campaigns.</p>
                    <p style="margin-bottom: 30px;">Track detailed metrics, analyze top-performing campaigns, monitor referral sources, and understand your audience better with our comprehensive dashboard.</p>
                    <a href="#" class="btn btn-primary">Explore Analytics</a>
                </div>
                
                <div class="analytics-preview animate-fade-in-up">
                    <h3>Detailed Earnings Analytics</h3>
                    <div class="analytics-stats">
                        <div class="stat-row">
                            <span>Total Earnings (All Time)</span>
                            <span>$2,135,003.00</span>
                        </div>
                        <div class="stat-row">
                            <span>2025-2026 YTD</span>
                            <span>$1,150,053.00</span>
                        </div>
                        <div class="stat-row">
                            <span>2024-2025</span>
                            <span>$985,003.00</span>
                        </div>
                    </div>
                    <p style="opacity: 0.9; font-size: 0.875rem;">Data updated in real-time. Track your progress and set goals with our advanced analytics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">Trusted by Thousands of Affiliates</h2>
            <p class="section-subtitle">Join thousands of successful marketers who have increased their earnings with Affilink.</p>
            
            <div class="testimonials-grid">
                <div class="testimonial-card animate-fade-in-up">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">JD</div>
                        <div class="testimonial-info">
                            <h4>John Doe</h4>
                            <div class="testimonial-role">Freelance Marketer</div>
                        </div>
                    </div>
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Affilink has been a game changer for me. The platform is intuitive and my earnings have increased by 65% in just three months. The support team is incredibly responsive."</p>
                </div>
                
                <div class="testimonial-card animate-fade-in-up">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">JS</div>
                        <div class="testimonial-info">
                            <h4>Jane Smith</h4>
                            <div class="testimonial-role">Digital Marketing Agency</div>
                        </div>
                    </div>
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"The detailed analytics and comprehensive reporting have transformed how we manage affiliate campaigns for our clients. Affilink makes tracking and optimization so much easier."</p>
                </div>
                
                <div class="testimonial-card animate-fade-in-up">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">MW</div>
                        <div class="testimonial-info">
                            <h4>Mark Wilson</h4>
                            <div class="testimonial-role">E-commerce Entrepreneur</div>
                        </div>
                    </div>
                    <div class="testimonial-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="testimonial-text">"Great support and fantastic tools. Affilink is the best affiliate platform I've worked with. It's streamlined our affiliate program management and increased our revenue significantly."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Maximize Your Affiliate Earnings?</h2>
            <p>Join thousands of successful marketers who trust Affilink to grow their revenue. Start your free trial today—no credit card required.</p>
            <a href="#" class="btn btn-primary">Start Free Trial Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <a href="#" class="logo" style="color: white; margin-bottom: 20px; display: inline-block;">
                        <div>
                            <img src="/images/logoAffilllink2.png" alt="Affilink Logo" style="height: 40px; width: auto; display: block;" />
                        </div>
                    </a>
                    <p style="color: var(--gray-light); max-width: 300px;">The leading affiliate marketing platform for individuals and businesses looking to maximize their revenue.</p>
                </div>
                
                <div class="footer-column">
                    <h3>Platform</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#">Affiliate Programs</a></li>
                        <li><a href="#">API Documentation</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Webinars</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2026 Affilink. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        
        mobileMenuBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            mobileMenuOverlay.classList.toggle('active');
            
            // Ubah ikon menu
            const icon = this.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        
        // Tutup menu saat overlay diklik
        mobileMenuOverlay.addEventListener('click', function() {
            navLinks.classList.remove('active');
            this.classList.remove('active');
            
            // Reset ikon menu
            const icon = mobileMenuBtn.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        });
        
        // Tutup menu saat link di klik (untuk mobile)
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                
                // Reset ikon menu
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
        });
        
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Hitung offset untuk navbar tetap
                    const navHeight = document.querySelector('nav').offsetHeight;
                    const targetPosition = targetElement.offsetTop - navHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Efek navbar saat scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
                nav.style.padding = '12px 0';
            } else {
                nav.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
                nav.style.padding = '18px 0';
            }
        });
        
        // Animate elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, observerOptions);

            // Observe elements to animate
            document.querySelectorAll('.feature-card, .testimonial-card, .analytics-content, .analytics-preview').forEach(el => {
                observer.observe(el);
            });
        });
        
        // Responsive adjustments on window resize
        window.addEventListener('resize', function() {
            // Jika ukuran layar lebih besar dari 768px, pastikan menu desktop tampil normal
            if (window.innerWidth > 768) {
                navLinks.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                
                // Reset ikon menu
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    </script>
</body>
</html>