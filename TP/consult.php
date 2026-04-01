<?php
require_once __DIR__ . '/includes/db.php';

function escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function render_table(array $rows, array $columns, string $emptyMessage = ''): void {
    if (empty($rows)) {
        if ($emptyMessage !== '') {
            echo '<p class="muted">' . escape($emptyMessage) . '</p>';
        }
        return;
    }

    echo '<table>';
    echo '<thead><tr>';
    foreach ($columns as $column) {
        echo '<th>' . escape($column['label']) . '</th>';
    }
    echo '</tr></thead><tbody>';

    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($columns as $column) {
            $value = '';
            $isHtml = $column['html'] ?? false;
            if (isset($column['formatter']) && is_callable($column['formatter'])) {
                $value = $column['formatter']($row);
            } else {
                $field = $column['field'] ?? null;
                if ($field !== null) {
                    $value = $row[$field] ?? '';
                }
            }
            echo '<td>';
            echo $isHtml ? $value : escape((string) $value);
            echo '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody></table>';
}

$userId = (int) ($_POST['user_id'] ?? $_GET['user_id'] ?? 0);

$pdo = null;
$dbError = null;
try {
    $pdo = get_pdo();
} catch (Throwable $e) {
    $dbError = $e->getMessage();
}

$posts = [];
$selectedPost = null;
$pentests = [];
$selectedId = isset($_POST['id']) ? (int) $_POST['id'] : (isset($_GET['id']) ? (int) $_GET['id'] : null);

if ($userId > 0 && $dbError === null && $pdo instanceof PDO) {
    try {
    $posts = fetch_posts($pdo, $userId);
        if ($selectedId) {
      $selectedPost = find_post($pdo, $selectedId, $userId);
            if ($selectedPost) {
        $pentests = fetch_pentests($pdo, $selectedPost['id'], $userId);
            }
        }
    } catch (PDOException $e) {
        $dbError = $e->getMessage();
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Audit securite - Consultation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Consultation des postes</h1>
  <?php if ($userId > 0): ?>
    <form method="post" action="index.php" style="display:inline-block;margin-bottom:16px;">
      <input type="hidden" name="user_id" value="<?= escape((string) $userId); ?>">
      <button class="btn" type="submit">Retour menu</button>
    </form>
  <?php endif; ?>

  <?php if ($userId <= 0): ?>
    <div class="card">
      <p class="error">Merci de vous connecter avant de consulter les postes.</p>
      <a class="btn" href="login.php">Aller à la connexion</a>
    </div>
  <?php elseif ($dbError !== null): ?>
    <div class="card">
      <p class="error">Erreur base de donnees : <?= escape($dbError); ?></p>
    </div>
  <?php else: ?>
    <div class="card">
      <h2>Liste des postes</h2>
      <?php
        render_table(
            $posts,
            [
                ['label' => 'ID', 'field' => 'id'],
                [
                  'label' => 'Hostname',
                  'formatter' => function (array $row) use ($userId): string {
                    $id = (int) ($row['id'] ?? 0);
                    $host = $row['hostname'] ?? '';
                    $url = 'consult.php?id=' . urlencode((string) $id) . '&user_id=' . urlencode((string) $userId);
                    return '<a href="' . $url . '">' . escape($host) . '</a>';
                  },
                  'html' => true,
                ],
                ['label' => 'IP/CIDR', 'formatter' => static function (array $row): string {
                    $ip = $row['ip'] ?? '';
                    $cidr = $row['cidr'] ?? '';
                    return trim($ip . '/' . $cidr, '/');
                }],
                ['label' => 'VLAN', 'field' => 'vlan'],
                ['label' => 'Port', 'field' => 'port'],
            ],
            'Aucun poste enregistre pour le moment.'
        );
      ?>
    </div>

    <?php if ($selectedPost !== null): ?>
      <div class="card">
        <h2>Details du poste #<?= escape((string) $selectedPost['id']); ?></h2>
        <table>
          <tbody>
            <tr><th>Hostname</th><td><?= escape($selectedPost['hostname']); ?></td></tr>
            <tr><th>Adresse IP</th><td><?= escape($selectedPost['ip']); ?>/<?= escape($selectedPost['cidr']); ?></td></tr>
            <tr><th>Passerelle</th><td><?= escape($selectedPost['gateway']); ?></td></tr>
            <tr><th>VLAN</th><td><?= escape($selectedPost['vlan']); ?></td></tr>
            <tr><th>Port</th><td><?= escape($selectedPost['port']); ?></td></tr>
          </tbody>
        </table>
        <details>
          <summary>Voir le dump PHP</summary>
          <pre><?php print_r($selectedPost); ?></pre>
        </details>
      </div>

      <div class="card">
        <h2>Pentests associes</h2>
        <?php
          render_table(
              $pentests,
              [
                  ['label' => 'ID', 'field' => 'id'],
                  ['label' => 'Type', 'field' => 'type'],
                  ['label' => 'Date', 'field' => 'test_date'],
                  ['label' => 'Resultat', 'field' => 'result'],
                  ['label' => 'Score', 'field' => 'score'],
                  ['label' => 'Niveau', 'field' => 'level'],
              ],
              'Aucun pentest pour ce poste.'
          );
        ?>
        <?php if (!empty($pentests)): ?>
          <details>
            <summary>Voir les dumps PHP</summary>
            <pre><?php print_r($pentests); ?></pre>
          </details>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="card">
        <p class="muted">Cliquez sur un hostname dans la liste pour afficher le detail et ses pentests.</p>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</body>
</html>
