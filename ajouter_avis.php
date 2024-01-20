<?php
global $dbh;
session_start();
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $note = $_POST["note"];
    $commentaire = $_POST["commentaire"];

    if (isset($_SESSION["client_id"])) {
        $product_id = $_POST["product_id"];
        $note = $_POST["note"];
        $commentaire = $_POST["commentaire"];
        $user_id = $_SESSION["client_id"];
        if ($note >= 1 && $note <= 5) {
            global $dbh;

            $sql = "INSERT INTO evaluations (produit_id, utilisateur_id, note, commentaire) VALUES (:product_id, :user_id, :note, :commentaire)";
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":note", $note, PDO::PARAM_INT);
            $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: produit.php?id=$product_id");
                exit;
            } else {
                echo "Une erreur s'est produite lors de l'ajout de l'avis.";
            }
        } else {
            echo "La note doit être entre 1 et 5.";
        }
    } else {
        echo "Vous devez être connecté pour ajouter un avis.";
    }
} else {
    echo "Accès non autorisé.";
}
?>
