<?php
session_start();

// Initialisation de la variable de message
$message = '';

// Vérifie si le formulaire a été soumis (le bouton "submit" a été cliqué)
if (isset($_POST['submit'])) {
    // Récupère les données du formulaire et effectue une validation des entrées
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

    // Vérifie si toutes les données sont valides
    if ($name && $price !== false && $qtt !== false) {
        // Crée un tableau associatif pour stocker les informations du produit
        $product = [
            "name" => $name,
            "price" => $price,
            "qtt" => $qtt,
            "total" => $price * $qtt
        ];

        // Vérifie s'il n'y a pas déjà de produits dans la session
        if (!isset($_SESSION['products'])) {
            $_SESSION['products'] = array();
        }
        // Ajoute le produit au tableau de produits dans la session
        $_SESSION['products'][] = $product;

        // Message de succès
        $message = "Le produit a été ajouté avec succès.";
    } else {
        // Message d'erreur
        $message = "Erreur : Veuillez remplir tous les champs correctement.";
    }

    // Enregistre le message dans la session pour l'afficher dans la page index.php
    $_SESSION['message'] = $message;
}

// Redirige l'utilisateur vers la page "index.php" après le traitement du formulaire
header("Location: index.php");
exit();
?>