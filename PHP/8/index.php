<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Triangle isocèle</h2>
    <div style="text-align: center; width: fit-content;">
    <?php
        $hauteur = 13;
        for ($i = 1; $i <= $hauteur; $i+=2) {
            echo str_repeat(' ', $hauteur - $i);
            echo str_repeat('* ', $i);
            echo "<br>";
        }
    ?>
    </div>
</body>
</html>