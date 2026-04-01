<?php
require_once __DIR__ . '/includes/poste_form.php';

$userId = (int) ($_POST['user_id'] ?? 0);

$post = [
  'hostname' => '',
  'ip'       => '',
  'cidr'     => '',
  'gateway'  => '',
  'vlan'     => '',
  'port'     => '',
];

$postErrors = [];
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Audit securite - Nouveau poste</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Saisir un nouveau poste</h1>

  <div class="card">
    <?php if ($userId <= 0): ?>
      <p class="error">Impossible d'accéder au formulaire sans authentification.</p>
      <a class="btn" href="login.php">Retour connexion</a>
    <?php else: ?>
      <?php render_post_form($post, $postErrors, $userId); ?>
    <?php endif; ?>
  </div>

</body>
</html>