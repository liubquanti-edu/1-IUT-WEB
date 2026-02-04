<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Table de multiplication de 7</h2>
    <?php
    $nombre = 7;
    echo '<ul>';
    for ($i = 0; $i <= 9; $i++) {
        $resultat = $nombre * $i;
        echo "<li>$nombre * $i = $resultat</li>";
    }
    echo '</ul>';
    ?>
</body>
</html>