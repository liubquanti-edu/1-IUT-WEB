<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $sexe = "homme";
    for ($i = 0; $i < 3; $i++) {
        echo "<h2>Salutation</h2>";

        if ($i == 1) {
            $sexe = "femme";
        } elseif ($i == 2) {
            $sexe = "autre";
        }

        echo "<ul>";
        
        echo "<li> Valeur de la variable \$sexe : $sexe.</li>";

        if ($sexe == "homme") {
            echo "<li>Bonjour Monsieur.</li>";
        } elseif ($sexe == "femme") {
            echo "<li>Bonjour Madame.</li>";
        } else {
            echo "<li>Bonjour sexe inconnu.</li>";
        }

        echo "</ul>";
    }
    ?>
</body>
</html>