<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Conversion HT/TTC</h2>
    <ul>
    <?php
    $prix_ht = 700.15;
    $taux_tva = 20;
    $prix_ttc = $prix_ht * (1 + $taux_tva / 100);
    ?>
        <li>Prix HT : <?php echo number_format($prix_ht, 2, '.', ' '); ?> €</li>
        <li>Taux TVA : <?php echo $taux_tva; ?> %</li>
        <li>Prix TTC : <?php echo number_format($prix_ttc, 2, '.', ' '); ?> €</li>
    </ul>
</body>
</html>