<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ajout de produit</title>
</head>
<body>
    <nav class="menu">
        <ul>
            <li><a href="index.php">Ajouter un produit</a></li>
            <li><a href="recap.php">Récapitulatif des produits</a></li>
        </ul>
    </nav>
    <h1>Ajouter un produit</h1>
    <from action="traitement.php" method="post">
        <p>
            <label>
                Nom du produit :
                <input type="text" name="name">
            </label>
        </p>
        <p>
            <label>
                Prix du produit :
                <input type="number" step="any" name="price">
            </label>
        </p>
        <p>
            <label>
                Quantité désirée
                <input type="number" name="qtt" value="1">
            </label>
        </p>
        <p>
            <input type="submit" name="submit" value="Ajouter le produit">
        </p>
    </from>
</body>
</html>