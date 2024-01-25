<?php
// Inclusion du fichier de connexion à la base de données
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

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