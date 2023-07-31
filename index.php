<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
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
            <!-- Lien pour afficher le récapitulatif des produits en session, avec le nombre de produits -->
            <li><a href="recap.php">Récapitulatif des produits <?php echo '(' . (isset($_SESSION['products']) ? count($_SESSION['products']) : 0) . ')'; ?></a></li>
        </ul>
    </nav>
    <h1>Ajouter un produit</h1>
    <?php
    // Vérifie s'il y a un message d'erreur dans la session et l'affiche en rouge
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo '<p class="error-message">' . $_SESSION['message'] . '</p>';
        // Efface le message de la session pour éviter de l'afficher plusieurs fois
        unset($_SESSION['message']);
    }
    ?>
    <form action="traitement.php" method="post">
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
    </form>
</body>
</html>