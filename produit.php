<?php
global $dbh;
session_start();
include('connect.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = 'SELECT produits.image, produits.nom, produits.prix, produits.description, 
                       marques.nom AS nom_marque, categories.nom AS nom_categorie 
                FROM produits 
                INNER JOIN marques ON produits.marque_id = marques.id 
                INNER JOIN categories ON produits.categorie_id = categories.id 
                WHERE produits.id = :product_id';

    $stmt = $dbh->prepare($sql);
    $stmt->execute([':product_id' => $product_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($product_id)) {
    $sqlNote = 'SELECT COALESCE(AVG(note), 0) AS note_moyenne FROM evaluations WHERE produit_id = :product_id';
    $stmtNote = $dbh->prepare($sqlNote);
    $stmtNote->execute([':product_id' => $product_id]);
    $noteMoyenne = $stmtNote->fetch(PDO::FETCH_ASSOC)['note_moyenne'];

    $sqlEvaluations = 'SELECT clients.alias, evaluations.note, evaluations.commentaire, evaluations.date_publication 
                           FROM evaluations 
                           INNER JOIN clients ON evaluations.utilisateur_id = clients.id 
                           WHERE evaluations.produit_id = :product_id';
    $stmtEvaluations = $dbh->prepare($sqlEvaluations);
    $stmtEvaluations->execute([':product_id' => $product_id]);
    $evaluations = $stmtEvaluations->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php include('header_nav.php');?>
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
</body>
</html>
