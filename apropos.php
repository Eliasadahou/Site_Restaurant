<?php
// Inclure le suivi des visites
include 'includes/track_visit.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - Restaurant SENA</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #FFD700;
            --text-dark: #2C1810;
            --text-light: #F5F5DC;
            --gradient-bg: linear-gradient(135deg, #8B4513 0%, #D2691E 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--text-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }
        
        .navbar {
            background: rgba(139, 69, 19, 0.95) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--accent-color) !important;
        }
        
        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: var(--accent-color) !important;
            transform: translateY(-2px);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background: var(--accent-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 80%;
        }
        
        .hero-section {
            background: var(--gradient-bg);
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }
        
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.3s both;
        }
        
        .about-section {
            padding: 100px 0;
            background: white;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 60px;
            height: 3px;
            background: var(--secondary-color);
            transform: translateX(-50%);
            animation: expandWidth 1s ease-out;
        }
        
        .about-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .about-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,215,0,0.1), transparent);
            transition: left 0.5s;
        }
        
        .about-card:hover::before {
            left: 100%;
        }
        
        .about-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }
        
        .stats-section {
            background: var(--gradient-bg);
            color: white;
            padding: 80px 0;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--accent-color);
            display: block;
            animation: countUp 2s ease-out;
        }
        
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .footer {
            background: var(--text-dark);
            color: var(--text-light);
            padding: 60px 0 20px;
        }
        
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--accent-color);
        }
        
        .social-links a {
            color: var(--text-light);
            font-size: 1.5rem;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            color: var(--accent-color);
            transform: scale(1.2);
        }
        
        /* Animations */
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
        
        @keyframes expandWidth {
            from {
                width: 0;
            }
            to {
                width: 60px;
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .about-card {
                margin-bottom: 30px;
            }
        }
        
        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.appear {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-utensils me-2"></i>
                Restaurant SENA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="apropos.php">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="idex.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <h1 class="hero-title">À Propos de Nous</h1>
                <p class="hero-subtitle">Découvrez notre histoire et notre passion pour la gastronomie</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5" data-aos="fade-up">
                    <h2 class="section-title">Notre Histoire</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="about-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-center mb-4">
                            <i class="fas fa-utensils feature-icon"></i>
                        </div>
                        <h3 class="text-center mb-4">Bienvenue chez SENA</h3>
                        <p class="lead text-center mb-4">
                            Chez SENA, nous croyons que chaque repas est une célébration. Niché au cœur de Bohicon, 
                            notre établissement allie tradition et modernité pour vous offrir une expérience culinaire unique.
                        </p>
                        
                        <div class="row mt-5">
                            <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="300">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-seedling feature-icon me-3"></i>
                                    <div>
                                        <h5>Ingrédients Frais</h5>
                                        <p class="mb-0">Des produits locaux et de saison soigneusement sélectionnés</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="300">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-chef-hat feature-icon me-3"></i>
                                    <div>
                                        <h5>Chefs Passionnés</h5>
                                        <p class="mb-0">Une équipe de chefs talentueux et passionnés par la gastronomie</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="400">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-heart feature-icon me-3"></i>
                                    <div>
                                        <h5>Service Attentionné</h5>
                                        <p class="mb-0">Un service chaleureux et attentionné pour chaque client</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="400">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-award feature-icon me-3"></i>
                                    <div>
                                        <h5>Excellence</h5>
                                        <p class="mb-0">Un engagement constant envers la qualité et l'excellence</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                        <span class="stat-number" data-count="15">0</span>
                        <span class="stat-label">Années d'expérience</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                        <span class="stat-number" data-count="50">0</span>
                        <span class="stat-label">Plats signature</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                        <span class="stat-number" data-count="1000">0</span>
                        <span class="stat-label">Clients satisfaits</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                        <span class="stat-number" data-count="5">0</span>
                        <span class="stat-label">Étoiles Michelin</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="footer-brand">Restaurant SENA</h5>
                    <p>Une expérience gastronomique unique au cœur de Bohicon.</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Rue de la Gastronomie, Bohicon</p>
                    <p><i class="fas fa-phone me-2"></i>+229 1234 5678</p>
                    <p><i class="fas fa-envelope me-2"></i>contact@restaurant-sena.com</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Suivez-nous</h5>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p>&copy; 2025 Restaurant SENA. Tous droits réservés.<br>Créer par Elias ADAHOU</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Counter animation
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200;

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };

            // Start animation when element is visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateCount();
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(counter);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(139, 69, 19, 0.98)';
            } else {
                navbar.style.background = 'rgba(139, 69, 19, 0.95)';
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
