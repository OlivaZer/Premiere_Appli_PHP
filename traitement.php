<?php
session_start();

// Vérifie si le formulaire d'ajout de produit a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $price = $_POST['price'];
    $qtt = $_POST['qtt'];

    // Valider les données (assurez-vous que les champs ne sont pas vides, et que le prix et la quantité sont des nombres valides et positifs)
    if (empty($name) || empty($price) || empty($qtt) || !is_numeric($price) || !is_numeric($qtt) || $price <= 0 || $qtt <= 0) {
        $_SESSION['message'] = "Erreur : Veuillez remplir tous les champs correctement avec des valeurs positives.";
    } else {
        // Convertir le prix en nombre à virgule flottante
        $price = floatval($price);

        // Vérifier si la variable de session 'products' existe, sinon, la créer
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = array();
        }

        // Ajouter le produit à la session
        $total = $price * $qtt;
        $product = array(
            'name' => $name,
            'price' => $price,
            'qtt' => $qtt,
            'total' => $total,
        );

        $_SESSION['products'][] = $product;
        $_SESSION['message'] = "Le produit a été ajouté avec succès.";
    }
}

// Vérifier s'il y a une action spécifiée dans l'URL pour gérer les actions de modification
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'supprimer':
            // Supprimer le produit sélectionné de la session
            if (isset($_GET['index']) && is_numeric($_GET['index'])) {
                $index = (int)$_GET['index'];
                if ($index >= 0 && $index < count($_SESSION['products'])) {
                    unset($_SESSION['products'][$index]);
                    $_SESSION['products'] = array_values($_SESSION['products']);
                    $_SESSION['message'] = 'Le produit a été supprimé avec succès.';
                } else {
                    $_SESSION['message'] = 'Erreur : Indice de produit invalide.';
                }
            } else {
                $_SESSION['message'] = 'Erreur : Indice de produit manquant ou invalide.';
            }
            break;
        case 'effacerTous':
            // Effacer tous les produits de la session
            $_SESSION['products'] = array();
            $_SESSION['message'] = 'Tous les produits ont été supprimés avec succès.';
            break;
        case 'increment':
            // Incrémenter la quantité du produit
            if (isset($_GET['index']) && is_numeric($_GET['index'])) {
                $index = (int)$_GET['index'];
                if ($index >= 0 && $index < count($_SESSION['products'])) {
                    $_SESSION['products'][$index]['qtt']++;
                    $_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['price'] * $_SESSION['products'][$index]['qtt'];
                    $_SESSION['message'] = 'La quantité du produit a été augmentée avec succès.';
                }
            }
            break;
        case 'decrement':
            // Décrémenter la quantité du produit (assurez-vous que la quantité ne devienne pas négative)
            if (isset($_GET['index']) && is_numeric($_GET['index'])) {
                $index = (int)$_GET['index'];
                if ($index >= 0 && $index < count($_SESSION['products'])) {
                    if ($_SESSION['products'][$index]['qtt'] > 1) {
                        $_SESSION['products'][$index]['qtt']--;
                        $_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['price'] * $_SESSION['products'][$index]['qtt'];
                        $_SESSION['message'] = 'La quantité du produit a été diminuée avec succès.';
                    }
                }
            }
            break;
        default:
            // Aucune action valide spécifiée
            break;
    }
}

// Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
if (isset($_GET['action'])) {
    header("Location: recap.php");
} else {
    // Redirection vers "index.php" après l'ajout de produit
    header("Location: index.php");
}
exit();

?>