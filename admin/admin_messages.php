<?php
session_start();

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$db_host = 'localhost';
$db_name = 'user_authentication';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

try {
    // Récupérer tous les messages
    $stmt = $pdo->query("SELECT * FROM messages_contact ORDER BY date_creation DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Compter les statistiques
    $total_messages = count($messages);
    $unread_count = count(array_filter($messages, function($m) { return !$m['is_read']; }));
} catch (PDOException $e) {
    die("Erreur de base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages des utilisateurs - Administration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin: 20px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--success-gradient);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .message-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: slideInUp 0.6s ease-out;
        }

        .message-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--hover-shadow);
        }

        .message-header {
            background: var(--primary-gradient);
            color: white;
            padding: 20px 25px;
            position: relative;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .message-meta {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-read {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .status-unread {
            background: #ff6b6b;
            color: white;
            animation: pulse 2s infinite;
        }

        .message-content {
            padding: 25px;
            line-height: 1.8;
            color: #2c3e50;
            font-size: 1.1rem;
            background: #f8f9fa;
            margin: 0 25px 25px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .message-actions {
            padding: 0 25px 25px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-custom {
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-read {
            background: var(--success-gradient);
            color: white;
        }

        .btn-delete {
            background: var(--danger-gradient);
            color: white;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
            }
        }

        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.9);
            color: #667eea;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .back-button:hover {
            background: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <a href="gestion.php" class="back-button" title="Retour">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="container-fluid">
        <div class="admin-header" data-aos="fade-down">
            <div class="text-center mb-4">
                <h1 class="display-4 fw-bold text-primary">
                    <i class="fas fa-envelope-open-text me-3"></i>
                    Messages des utilisateurs
                </h1>
                <p class="lead text-muted">Gérez les messages de contact de vos utilisateurs</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-number"><?= $total_messages ?></div>
                    <div class="text-muted">Total Messages</div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div class="stat-number"><?= $unread_count ?></div>
                    <div class="text-muted">Non lus</div>
                </div>
                
                <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?= $total_messages - $unread_count ?></div>
                    <div class="text-muted">Messages lus</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <?php if (empty($messages)): ?>
                    <div class="empty-state" data-aos="fade-up">
                        <i class="fas fa-inbox"></i>
                        <h3>Aucun message</h3>
                        <p class="text-muted">Vous n'avez aucun message pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $index => $message): ?>
                        <div class="message-card" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                            <div class="message-header">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($message['email']) ?></div>
                                        <div class="message-meta">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('d/m/Y à H:i', strtotime($message['date_creation'])) ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <span class="status-badge <?= $message['is_read'] ? 'status-read' : 'status-unread' ?>">
                                    <i class="fas fa-circle me-1"></i>
                                    <?= $message['is_read'] ? 'Lu' : 'Non lu' ?>
                                </span>
                            </div>
                            
                            <div class="message-content">
                                <?= nl2br(htmlspecialchars($message['message'])) ?>
                            </div>
                            
                            <div class="message-actions">
                                <?php if (!$message['is_read']): ?>
                                    <a href="mark_as_read.php?id=<?= $message['id'] ?>" class="btn btn-custom btn-read">
                                        <i class="fas fa-check"></i>
                                        Marquer comme lu
                                    </a>
                                <?php endif; ?>
                                
                                <a href="delete_message.php?id=<?= $message['id'] ?>" class="btn btn-custom btn-delete"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                    <i class="fas fa-trash"></i>
                                    Supprimer
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Auto-hide alerts after 3 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>
</body>
</html>
