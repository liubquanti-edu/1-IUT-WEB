<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Info systeme</h2>
    <ul>
        <li>Version de PHP : <?php echo PHP_VERSION; ?></li>
        <li>Système d'exploitation : <?php echo PHP_OS_FAMILY; ?></li>
        <li>Langue du navigateur : <?php echo $_SERVER["HTTP_ACCEPT_LANGUAGE"]; ?></li>
    </ul>
</body>
</html>