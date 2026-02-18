<?php
// Système de suivi des visites
include 'db.php';

function trackVisit() {
    global $pdo;
    
    try {
        // Vérifier si la table site_visits existe
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
        
        // Récupérer les informations de la visite
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $page_visited = $_SERVER['REQUEST_URI'];
        
        // Vérifier si cette IP a déjà visité aujourd'hui (pour éviter les doublons)
        $today = date('Y-m-d');
        $checkVisit = $pdo->prepare("
            SELECT COUNT(*) as today_visits 
            FROM site_visits 
            WHERE ip_address = ? AND DATE(visit_date) = ?
        ");
        $checkVisit->execute([$ip_address, $today]);
        
        if ($checkVisit->fetch(PDO::FETCH_ASSOC)['today_visits'] == 0) {
            // Enregistrer la visite
            $insertVisit = $pdo->prepare("
                INSERT INTO site_visits (ip_address, user_agent, page_visited) 
                VALUES (?, ?, ?)
            ");
            $insertVisit->execute([$ip_address, $user_agent, $page_visited]);
        }
        
    } catch (PDOException $e) {
        // En cas d'erreur, on ignore silencieusement pour ne pas affecter l'expérience utilisateur
        error_log("Erreur de suivi des visites: " . $e->getMessage());
    }
}

// Appeler la fonction pour suivre la visite
trackVisit();
?>
