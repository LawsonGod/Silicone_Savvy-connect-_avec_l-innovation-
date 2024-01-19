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
    $message = "Erreur lors de la récupération du nom de la catégorie : " . $e->getMessage();
}

$message = '';

try {
    $stmt = $dbh->prepare("SELECT * FROM produits WHERE categorie_id = :cat_id");
    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $message .= '<div class="col-md-4 mb-4">';
        $message .= '<div class="card">';
        $message .= '<img class="card-img-top" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['nom']) . '">';
        $message .= '<div class="card-body">';
        $message .= '<h5 class="card-title">' . htmlspecialchars($row['nom']) . '</h5>';

        $product_id = $row['id'];
        $message .= '<a href="produit.php?id=' . $product_id . '">Voir la fiche du produit</a>';

        if (isset($row['remise']) && $row['remise'] > 0) {

            $ancienPrix = $row['prix'];
            $remise = $row['remise'];
            $nouveauPrix = $ancienPrix - ($ancienPrix * $remise / 100);

            $pourcentageRemise = $row['remise'];

            $message .= '<p class="card-text">Ancien Prix: <del>' . htmlspecialchars($ancienPrix) . ' €</del></p>';
            $message .= '<p class="card-text text-danger">Remise: ' . htmlspecialchars($pourcentageRemise) . '%</p>';
            $message .= '<p class="card-text">Nouveau Prix: ' . htmlspecialchars($nouveauPrix) . ' €</p>';
        } else {
            $message .= '<p class="card-text">Prix: ' . htmlspecialchars($row['prix']) . ' €</p>';
        }

        $stmtEvals = $dbh->prepare("SELECT AVG(note) AS note_moyenne FROM evaluations WHERE produit_id = :product_id");
        $stmtEvals->bindParam(':product_id', $row['id'], PDO::PARAM_INT);
        $stmtEvals->execute();

        if ($stmtEvals->rowCount() > 0) {
            $evalData = $stmtEvals->fetch(PDO::FETCH_ASSOC);

            $noteMoyenne = $evalData['note_moyenne'];

            $message .= '<p class="card-text">Note moyenne: ' . number_format($noteMoyenne, 1) . '</p>';
        } else {
            $message .= '<p class="card-text">Aucune évaluation disponible</p>';
        }

        $message .= '<p class="card-text" style="text-align: justify;">' . htmlspecialchars($row['description']) . '</p>';
        $message .= '</div>';
        $message .= '</div>';
        $message .= '</div>';
    }
} catch (PDOException $e) {
    $message = "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<?php include('head.php');?>
<body>
<?php include('header_nav.php');?>

<div class="container mt-4">
    <h2><?php echo htmlspecialchars($cat_nom); ?></h2>

    <div class="row">
        <?php
        echo $message;
        ?>
    </div>
</div>

<?php include('footer.php');?>
</body>
</html>