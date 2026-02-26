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
        if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
            echo "<p>Login : " . $_POST['login'] . "</p>";
            echo "<p>Mot de passe : " . $_POST['password'] . "</p>";
            echo "<p>Adresse mail : " . $_POST['mail'] . "</p>";
        } else {
            echo "<p>Aucune paramètre reçu !</p>";
        }
    ?>
</body>
</html>