<?php
require_once __DIR__ . '/includes/db.php';

function escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$userId = (int) ($_POST['user_id'] ?? $_GET['user_id'] ?? 0);
$pdo = null;
$dbError = null;
$summary = [];

if ($userId > 0) {
    try {
        $pdo = get_pdo();
        $summary = fetch_audit_summary($pdo, $userId);
    } catch (Throwable $e) {
        $dbError = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Audit sécurité - Rapport de synthèse</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Rapport de synthèse</h1>

  <form method="post" action="index.php" style="margin-bottom:16px;">
    <input type="hidden" name="user_id" value="<?= escape((string) $userId); ?>">
    <button class="btn" type="submit">Retour menu</button>
  </form>

  <?php if ($userId <= 0): ?>
    <div class="card">
      <p class="error">Merci de vous connecter pour accéder au bilan d'audit.</p>
      <a class="btn" href="login.php">Aller à la connexion</a>
    </div>
  <?php elseif ($dbError !== null): ?>
    <div class="card">
      <p class="error">Erreur base de données : <?= escape($dbError); ?></p>
    </div>
  <?php else: ?>
    <div class="card">
      <h2>Résumé des failles détectées</h2>
      <?php if (empty($summary)): ?>
        <p class="muted">Aucun pentest n'a encore été enregistré pour générer un rapport.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Faille</th>
              <th>Postes impactés</th>
              <th>Gravité maximale</th>
              <th>Nombre de détections</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($summary as $row): ?>
            <tr>
              <td><?= escape($row['faille'] ?? ''); ?></td>
              <td><?= escape($row['postes'] ?? ''); ?></td>
              <td><?= escape($row['worst_level'] ?? 'Inconnu'); ?></td>
              <td><?= escape((string) ($row['occurrences'] ?? 0)); ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</body>
</html>
