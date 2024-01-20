<?php
global $dbh;
require 'connect.php';
try {
    $stmt = $dbh->prepare("
        SELECT p.*, 
               pr.pourcentage_remise,
               p.prix - (p.prix * pr.pourcentage_remise / 100) AS prix_apres_remise
        FROM produits p
        JOIN promotions pr ON p.id = pr.produit_id
        WHERE CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
    ");
    $stmt->execute();
    $products = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products .= '<div class="col-md-4 mb-4">';
        $products .= '<div class="card">';
        $products .= '<img class="card-img-top" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
        $products .= '<div class="card-body">';
        $products .= '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
        $products .= '<a href="produit.php?id=' . $row['id'] . '">Voir la fiche du produit</a>';
        $nouveauPrix = number_format($row['prix_apres_remise'], 2);
        $products .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($row['prix']) . ' €</del></p>';
        $products .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($row['pourcentage_remise']) . '%</p>';
        $products .= '<p class="card-text">Nouveau Prix: ' . $nouveauPrix . ' €</p>';
        $products .= '<p class="card-text" style="text-align: justify;">' . htmlspecialchars($row['description']) . '</p>';
        $products .= '</div>';
        $products .= '</div>';
        $products .= '</div>';
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include('head.php');?>
<body>
<?php include('header_nav.php');?>
<div class="container mt-4">
    <h2>Promotions</h2>
    <div class="row">
        <?php echo $products; ?>
    </div>
</div>
<?php include('footer.php');?>
</body>
</html>
