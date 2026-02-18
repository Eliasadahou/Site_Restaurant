<?php
// Connexion PDO
$db_host = 'localhost';
$db_name = 'user_authentication';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? '');

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // On ne révèle pas si l'email existe ou non (sécurité) — mais on continue le flux
    if ($user) {
        // Générer un token et l'expiration
        $token = bin2hex(random_bytes(50));
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->execute([$token, $email]);
    }

    // Construire une URL absolue vers reset_password.php dans le même dossier
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST']; // ex: localhost
    $path   = rtrim(dirname($_SERVER['REQUEST_URI']), '/\\'); // ex: /Restaurant/admin
    $resetLink = $scheme . '://' . $host . $path . '/reset_password.php?token=' . urlencode($token ?? 'exemple');

    // En local, on affiche le lien (mail() ne marche souvent pas)
    $isLocal = in_array($host, ['localhost', '127.0.0.1']);

    if ($isLocal) {
        echo "Lien de réinitialisation de mot de passe cliqué : <a href='$resetLink'>ici</a>";
        
    } else {
        // En production, envoi de l'email
        // ⚠️ Remplace par PHPMailer si possible
        @mail($email, "Réinitialisation de mot de passe", "Cliquez ici pour réinitialiser : $resetLink");
        echo "Si un compte existe, un email de réinitialisation a été envoyé.";
    }
    exit;
}
