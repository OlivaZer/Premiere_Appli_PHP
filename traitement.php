<?php
session_start();

// Vérifie s'il y a une action spécifiée dans l'URL pour gérer les actions de modification
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
                    // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
                    header("Location: recap.php");
                } else {
                    $_SESSION['message'] = 'Erreur : Indice de produit invalide.';
                    // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
                    header("Location: recap.php");
                }
            } else {
                $_SESSION['message'] = 'Erreur : Indice de produit manquant ou invalide.';
                // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
                header("Location: recap.php");
            }
            break;

        case 'effacerTous':
            // Effacer tous les produits de la session
            $_SESSION['products'] = array();
            $_SESSION['message'] = 'Tous les produits ont été supprimés avec succès.';
            // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
            header("Location: recap.php");
            break;

        case 'increment':
            // Incrémenter la quantité du produit
            if (isset($_GET['index']) && is_numeric($_GET['index'])) {
                $index = (int)$_GET['index'];
                if ($index >= 0 && $index < count($_SESSION['products'])) {
                    $_SESSION['products'][$index]['qtt']++;
                    $_SESSION['products'][$index]['total'] = $_SESSION['products'][$index]['price'] * $_SESSION['products'][$index]['qtt'];
                    $_SESSION['message'] = 'La quantité du produit a été augmentée avec succès.';
                    // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
                    header("Location: recap.php");
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
            // Redirection vers "recap.php" après le traitement de l'action ou l'ajout de produit
            header("Location: recap.php");
            break;

        case 'ajouter':
            // Vérifier si le formulaire d'ajout de produit a été soumis
            if (isset($_POST['submit'])) {
                // Récupérer les données du formulaire
                $name = $_POST['name'];
                $price = $_POST['price'];
                $qtt = $_POST['qtt'];

                // Valider les données (assurez-vous que les champs ne sont pas vides, et que le prix et la quantité sont des nombres valides et positifs)
                if (empty($name) || empty($price) || empty($qtt) || !is_numeric($price) || !is_numeric($qtt) || $price <= 0 || $qtt <= 0) {
                    $_SESSION['message'] = "Erreur : Veuillez remplir tous les champs correctement avec des valeurs positives.";
                    // Redirection vers "index.php" après l'ajout de produit
                    header("Location: index.php");
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

                    // Traitement de l'upload de l'image
                    if ($_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
                        $image_name = $_FILES['product_image']['name'];
                        $image_tmp_name = $_FILES['product_image']['tmp_name'];
                        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // Obtenez l'extension en minuscules
    
                        // Vérifiez si l'extension est autorisée (jpg ou png)
                        if ($image_extension === 'jpg' || $image_extension === 'png') {
                            $image_path = 'images/' . $image_name; // Utilisez le dossier "images"
                            move_uploaded_file($image_tmp_name, $image_path);
                            $product['image_path'] = $image_path; // Ajouter le chemin de l'image au tableau du produit
                        } else {
                            $_SESSION['message'] = "Erreur : Seuls les fichiers JPG et PNG sont autorisés.";
                            header("Location: index.php");
                            exit();
                        }
                    }

                    $_SESSION['products'][] = $product;
                    $_SESSION['message'] = '<p class="success-message">Le produit a été ajouté avec succès.</p>';
                    // Redirection vers "index.php" après l'ajout de produit
                    header("Location: index.php");
                }
            }
            break;

        default:
            // Si aucune action spécifiée ou action non reconnue, ne rien faire.
            break;
    }

    exit();
}