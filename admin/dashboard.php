<?php


// Utiliser la connexion depuis includes/db.php qui est configurée pour la base restaurant
include '../includes/db.php';

// Récupérer le nombre de visiteurs depuis la base restaurant (nouvelle table site_visits)
try {
    // Vérifier si la table site_visits existe, sinon la créer
    $checkTable = $pdo->query("SHOW TABLES LIKE 'site_visits'");
    if ($checkTable->rowCount() == 0) {
        $pdo->exec("CREATE TABLE site_visits (
            id INT AUTO_INCREMENT PRIMARY KEY,
            visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            ip_address VARCHAR(45),
            user_agent TEXT,
            page_visited VARCHAR(255)
        )");
    }
    
    // Compter le nombre total de visites uniques (basé sur IP)
    $visitorsQuery = $pdo->query("
        SELECT COUNT(DISTINCT ip_address) as total_visitors 
        FROM site_visits
    ");
    $visitorsCount = $visitorsQuery->fetch(PDO::FETCH_ASSOC)['total_visitors'];
} catch (PDOException $e) {
    // En cas d'erreur, utiliser une valeur par défaut
    $visitorsCount = 0;
}
// Récupérer le nombre de commandes
$ordersQuery = $pdo->query("SELECT COUNT(*) as total_orders FROM plats_du_jour");
$ordersCount = $ordersQuery->fetch(PDO::FETCH_ASSOC)['total_orders'];

// Récupérer les données pour l'évolution des commandes (12 derniers mois)
$evolutionQuery = $pdo->query("
    SELECT 
        MONTH(m.date_menu) as month, 
        YEAR(m.date_menu) as year,
        COUNT(*) as total 
    FROM plats_du_jour p
    JOIN menus m ON p.menu_id = m.id
    WHERE m.date_menu >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY YEAR(m.date_menu), MONTH(m.date_menu)
    ORDER BY year, month
");
$evolutionData = $evolutionQuery->fetchAll(PDO::FETCH_ASSOC);

// Si pas de données, créer des données de démonstration
if (empty($evolutionData)) {
    $currentMonth = date('n');
    $currentYear = date('Y');
    $evolutionData = [];
    
    for ($i = 11; $i >= 0; $i--) {
        $month = $currentMonth - $i;
        $year = $currentYear;
        
        if ($month <= 0) {
            $month += 12;
            $year--;
        }
        
        $evolutionData[] = [
            'month' => $month,
            'year' => $year,
            'total' => rand(5, 50) // Données aléatoires pour la démonstration
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Styles professionnels pour tableau de bord */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            padding: 40px 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .dashboard-header {
            text-align: center;
            margin-bottom: 50px;
        }
        h1 {
            color: white;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            font-size: 3rem;
            letter-spacing: 1px;
        }
        .dashboard-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            font-weight: 300;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            backdrop-filter: blur(15px);
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
            background: linear-gradient(90deg, #3498db, #9b59b6);
        }
        .stat-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: #2c3e50;
            margin: 20px 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            background: linear-gradient(135deg, #3498db, #9b59b6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label {
            color: #7f8c8d;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }
        .stat-icon {
            font-size: 2rem;
            color: #3498db;
            margin-bottom: 15px;
        }
        .chart-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(15px);
            margin-top: 30px;
        }
        .chart-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 25px;
            font-size: 1.8rem;
            text-align: center;
        }
        .chart-container {
            position: relative;
            height: 400px;
        }
        .animated-element {
            animation: fadeInUp 1s ease-out;
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
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px 15px;
            }
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .stat-number {
                font-size: 2.8rem;
            }
            h1 {
                font-size: 2.2rem;
            }
            .chart-container {
                height: 300px;
            }
        }
         #back-button {
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

        #back-button:hover {
            background: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <a href="gestion.php" class="btn btn-primary" id="back-button">
                    <i class="fas fa-arrow-left"></i> 
                </a>
    <div class="dashboard-container animate__animated animate__fadeIn">
        <div class="dashboard-header animated-element">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h1>Tableau de Bord Administratif</h1>
                    <p class="dashboard-subtitle">Gestion et analyse de votre restaurant</p>
                </div>
                
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="stat-card animated-element" style="animation-delay: 0.2s;">
                <div class="stat-icon">👥</div>
                <div class="stat-number pulse"><?php echo $visitorsCount; ?></div>
                <div class="stat-label">Visiteurs Totaux</div>
            </div>
            
            <div class="stat-card animated-element" style="animation-delay: 0.4s;">
                <div class="stat-icon">📦</div>
                <div class="stat-number pulse"><?php echo $ordersCount; ?></div>
                <div class="stat-label">Commandes Total</div>
            </div>
        </div>

        <div class="chart-section animated-element" style="animation-delay: 0.6s;">
            <h2 class="chart-title">Évolution des Commandes</h2>
            <div class="chart-container">
                <canvas id="evolutionChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('evolutionChart').getContext('2d');
        const evolutionData = <?php echo json_encode($evolutionData); ?>;
        
        // Créer des labels avec les noms des mois
        const monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
        const labels = evolutionData.map(data => {
            const monthName = monthNames[data.month - 1] || 'Mois ' + data.month;
            return `${monthName} ${data.year}`;
        });
        
        const dataCounts = evolutionData.map(data => data.total);

        // Animation pour le graphique
        let animationProgress = 0;
        const animateChart = () => {
            if (animationProgress < 1) {
                animationProgress += 0.05;
                const animatedData = dataCounts.map(value => value * animationProgress);
                
                evolutionChart.data.datasets[0].data = animatedData;
                evolutionChart.update('none');
                
                requestAnimationFrame(animateChart);
            }
        };

        const evolutionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Commandes par mois',
                    data: dataCounts.map(() => 0), // Commence à 0 pour l'animation
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#2c3e50'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#2c3e50',
                        bodyColor: '#2c3e50',
                        borderColor: '#3498db',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return `Commandes: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#7f8c8d'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            color: '#7f8c8d'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Démarrer l'animation après un délai
        setTimeout(() => {
            animateChart();
        }, 1000);

        // Animation de survol pour les points du graphique
        ctx.canvas.addEventListener('mousemove', (e) => {
            const points = evolutionChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
            if (points.length) {
                ctx.canvas.style.cursor = 'pointer';
            } else {
                ctx.canvas.style.cursor = 'default';
            }
        });
    </script>
</body>
</html>
