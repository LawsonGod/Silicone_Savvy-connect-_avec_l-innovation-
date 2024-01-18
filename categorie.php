<?php
global $dbh;
require 'connect.php';

$cat_id =
    isset($_GET['cat_id']) ?
        $_GET['cat_id'] :
        0;

try {
    $stmt = $dbh->prepare("SELECT * FROM produits WHERE categorie_id = :cat_id");
    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="product">';
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
        echo '<h3>' . htmlspecialchars($row['nom']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['prix']) . ' €</p>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '</div>';
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
