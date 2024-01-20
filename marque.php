<?php
global $dbh;
require 'connect.php';
$marque_id = isset($_GET['marque_id']) ? $_GET['marque_id'] : 0;
$marque_nom = '';
try {
    $stmtMarque = $dbh->prepare("SELECT nom FROM marques WHERE id = :marque_id");
    $stmtMarque->bindParam(':marque_id', $marque_id, PDO::PARAM_INT);
    $stmtMarque->execute();
    if ($stmtMarque->rowCount() > 0) {
        $marque_nom = $stmtMarque->fetch(PDO::FETCH_ASSOC)['nom'];
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération du nom de la marque : " . $e->getMessage();
}
try {
    $stmt = $dbh->prepare("
        SELECT p.*, 
               pr.pourcentage_remise,
               CASE 
                   WHEN pr.pourcentage_remise IS NOT NULL THEN p.prix - (p.prix * pr.pourcentage_remise / 100)
                   ELSE p.prix
               END AS prix_apres_remise
        FROM produits p
        LEFT JOIN promotions pr ON p.id = pr.produit_id AND CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
        WHERE p.marque_id = :marque_id
    ");
    $stmt->bindParam(':marque_id', $marque_id, PDO::PARAM_INT);
    $stmt->execute();
    $products = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $products .= '<div class="col-md-4 mb-4">';
        $products .= '<div class="card">';
        $products .= '<img class="card-img-top" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
        $products .= '<div class="card-body">';
        $products .= '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';
        $products .= '<a href="produit.php?id=' . $row['id'] . '">Voir la fiche du produit</a>';

        if (isset($row['pourcentage_remise']) && $row['pourcentage_remise'] > 0) {
            $nouveauPrix = $row['prix'] - ($row['prix'] * $row['pourcentage_remise'] / 100);
            $nouveauPrix = number_format($nouveauPrix, 2); // Round to 2 decimal places

            $products .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($row['prix']) . ' €</del></p>';
            $products .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($row['pourcentage_remise']) . '%</p>';
            $products .= '<p class="card-text">Nouveau Prix: ' . $nouveauPrix . ' €</p>';
        } else {
            $products .= '<p class="card-text">Prix: ' . htmlspecialchars($row['prix']) . ' €</p>';
        }
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
    <h2><?php echo htmlspecialchars($marque_nom); ?></h2>
    <div class="row">
        <?php echo $products; ?>
    </div>
</div>
<?php include('footer.php');?>
</body>
</html>
