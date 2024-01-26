<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

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