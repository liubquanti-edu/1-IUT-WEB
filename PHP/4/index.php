<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Majeur ou mineur ?</h2>
    <?php
    $age = 17;

    echo "<ul>";

    echo "<li>Valeur de la variable \$age : $age.</li>";

    if ($age >= 18) {
        echo "<li>Vous êtes majeur.</li>";
    } else {
        echo "<li>Vous êtes mineur.</li>";
    }

    echo "</ul>";
    
    ?>
</body>
</html>