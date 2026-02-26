<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Données issues du formulaire</h2>
    <?php
        if (!empty($_GET['login']) && !empty($_GET['password']) && !empty($_GET['mail'])) {
            echo "<p>Login : " . $_GET['login'] . "</p>";
            echo "<p>Mot de passe : " . $_GET['password'] . "</p>";
            echo "<p>Adresse mail : " . $_GET['mail'] . "</p>";
        } else {
            echo "<p>Aucune paramètre reçu !</p>";
        }
    ?>
</body>
</html>