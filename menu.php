<?php
// Inclure le suivi des visites
include 'includes/track_visit.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Restaurant SENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #FFD700;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
        }
        .navbar {
            background: var(--primary-color) !important;
        }
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 100px 0;
        }
        .menu-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .menu-img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-order {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-order:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-utensils me-2"></i>Restaurant SENA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="menu.php">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu_du_jour.php">Menu du Jour</a></li>
                    <li class="nav-item"><a class="nav-link" href="apropos.php">À Propos</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container" data-aos="fade-up">
            <h1 class="display-4 fw-bold">Notre Menu</h1>
            <p class="lead">Découvrez nos plats traditionnels béninois</p>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5" style="color: var(--primary-color);">Plats Principaux</h2>
            <div class="row">
                <!-- Djèwo -->
                <div class="col-lg-6 mb-4" data-aos="fade-up">
                    <div class="card menu-card">
                        <span class="price-badge">10 F CFA</span>
                        <img src="https://visiter-le-benin.com/wp-content/uploads/2020/05/Amiwo.jpg" class="card-img-top menu-img" alt="Djèwo">
                        <div class="card-body">
                            <h5 class="card-title">Le Djèwo (ou Amiwô)</h5>
                            <p class="card-text">Pâte de maïs assaisonnée avec sauce, accompagnée de viande de poulet, dinde ou pintade.</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <!-- Watché -->
                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card menu-card">
                        <span class="price-badge">12 F CFA</span>
                        <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD..." class="card-img-top menu-img" alt="Watché">
                        <div class="card-body">
                            <h5 class="card-title">Le Watché (ou Atassi)</h5>
                            <p class="card-text">Mélange exquis de haricot et de riz, très présent dans tout le Bénin.</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <!-- Télibo -->
                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card menu-card">
                        <span class="price-badge">8 F CFA</span>
                        <img src="https://example.com/telibo.jpg" class="card-img-top menu-img" alt="Télibo">
                        <div class="card-body">
                            <h5 class="card-title">TELIBO</h5>
                            <p class="card-text">Pâte noire ou marron obtenue à base de cossette d'igname, servie avec sauce gluante ou légume.</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <!-- Ablo -->
                <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card menu-card">
                        <span class="price-badge">15 F CFA</span>
                        <img src="https://critikmag.com/wp-content/uploads/2024/10/ablo-critikmag-1024x538.png" class="card-img-top menu-img" alt="Ablo">
                        <div class="card-body">
                            <h5 class="card-title">ABLO</h5>
                            <p class="card-text">Pain de maïs traditionnel, recette des Guin d'Aného, très apprécié des Béninois et touristes.</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-center mb-5 mt-5" style="color: var(--primary-color);">Desserts & Boissons</h2>
            <div class="row">
                <!-- Boissons -->
                <div class="col-lg-3 mb-4" data-aos="fade-up">
                    <div class="card menu-card">
                        <span class="price-badge">700 F CFA</span><br><br>
                        <div class="card-body text-center">
                            <h5 class="card-title">La Béninoise</h5>
                            <p class="card-text">Bière locale</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card menu-card">
                        <span class="price-badge">200 F CFA</span><br><br>
                        <div class="card-body text-center">
                            <h5 class="card-title">TCHAKALO</h5>
                            <p class="card-text">Boisson traditionnelle</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card menu-card">
                        <span class="price-badge">200 F CFA</span><br><br>
                        <div class="card-body text-center">
                            <h5 class="card-title">ADOYO</h5>
                            <p class="card-text">Jus naturel</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card menu-card">
                        <span class="price-badge">400 F CFA</span><br><br>
                        <div class="card-body text-center">
                            <h5 class="card-title">Les JUS</h5>
                            <p class="card-text">Variété de jus frais</p>
                            <button class="btn btn-order">Commander</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2025 Restaurant SENA. Tous droits réservés.<br>Créer par Elias ADAHOU</p>
            <p>Adresse : 123 Rue de la Gastronomie, Bohicon, Bénin</p>
            <p>Téléphone : +229 1234 5678</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
