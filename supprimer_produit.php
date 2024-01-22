<?php
global $dbh;
session_start();
include('connect.php');

function supprimerEvaluationsProduit($dbh, $productId) {
    $sqlDeleteEvaluations = "DELETE FROM evaluations WHERE produit_id = :productId";
    $stmt = $dbh->prepare($sqlDeleteEvaluations);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}

function supprimerPromotionProduit($dbh, $productId) {
    $sqlDeletePromotion = "DELETE FROM promotions WHERE produit_id = :productId";
    $stmt = $dbh->prepare($sqlDeletePromotion);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}

function supprimerProduit($dbh, $productId) {
    $sqlDeleteProduct = "DELETE FROM produits WHERE id = :productId";
    $stmt = $dbh->prepare($sqlDeleteProduct);
    $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);
    $stmt->execute();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"])) {
    $productId = filter_var($_POST["productId"], FILTER_VALIDATE_INT);

    if ($productId === false) {
        echo "Identifiant de produit invalide";
        exit;
    }

    try {
        $dbh->beginTransaction();

        supprimerEvaluationsProduit($dbh, $productId);
        supprimerPromotionProduit($dbh, $productId);
        supprimerProduit($dbh, $productId);

        $dbh->commit();
        echo "Suppression réussie";
    } catch (PDOException $e) {
        $dbh->rollBack();
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    echo "Requête invalide";
}
?>