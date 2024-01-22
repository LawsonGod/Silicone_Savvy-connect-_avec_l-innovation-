<?php
global $dbh;
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["productId"])) {
    $productId = filter_var($_POST["productId"], FILTER_VALIDATE_INT);

    if ($productId === false) {
        echo "Identifiant de produit invalide";
        exit;
    }

    $sqlDeleteEvaluations = "DELETE FROM evaluations WHERE produit_id = :productId";
    $sqlDeletePromotion = "DELETE FROM promotions WHERE produit_id = :productId";
    $sqlDeleteProduct = "DELETE FROM produits WHERE id = :productId";

    try {
        $dbh->beginTransaction();

        $stmt1 = $dbh->prepare($sqlDeleteEvaluations);
        $stmt1->bindParam(":productId", $productId, PDO::PARAM_INT);
        $stmt1->execute();

        $stmt2 = $dbh->prepare($sqlDeletePromotion);
        $stmt2->bindParam(":productId", $productId, PDO::PARAM_INT);
        $stmt2->execute();

        $stmt3 = $dbh->prepare($sqlDeleteProduct);
        $stmt3->bindParam(":productId", $productId, PDO::PARAM_INT);
        $stmt3->execute();

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
