<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Tableau d'entiers pairs</h2>
    <?php
    $array = [];
    for ($i = 0; $i <= 10; $i++) {
        $random = random_int(0, 20);
        if ($random % 2 == 0 && $random != 0) {
            array_push($array, $random);
        } else {
            $i--;
        }
    }
    ?>
    <table>
        <tr>
            <?php
            foreach ($array as $value) {
                echo "<td>$value</td>";
            }
            ?>
        </tr>
    </table>
    <style>
        td {
            border: 1px solid black;
            padding: 5px;
            width: 30px;
            text-align: center;
        }
    </style>
</body>
</html>