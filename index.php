<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Restaurant SENA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #FFD700;
            --text-light: #f3efef;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-light);
        }
        
        .navbar {
            background: rgba(139, 69, 19, 0.95) !important;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 0;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }
        
        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s both;
        }
        
        .para {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 1s ease 0.4s both;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        
        .contact-section {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 50px;
            margin: 50px 0;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            color: white;
        }
        
        .social-media a {
            display: inline-block;
            margin: 0 15px;
            transition: all 0.3s ease;
        }
        
        .social-media a:hover {
            transform: translateY(-5px) scale(1.2);
        }
        
        .social-media img {
            transition: all 0.3s ease;
            filter: grayscale(100%);
        }
        
        .social-media a:hover img {
            filter: grayscale(0%);
        }
        
        footer {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px 0;
            margin-top: 50px;
        }
        
        .error {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .success {
            color: #51cf66;
            background: rgba(81, 207, 102, 0.1);
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
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
        
        .scroll-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform-origin: left;
            transform: scaleX(0);
            z-index: 9999;
        }
    </style>
</head>
<body>
    <div class="scroll-indicator"></div>
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="idex.php">
                <i class="fas fa-utensils me-2"></i>Restaurant SENA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu_du_jour.php">Menu du Jour</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="apropos.php">À Propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center hero-content" data-aos="fade-up">
                    <h1>Bienvenue au Restaurant SENA</h1>
                    <p class="lead">Découvrez l'authenticité de la cuisine béninoise dans un cadre chaleureux et convivial</p>
                    <div class="para">
                        <p>Chez SENA, nous croyons que chaque repas est une célébration. Niché au cœur de Bohicon, 
                        notre établissement allie tradition et modernité pour vous offrir une expérience culinaire unique, 
                        où les saveurs authentiques rencontrent la créativité.</p>
                        <p>Notre cuisine, généreuse et raffinée, est le fruit d’un travail minutieux et d’ingrédients 
                        soigneusement sélectionnés. Des produits frais, locaux et de saison sont transformés avec passion 
                        par nos chefs pour éveiller vos papilles.</p>
                    </div>
                    <a href="#contact" class="btn btn-primary btn-lg mt-4">Réservez votre table</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center">
                        <i class="fas fa-utensils fa-3x mb-3" style="color: var(--accent-color);"></i>
                        <h3>Cuisine Authentique</h3>
                        <p>Des recettes traditionnelles transmises de génération en génération</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center">
                        <i class="fas fa-leaf fa-3x mb-3" style="color: var(--accent-color);"></i>
                        <h3>Produits Frais</h3>
                        <p>Des ingrédients locaux et de saison pour une fraîcheur optimale</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-center">
                        <i class="fas fa-heart fa-3x mb-3" style="color: var(--accent-color);"></i>
                        <h3>Accueil Chaleureux</h3>
                        <p>Un service attentionné dans une ambiance conviviale</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
// Inclure le suivi des visites
include 'includes/track_visit.php';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $errors = [];
    $success = '';

    // Validation
    if (empty($email)) {
        $errors[] = "L'adresse email est requise";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide";
    }

    if (empty($message)) {
        $errors[] = "Le message est requis";
    } elseif (strlen($message) < 10) {
        $errors[] = "Le message doit contenir au moins 10 caractères";
    }

    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        $db_host = 'localhost';
        $db_name = 'user_authentication';
        $db_user = 'root';
        $db_pass = '';
        
        // Connexion à la base de données
        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        $stmt = $pdo->prepare("INSERT INTO contact_messages (email, message, ip_address) VALUES (?, ?, ?)");
$stmt->execute([
    $email,
    $message,
    $_SERVER['REMOTE_ADDR']
]);
        $to = 'adahouelias5@gmail.com'; // Email de l'administrateur
        $subject = 'Commande ou commentaire';
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $success = "Votre message a été envoyé avec succès!";
        
       
    }
}


?>
    <section id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-section">
                        <h2 class="text-center mb-4">Contactez-nous</h2>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="error">
                                <?php foreach ($errors as $error): ?>
                                    <p><?= htmlspecialchars($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($success)): ?>
                            <div class="success">
                                <p><?= htmlspecialchars($success) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" data-aos="fade-up">
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" 
                                       placeholder="Votre adresse email" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="message" rows="5" 
                                          placeholder="Votre message..." required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p>Suivez-nous sur nos réseaux sociaux</p>
                            <div class="social-media">
                                <a href="https://www.facebook.com" target="_blank">
                                    <img src="https://img.icons8.com/?size=48&id=YFbzdUk7Q3F8&format=png" 
                                         alt="Facebook" width="40" height="40">
                                </a>
                                <a href="https://www.instagram.com" target="_blank">
                                    <img src="https://img.icons8.com/?size=48&id=ZRiAFreol5mE&format=gif" 
                                         alt="Instagram" width="40" height="40">
                                </a>
                                <a href="https://wa.me/57816564" target="_blank">
                                    <img src="https://img.icons8.com/?size=80&id=5lQKOaVNF38O&format=png" 
                                         alt="WhatsApp" width="40" height="40">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4">
        <div class="container">
            <p>&copy; 2025 Restaurant SENA. Tous droits réservés.<br>Créer par Elias ADAHOU</p>
            <p>Adresse : 123 Rue de la Gastronomie, Bohicon, Bénin</p>
            <p>Téléphone : +229 1234 5678</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
        
        // Scroll indicator
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            const docHeight = document.body.offsetHeight - window.innerHeight;
            const scrollPercent = scrollTop / docHeight;
            document.querySelector('.scroll-indicator').style.transform = `scaleX(${scrollPercent})`;
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
