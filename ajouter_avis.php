<?php
// Inclusion du fichier de connexion à la base de données
global $dbh;
session_start();
include('connect.php');

// Fonction pour ajouter un avis sur un produit
function ajouterAvis($dbh, $product_id, $user_id, $note, $commentaire) {
    // Vérification si la note est valide (entre 1 et 5)
    if ($note >= 1 && $note <= 5) {
        $sql = "INSERT INTO evaluations (produit_id, utilisateur_id, note, commentaire) VALUES (:product_id, :user_id, :note, :commentaire)";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":note", $note, PDO::PARAM_INT);
        $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);

        // Exécution de la requête d'insertion de l'avis
        if ($stmt->execute()) {
            return true; // Succès : avis ajouté avec succès
        } else {
            return false; // Échec : erreur lors de l'ajout de l'avis
        }
    } else {
        return false; // Échec : la note n'est pas valide
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["client_id"])) {
        $product_id = $_POST["product_id"];
        $note = $_POST["note"];
        $commentaire = $_POST["commentaire"];
        $user_id = $_SESSION["client_id"];

        // Appel de la fonction pour ajouter un avis
        $avisAjoute = ajouterAvis($dbh, $product_id, $user_id, $note, $commentaire);

        if ($avisAjoute) {
            // Redirection vers la page du produit après avoir ajouté l'avis avec succès
            header("Location: produit.php?id=$product_id");
            exit;
        } else {
            echo "Une erreur s'est produite lors de l'ajout de l'avis.";
        }
    } else {
        echo "Vous devez être connecté pour ajouter un avis.";
    }
} else {
    echo "Accès non autorisé.";
}
?>