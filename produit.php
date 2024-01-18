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

        $sql_evaluations = 'SELECT clients.alias, evaluations.note, evaluations.commentaire 
                            FROM evaluations 
                            INNER JOIN clients ON evaluations.utilisateur_id = clients.id 
                            WHERE evaluations.produit_id = :product_id';

        $stmt_evaluations = $dbh->prepare($sql_evaluations);
        $stmt_evaluations->execute([':product_id' => $product_id]);
        $evaluations = $stmt_evaluations->fetchAll(PDO::FETCH_ASSOC);

        $sql_note_moyenne = 'SELECT AVG(note) as note_moyenne 
                             FROM evaluations 
                             WHERE produit_id = :product_id';

        $stmt_note_moyenne = $dbh->prepare($sql_note_moyenne);
        $stmt_note_moyenne->execute([':product_id' => $product_id]);
        $note_moyenne = $stmt_note_moyenne->fetch(PDO::FETCH_ASSOC)['note_moyenne'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<?php include('head.php');?>
<body>
<?php include('header_nav.php');?>
<div class="container mt-4">
    <?php if ($produit): ?>
        <div class="card">
            <img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="Image du produit">
            <div class="card-body">
                <h1 class="card-title"><?php echo htmlspecialchars($produit['nom']); ?></h1>
                <p class="card-text">Prix: <?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <p class="card-text">Catégorie: <?php echo htmlspecialchars($produit['nom_categorie']); ?></p>
                <p class="card-text">Marque: <?php echo htmlspecialchars($produit['nom_marque']); ?></p>
                <p class="card-text">Description: <?php echo htmlspecialchars($produit['description']); ?></p>
            </div>
        </div>

        <form action="ajouter_panier.php" method="post" class="form-inline">
            <input type="hidden" name="product_id" value="<?php echo $product_id;?>"> <!-- Assurez-vous que $id_reel_du_produit a une valeur valide -->

            <div class="form-group mx-sm-3 mb-2">
                <label for="quantite" class="sr-only">Quantité</label>
                <input type="number" class="form-control" name="quantite" id="quantite" value="1" min="1" max="10">
            </div>

            <button type="submit" class="btn btn-primary mb-2">Ajouter au Panier</button>
        </form>

    <?php else: ?>
        <p>Produit introuvable.</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">Retour à la liste des produits</a>
    <div class="container mt-3">
        <h3>Évaluations des Clients</h3>
        <?php if ($note_moyenne): ?>
            <p class="lead">Note moyenne : <span class="badge bg-success"><?php echo round($note_moyenne, 1); ?>/5</span></p>
        <?php endif; ?>
        <div class="list-group">
            <?php foreach ($evaluations as $evaluation): ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo htmlspecialchars($evaluation['alias']); ?></h5>
                        <small>Note : <?php echo htmlspecialchars($evaluation['note']); ?>/5</small>
                    </div>
                    <p class="mb-1"><?php echo htmlspecialchars($evaluation['commentaire']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($evaluations)): ?>
            <p class="alert alert-warning">Pas d'évaluations pour ce produit.</p>
        <?php endif; ?>
    </div>

</div>

<?php //if(isset($product_id)): ?>
<!--    <div class="container mt-3">-->
<!--        <p>ID du produit reçu : --><?php //echo $product_id; ?><!--</p>-->
<!--    </div>-->
<?php //endif; ?>
</body>
<?php include('script_jquery.php'); ?>
<?php include('footer.php');?>
</html>
