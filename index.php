<?php
session_start();

$pageTitle = "Ajout de produit";

ob_start(); // Démarrer la temporisation
?>

<h1>Ajouter un produit</h1>
<?php
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo '<p class="error-message">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}
?>
<form action="traitement.php?action=ajouter" method="post" enctype="multipart/form-data">
    <p>
        <label>
            Image du produit :
            <input type="file" name="product_image">
        </label>
    </p>
    <p>
        <label>
            Nom du produit :
            <input type="text" name="name" placeholder="Entrez le nom du produit">
        </label>
    </p>
    <p>
        <label>
            Prix du produit :
            <input type="number" step="any" name="price" min="0" placeholder="Entrez un prix">
        </label>
    </p>
    <p>
        <label>
            Quantité désirée :
            <input type="number" name="qtt" value="1" min="0" placeholder="Entrez la quantité de produit">
        </label>
    </p>
    <p>
        <input type="submit" name="submit" value="Ajouter le produit">
    </p>
</form>

<?php
$content = ob_get_clean(); // Capturer le contenu généré et nettoyer la mémoire tampon

$pageTitle = "Ajout de produit";
$productCount = isset($_SESSION['products']) ? count($_SESSION['products']) : 0;

// Inclure le template
require_once 'template.php';
?>