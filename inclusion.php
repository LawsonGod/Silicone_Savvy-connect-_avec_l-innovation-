<?php
global $dbh;
session_start();
include('connect.php');

// Synchroniser le panier en session avec la base de données pour les utilisateurs connectés
if (isset($_SESSION['utilisateur_id']) && !empty($_SESSION['panier'])) {
    $utilisateur_id = $_SESSION['utilisateur_id'];

    // Vérifier si un panier existe déjà pour l'utilisateur
    $requete_panier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
    $requete_panier->execute([':utilisateur_id' => $utilisateur_id]);
    $panier = $requete_panier->fetch(PDO::FETCH_ASSOC);

    if (!$panier) {
        // Créer un nouveau panier et récupérer son ID
        $insert_panier = $dbh->prepare('INSERT INTO paniers (utilisateur_id) VALUES (:utilisateur_id)');
        $insert_panier->execute([':utilisateur_id' => $utilisateur_id]);
        $panier_id = $dbh->lastInsertId();
    } else {
        // Utiliser le panier existant
        $panier_id = $panier['id'];
    }

    // Ajouter/mettre à jour les produits du panier en session dans la base de données
    foreach ($_SESSION['panier'] as $product_id => $produit) {
        $requete_produit = $dbh->prepare('SELECT quantite FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $requete_produit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
        $produit_panier = $requete_produit->fetch(PDO::FETCH_ASSOC);

        if ($produit_panier) {
            // Mise à jour de la quantité du produit existant dans le panier
            $nouvelle_quantite = $produit_panier['quantite'] + $produit['quantite'];
            $update_produit = $dbh->prepare('UPDATE paniers_produits SET quantite = :quantite WHERE panier_id = :panier_id AND produit_id = :produit_id');
            $update_produit->execute([':quantite' => $nouvelle_quantite, ':panier_id' => $panier_id, ':produit_id' => $product_id]);
        } else {
            // Ajout d'un nouveau produit dans le panier
            $insert_produit = $dbh->prepare('INSERT INTO paniers_produits (panier_id, produit_id, quantite) VALUES (:panier_id, :produit_id, :quantite)');
            $insert_produit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id, ':quantite' => $produit['quantite']]);
        }
    }
    $_SESSION['panier'] = array();
}
?>
