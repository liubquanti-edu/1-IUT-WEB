<?php
require_once __DIR__ . '/includes/db.php';

function clean(?string $value): string {
    return trim((string) $value);
}

function escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$pdo = null;
$dbError = null;
try {
    $pdo = get_pdo();
} catch (Throwable $e) {
    $dbError = $e->getMessage();
}

$error = '';
$login = '';
$userId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $dbError === null && $pdo instanceof PDO) {
    $login = clean($_POST['login'] ?? '');
    $password = clean($_POST['password'] ?? '');

    if ($login === '' || $password === '') {
        $error = 'Login et mot de passe requis.';
    } else {
        $user = find_user_by_credentials($pdo, $login, $password);
        if ($user === null) {
            $error = 'Identifiants invalides.';
        } else {
            $userId = (int) $user['id'];
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Audit securite - Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Connexion auditeur</h1>
  <div class="card">
    <?php if ($dbError !== null): ?>
      <p class="error">Erreur base de donnees : <?= escape($dbError); ?></p>
    <?php elseif ($userId !== null): ?>
      <p>Authentification réussie.</p>
      <form method="post" action="index.php" id="redir-form">
        <input type="hidden" name="user_id" value="<?= escape((string) $userId); ?>">
        <button class="btn" type="submit">Accéder au menu</button>
      </form>
      <script>
        setTimeout(function(){ document.getElementById('redir-form').submit(); }, 400);
      </script>
    <?php else: ?>
      <?php if ($error !== ''): ?>
        <p class="error"><?= escape($error); ?></p>
      <?php endif; ?>
      <form method="post" action="login.php" novalidate>
        <label for="login">Identifiant</label>
        <input type="text" name="login" id="login" required value="<?= escape($login); ?>">

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <button class="btn" type="submit">Se connecter</button>
      </form>
      <details>
        <summary>Comprendre l'injection SQL (exemple)</summary>
        <p>Une requête non préparée du type <code>WHERE login = '$login'</code> peut être détournée si un utilisateur saisit par exemple <code>admin' --</code> en login, car tout ce qui suit <code>--</code> est commenté par MySQL.</p>
      </details>
    <?php endif; ?>
  </div>
</body>
</html>
