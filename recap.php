<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
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
        // Vérifie s'il y a des produits en session ou si la session est vide
        if(!isset($_SESSION['products']) || empty($_SESSION['products'])){
            echo "<p>Aucun produit en session ...</p>";
        }
        else{
            // Affiche un tableau avec le récapitulatif des produits
            echo "<table>",
                "<thead>",
                    "<tr>",
                        "<th>#</th>",
                        "<th>Nom</th>",
                        "<th>Prix</th>",
                        "<th>Quantité</th>",
                        "<th>Total</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";
                
            $totalGeneral = 0;
            foreach($_SESSION['products'] as $index => $product){
                // Affiche chaque produit dans une ligne du tableau
                echo "<tr>",
                        "<td>" .$index. "</td>",
                        "<td>" .$product['name']."</td>",
                        "<td>" .number_format($product['price'], 2 , ",", "&nbsp;")."&nbsp;€ </td>",
                        "<td>" .$product['qtt']."</td>",
                        "<td>" .number_format($product['total'], 2 , ",", "&nbsp;")."&nbsp;€ </td>",
                    "</tr>";
                // Calcule le prix total général de tous les produits
                $totalGeneral+= $product['total'];
            }
             // Affiche le prix total général à la fin du tableau
            echo "<tr>",
                    "<td colspan='4'> Total général : </td>",
                    "<td><strong>" .number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€ </strong></td>",
                "</tr>",
                "</tbody>",
                "</table>";

        }  
    ?> 
</body>
</html>
