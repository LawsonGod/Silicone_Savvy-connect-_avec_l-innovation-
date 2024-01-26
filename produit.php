<?php
// Inclusion de la session, de la connexion à la base de données et d'autres fichiers nécessaires
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

// Récupération de l'ID du produit depuis l'URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
}

// Récupération des informations du produit
$produit = obtenirInformationsProduit($dbh, $product_id);

// Récupération de la note moyenne du produit
$noteMoyenne = obtenirNoteMoyenneProduit($dbh, $product_id);

// Récupération des évaluations du produit
$evaluations = obtenirEvaluationsProduit($dbh, $product_id);
?>
<?php include('head_header_nav.php');?>
<div class="container mt-4">
    <?php if ($produit): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="Image du produit" class="small-product-image">
            <div class="card-body">
                <h1 class="card-title"><?php echo htmlspecialchars($produit['nom']); ?></h1>
                <p class="card-text">Prix: <?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <p class="card-text">Catégorie: <?php echo htmlspecialchars($produit['nom_categorie']); ?></p>
                <p class="card-text">Marque: <?php echo htmlspecialchars($produit['nom_marque']); ?></p>
                <p class="card-text">Description: <?php echo htmlspecialchars($produit['description']); ?></p>
            </div>
        </div>
        <form action="ajouter_panier.php" method="post" class="form-inline">
            <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
            <div class="form-group mx-sm-3 mb-2">
                <label for="quantite" class="mr-2">Quantité :</label>
                <input type="number" class="form-control" name="quantite" id="quantite" value="1" min="1" max="10">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Ajouter au Panier</button>
        </form>
    <?php else: ?>
        <p>Produit introuvable.</p>
    <?php endif; ?>
    <?php if (isset($product_id)): ?>
        <div class="container mt-3">
            <h3>Note moyenne : <?php echo round($noteMoyenne, 1); ?> / 5</h3>
            <h4>Évaluations :</h4>
            <?php if ($evaluations): ?>
                <?php foreach ($evaluations as $evaluation): ?>
                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($evaluation['alias']); ?></h5>
                            <p class="card-text">Note : <?php echo htmlspecialchars($evaluation['note']); ?> / 5</p>
                            <p class="card-text">Date de l'évaluation: <?php echo date("d/m/Y", strtotime($evaluation['date_publication'])); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($evaluation['commentaire']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Pas d'évaluations pour ce produit.</p>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['client_id'])): ?>
            <div class="container mt-3">
                <h4>Ajouter un avis :</h4>
                <form action="ajouter_avis.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <div class="form-group">
                        <label for="note">Note (de 1 à 5) :</label>
                        <input type="number" class="form-control" name="note" id="note" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="commentaire">Commentaire :</label>
                        <textarea class="form-control" name="commentaire" id="commentaire" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter l'avis</button>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php include('footer.php');?>