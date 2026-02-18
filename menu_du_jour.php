<?php 
$dbname = 'restaurant';
$host = 'localhost';
$username = 'root';
$password = '';
try{
    $pdo=new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
<?php
// Inclure le suivi des visites
include 'includes/track_visit.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu du Jour - Restaurant SENA</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #FFD700;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 80px 0;
            margin-top: 76px;
        }

        .menu-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            background: white;
        }

        .menu-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .menu-img {
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .menu-card:hover .menu-img {
            transform: scale(1.1);
        }

        .price-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--accent-color);
            color: var(--text-dark);
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .btn-order {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-order:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 50px;
        }

        .spinner-border {
            color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .footer-custom {
            background: var(--text-dark);
            color: white;
            padding: 40px 0;
            margin-top: 80px;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .back-to-top:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }
            
            .menu-card {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-utensils me-2"></i>Restaurant SENA
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
                        <a class="nav-link active" href="menu_du_jour.php">Menu du Jour</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="apropos.php">À Propos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container" data-aos="fade-up">
            <h1 class="display-4 fw-bold mb-3">
                <i class="fas fa-calendar-day me-3"></i>Menu du Jour
            </h1>
            <p class="lead fs-4">
                <i class="fas fa-clock me-2"></i><?php echo date('l d F Y'); ?>
            </p>
            <p class="fs-5 opacity-75">Découvrez nos spécialités du jour, préparées avec amour</p>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title display-5">Nos Spécialités du Jour</h2>
                <p class="text-muted fs-5">Préparées fraîchement chaque matin</p>
            </div>

            <!-- Loading State -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <p class="mt-3">Chargement du menu...</p>
            </div>

            <!-- Menu Items -->
            <div class="row" id="menuContainer">
                <?php
                $sql = "SELECT * FROM menus  ORDER BY prix ASC";
                $stmt = $pdo->query($sql);
                
                if($stmt->rowCount() > 0) {
                    $delay = 0;
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $image = !empty($row['image']) ? 'admin/' . $row['image'] : 'https://via.placeholder.com/400x250/8B4513/FFFFFF?text=' . urlencode($row['titre']);
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="card menu-card">
                                <span class="price-badge"><?php echo number_format($row['prix'], 0, ',', ' '); ?> F CFA</span>
                                <img src="<?php echo $image; ?>" class="card-img-top menu-img" alt="<?php echo htmlspecialchars($row['titre']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($row['titre']); ?></h5>
                                    <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-order">
                                            <i class="fas fa-shopping-cart me-2"></i>Commander
                                        </button>
                                        <small class="text-muted">
                                            <i class="fas fa-fire me-1"></i>Populaire
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $delay += 100;
                    }
                } else {
                    ?>
                    <div class="col-12">
                        <div class="empty-state" data-aos="fade-up">
                            <i class="fas fa-utensils"></i>
                            <h3>Menu en préparation</h3>
                            <p>Revenez plus tard pour découvrir nos spécialités du jour !</p>
                            <a href="idex.php" class="btn btn-order mt-3">
                                <i class="fas fa-home me-2"></i>Retour à l'accueil
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <h5><i class="fas fa-utensils me-2"></i>Restaurant SENA</h5>
                    <p>Cuisine béninoise authentique préparée avec passion</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <h5>Contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Rue de la Gastronomie, Bohicon</p>
                    <p><i class="fas fa-phone me-2"></i>+229 1234 5678</p>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <h5>Horaires</h5>
                    <p><i class="fas fa-clock me-2"></i>Lun-Dim: 7h00 - 22h00</p>
                    <p><i class="fas fa-calendar me-2"></i>Menu du jour: Mise à jour quotidienne</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2025 Restaurant SENA. Tous droits réservés.<br>Créer par Elias ADAHOU</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Back to top functionality
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'flex';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth loading animation
        window.addEventListener('load', () => {
            document.getElementById('loadingSpinner').style.display = 'none';
        });

        // Add hover effects to cards
        document.querySelectorAll('.menu-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
