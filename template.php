<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <nav class="menu">
        <ul>
            <!-- Liens de navigation -->
            <li><a href="index.php">Ajouter un produit</a></li>
            <li><a href="recap.php">Récapitulatif des produits <?php echo '(' . $productCount . ')'; ?></a></li>
        </ul>
    </nav>

    <!-- Le contenu spécifique de chaque page sera inséré ici -->
    <?php
    if (isset($content)) {
        echo $content;
    }
    ?>

</body>
</html>