<?php
session_start();

// Configuration de la base de données
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

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Vérification des identifiants
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
       
        // Redirection vers la page d'administration
        header("Location: gestion.php");
        exit();
    } else {
        // Identifiants incorrects
        $error = "Nom d'utilisateur ou mot de passe incorrect";
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }
} else {
    // Accès direct à la page sans soumission de formulaire
    header("Location: login.php");
    exit();
}
?>