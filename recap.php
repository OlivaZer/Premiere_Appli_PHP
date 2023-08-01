<?php
// Démarrer la session PHP pour stocker les produits ajoutés par l'utilisateur dans la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> 
    <title>Récapitulatif des produits</title>
</head>
<body>
    <nav class="menu">
        <ul>
            <li><a href="index.php">Ajouter un produit</a></li> 
            <!-- Lien pour afficher le récapitulatif des produits en session, avec le nombre de produits -->
            <li><a href="recap.php">Récapitulatif des produits <?php echo '(' . (isset($_SESSION['products']) ? count($_SESSION['products']) : 0) . ')'; ?></a></li> 
        </ul>
    </nav>

    <?php
    if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        // Afficher un message si aucun produit n'a été ajouté dans la session
        echo "<p>Aucun produit en session ...</p>"; 
    } else {
        // Afficher le tableau avec les informations des produits
        echo "<form action=\"traitement.php\" method=\"get\">"; // Ajout du formulaire et de la méthode GET pour les actions de modification
        echo "<table>",
            "<thead>",
                "<tr>",
                    "<th>#</th>",
                    "<th>Nom</th>",
                    "<th>Prix</th>",
                    "<th>Quantité</th>",
                    "<th>Total</th>",
                    "<th>Actions</th>",
                "</tr>",
            "</thead>",
            "<tbody>";

        $totalGeneral = 0;
        foreach ($_SESSION['products'] as $index => $product) {
            // Afficher chaque produit dans une ligne du tableau
            echo "<tr>",
                    // Afficher le numéro de ligne (index du produit + 1)
                    "<td>" . ($index + 1) . "</td>", 
                    // Afficher le nom du produit
                    "<td>" . $product['name'] . "</td>", 
                    // Afficher le prix du produit avec deux décimales, une virgule comme séparateur et un espace entre le prix et le symbole €
                    "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€ </td>", 
                    "<td>",
                        // Lien pour décrémenter la quantité du produit
                        "<a href=\"traitement.php?action=decrement&index=$index&from=recap\">-</a>", 
                        // Afficher la quantité du produit
                        $product['qtt'], 
                        // Lien pour incrémenter la quantité du produit
                        "<a href=\"traitement.php?action=increment&index=$index&from=recap\">+</a>", 
                    "</td>",
                    // Afficher le total du produit avec deux décimales, une virgule comme séparateur et un espace entre le total et le symbole €
                    "<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€ </td>", 
                    // Lien pour supprimer le produit
                    "<td><a href=\"traitement.php?action=supprimer&index=$index&from=recap\">Supprimer</a></td>", 
                "</tr>";
            // Calculer le prix total général de tous les produits
            $totalGeneral += $product['total'];
        }
        
        // Afficher le prix total général à la fin du tableau
        echo "<tr>",
                "<td colspan='4'> Total général : </td>",
                "<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€ </strong></td>",
                // Utilisation d'un bouton de type "submit" pour l'action de suppression de tous les produits
                "<td><input type=\"submit\" name=\"action\" value=\"effacerTous\"></a></td>", 
            "</tr>",
            "</tbody>",
            "</table>";
        echo "</form>"; // Fermeture du formulaire

        // Lien de retour vers la page d'ajout de produits (index.php)
        echo "<p class=\"back-link\"><a href=\"index.php\">Retour pour ajouter des produits</a></p>";
    }
    ?>

</body>
</html>