<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Valeurs multiples/uniques</h2>
    <?php
        $array = [];
        for ($i = 0; $i <= 10; $i++) {
            $random = random_int(0, 5);
            array_push($array, $random);
        }
        $uniqueArray = array_unique($array);
    ?>
    <h3>Tableau avec doublons</h3>
    <pre class="array">
        <?php
            print_r($array);
        ?>
    </pre>
    <h3>Tableau sans doublons</h3>
    <pre>
        <?php
            print_r($uniqueArray);
        ?>
    </pre>
    <style>
        h3 {
            color: green;
        }
    </style>
</body>
</html>