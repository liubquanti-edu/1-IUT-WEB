<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Traitement de la demande</h2>
    <?php
        echo "<h3>Bonjour " . $_POST["prenom"] . " " . $_POST["nom"] . "</h3>";
        echo "Le message suivant a bien été enregistré :";
        echo "<p>";
        $lines = explode("\n", $_POST["message"]);
        foreach ($lines as $index => $line) {
            echo ($index + 1) . ". " . $line . "<br>";
        }
        echo "</p>";
    ?>

</body>
</html>