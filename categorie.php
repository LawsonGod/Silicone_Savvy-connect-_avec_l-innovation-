<?php
// Inclusion du fichier de connexion à la base de données
global $dbh;
require 'connect.php';

// Fonction pour récupérer le nom de la catégorie
function getNomCategorie($dbh, $cat_id) {
    try {
        $stmtCat = $dbh->prepare("SELECT nom FROM categories WHERE id = :cat_id");
        $stmtCat->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmtCat->execute();

        if ($stmtCat->rowCount() > 0) {
            return $stmtCat->fetch(PDO::FETCH_ASSOC)['nom'];
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération du nom de la catégorie : " . $e->getMessage();
    }
    return '';
}

// Fonction pour récupérer la liste des produits d'une catégorie
function getProduitsByCategorie($dbh, $cat_id) {
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

        $products = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = $row;
        }

        return $products;
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
    return array();
}

$cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0;

$cat_nom = getNomCategorie($dbh, $cat_id);
$products = getProduitsByCategorie($dbh, $cat_id);
?>
<?php include('head_header_nav.php'); ?>
<div class="container mt-4">
    <h2><?php echo htmlspecialchars($cat_nom); ?></h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img class="card-img-top" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['nom']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['nom']) ?></h5>
                        <a href="produit.php?id=<?= $product['id'] ?>">Voir la fiche du produit</a>
                        <?php if (isset($product['pourcentage_remise']) && $product['pourcentage_remise'] > 0): ?>
                            <?php $nouveauPrix = number_format($product['prix_apres_remise'], 2); ?>
                            <p class="card-text">Ancien Prix: <del><?= htmlspecialchars($product['prix']) ?> €</del></p>
                            <p class="card-text text-danger">Remise: <?= htmlspecialchars($product['pourcentage_remise']) ?>%</p>
                            <p class="card-text text-danger">Nouveau Prix: <?= $nouveauPrix ?> €</p>
                        <?php else: ?>
                            <p class="card-text">Prix: <?= htmlspecialchars($product['prix']) ?> €</p>
                        <?php endif; ?>
                        <p class="card-text" style="text-align: justify"><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include('footer.php'); ?>