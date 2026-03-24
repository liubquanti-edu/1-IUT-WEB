<?php
$userId = (int) ($_POST['user_id'] ?? 0);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Audit sécurité - Menu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Audit de sécurité — Menu</h1>

  <?php if ($userId <= 0): ?>
    <div class="card">
      <p>Merci de vous authentifier pour accéder aux fonctionnalités.</p>
      <a class="btn" href="login.php">Aller à la page de connexion</a>
    </div>
  <?php else: ?>
    <div class="card">
      <h2>Bienvenue</h2>
      <p class="muted">Vous êtes connecté en tant qu'utilisateur #<?= htmlspecialchars((string) $userId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>.</p>
      <ul>
        <li>
          <form method="post" action="consult.php">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars((string) $userId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            <button class="btn secondary" type="submit">Consulter un poste existant</button>
          </form>
        </li>
        <li>
          <span class="muted">Mettre à jour un poste (en construction)</span>
        </li>
        <li>
          <form method="post" action="poste.php">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars((string) $userId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
            <button class="btn" type="submit">Saisir un nouveau poste</button>
          </form>
        </li>
      </ul>
    </div>
  <?php endif; ?>
</body>
</html>