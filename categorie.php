<?php
global $dbh;
require 'connect.php';
$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;
$cat_nom = '';
try {
    $stmtCat = $dbh->prepare("SELECT nom FROM categories WHERE id = :cat_id");
    $stmtCat->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
    $stmtCat->execute();
    if ($stmtCat->rowCount() > 0) {
        $cat_nom = $stmtCat->fetch(PDO::FETCH_ASSOC)['nom'];
    }
} catch (PDOException $e) {
    echo "Erreur lors de la récupération du nom de la catégorie : " . $e->getMessage();
}
try {
    $stmt = $dbh->prepare("SELECT p.*, 
                                  pr.pourcentage_remise,
                                  CASE 
                                      WHEN pr.pourcentage_remise IS NOT NULL THEN p.prix - (p.prix * pr.pourcentage_remise / 100)
                                      ELSE p.prix
                                  END AS prix_apres_remise
                           FROM produits p
                           LEFT JOIN promotions pr ON p.id = pr.produit_id AND CURRENT_TIMESTAMP BETWEEN pr.date_debut AND pr.date_fin
                           WHERE p.categorie_id = :cat_id");
    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
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
            $nouveauPrix = number_format($row['prix_apres_remise'], 2);
            $products .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($row['prix']) . ' €</del></p>';
            $products .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($row['pourcentage_remise']) . '%</p>';
            $products .= '<p class="card-text">Nouveau Prix: ' . $nouveauPrix . ' €</p>';
        } else {
            $products .= '<p class="card-text">Prix: ' . htmlspecialchars($row['prix']) . ' €</p>';
        }
        $products .= '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';
        $products .= '</div>';
        $products .= '</div>';
        $products .= '</div>';
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
<?php include('head_header_nav.php');?>
<div class="container mt-4">
    <h2><?php echo htmlspecialchars($cat_nom); ?></h2>
    <div class="row">
        <?php echo $products; ?>
    </div>
</div>
<?php include('footer.php');?>
</body>
</html>
