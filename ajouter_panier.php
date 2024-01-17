<?php
global $dbh;
session_start();
include('connect.php');

if (isset($_POST['product_id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['product_id'];
    $quantite = $_POST['quantite'];

    echo "ID du produit : " . $product_id . "<br>";
    echo "Quantité : " . $quantite . "<br>";

    $requete = $dbh->prepare('SELECT nom, prix FROM produits WHERE id = :product_id');
    if (!$requete) {
        die("Erreur de préparation de requête : " . implode(":", $dbh->errorInfo()));
    }
    if (!$requete->execute([':product_id' => $product_id])) {
        die("Erreur d'exécution de requête : " . implode(":", $requete->errorInfo()));
    }
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    if ($resultat) {
        $nom_du_produit = $resultat['nom'];
        $prix_du_produit = $resultat['prix'];

        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        if (isset($_SESSION['panier'][$product_id])) {
            // Augmente la quantité
            $_SESSION['panier'][$product_id]['quantite'] += $quantite;
        } else {
            // Ajoute le nouveau produit au panier
            $_SESSION['panier'][$product_id] = array(
                'nom' => $nom_du_produit,
                'prix' => $prix_du_produit,
                'quantite' => $quantite
            );
        }

        header('Location: panier.php');
        exit();
    } else {
        echo "Produit non trouvé.";
    }
}
?>
