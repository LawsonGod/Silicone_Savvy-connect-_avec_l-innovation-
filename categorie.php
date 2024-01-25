<?php
// Inclusion du fichier de connexion à la base de données
global $dbh;
require 'connect.php';
require_once ('./inc/outils.php');

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