<?php
session_start();

// Définition de la variable $pageTitle et $productCount pour le template
$pageTitle = "Récapitulatif des produits";
$productCount = isset($_SESSION['products']) ? count($_SESSION['products']) : 0;

ob_start(); // Démarrer la temporisation
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
            <!-- Liens de navigation -->
            <li><a href="index.php">Ajouter un produit</a></li>
            <li><a href="recap.php">Récapitulatif des produits <?php echo '(' . $productCount . ')'; ?></a></li>
        </ul>
    </nav>

    <!-- Afficher le contenu spécifique de la page -->
    <?php
    if (isset($content)) {
        echo $content;
    }
    ?>

    <?php
    if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
        echo '<p class="notification-message">' . $_SESSION['message'] . '</p>';
        unset($_SESSION['message']);
    }

    if (!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        echo "<p>Aucun produit en session ...</p>";
    } else {
        echo "<form action=\"traitement.php?action=effacerTous\" method=\"get\">";
        echo "<table>",
    "<thead>",
        "<tr>",
            "<th>#</th>",
            "<th>Nom</th>",
            "<th>Prix</th>",
            "<th>Image</th>", // Nouvelle colonne pour l'image
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
        "<td>" . ($index + 1) . "</td>",
        "<td>" . $product['name'] . "</td>",
        "<td>" . number_format($product['price'], 2, ",", "&nbsp;") . "&nbsp;€ </td>",
        "<td>",
            // Affichage de l'image
            "<img src='" . $product['image_path'] . "' alt='" . $product['name'] . "' class='product-image'>",
        "</td>",
        "<td>",
            // Lien pour décrémenter la quantité du produit
            "<a class='decrement_style' href=\"traitement.php?action=decrement&index=$index\">-</a>",
            // Afficher la quantité du produit
            $product['qtt'],
            // Lien pour incrémenter la quantité du produit
            "<a class='increment_style'  href=\"traitement.php?action=increment&index=$index\">+</a>",
        "</td>",
        "<td>" . number_format($product['total'], 2, ",", "&nbsp;") . "&nbsp;€ </td>",
        // Lien pour supprimer le produit
        "<td><a href=\"traitement.php?action=supprimer&index=$index\">Supprimer</a></td>",
        "</tr>";
    $totalGeneral += $product['total'];
        }

        echo "<tr>",
            "<td colspan='4'> Total général : </td>",
            "<td><strong>" . number_format($totalGeneral, 2, ",", "&nbsp;") . "&nbsp;€ </strong></td>",
            "<td><input type=\"submit\" name=\"action\" value=\"effacerTous\"></td>",
            "</tr>",
            "</tbody>",
            "</table>";
        echo "</form>";
        echo "<p class=\"back-link\"><a href=\"index.php\">Retour pour ajouter des produits</a></p>";
    }
    ?>

</body>
</html>