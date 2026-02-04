<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $max = 6;
    $cpt = 1;
    echo '<h2>Boucle while avec pas de 2</h2>';
    echo '<ul>';
    while ($cpt <= $max) {
        if ($cpt % 2 != 0) {
            echo '<li><h' . $cpt . '>Titre' . $cpt . '</h' . $cpt . '></li>';
        } else {
            echo '<li><strong>Valeur' . $cpt . '</strong></li>';
        }
        $cpt++;
    }
    echo '</ul>';
    ?>
</body>
</html>