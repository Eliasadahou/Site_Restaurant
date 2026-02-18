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

if (!isset($_GET['token']) || !preg_match('/^[a-f0-9]{100}$/', $_GET['token'])) {
    die("Lien invalide.");
}
$token = $_GET['token'];

// Chercher l'utilisateur par token valide et non expiré
$stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expire > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Lien expiré ou invalide.");
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pwd = $_POST['password'] ?? '';
    $pwd2 = $_POST['password_confirm'] ?? '';

    if (strlen($pwd) < 6) {
        $err = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($pwd !== $pwd2) {
        $err = "Les deux mots de passe ne correspondent pas.";
    } else {
        $hash = password_hash($pwd, PASSWORD_DEFAULT);
        $up = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expire = NULL WHERE id = ?");
        $up->execute([$hash, $user['id']]);
        echo "Mot de passe réinitialisé avec succès. <a href='login.php'>Se connecter</a>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Réinitialiser le mot de passe</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="mb-3">Nouveau mot de passe</h5>
          <?php if (!empty($err)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">Mot de passe</label>
              <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
              <label class="form-label">Confirmer le mot de passe</label>
              <input type="password" name="password_confirm" class="form-control" required minlength="6">
            </div>
            <button class="btn btn-primary w-100" type="submit">Réinitialiser</button>
          </form>
        </div>
      </div>
      <p class="text-center mt-3"><a href="login.php">Retour à la connexion</a></p>
    </div>
  </div>
</div>
</body>
</html>
