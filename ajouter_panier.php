<?php
global $dbh;
session_start();
include('connect.php');

if (isset($_POST['product_id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['product_id'];
    $quantite = intval($_POST['quantite']);

    if (isset($_SESSION['utilisateur_id'])) {
        // Gestion du panier pour les utilisateurs connectés
        $utilisateur_id = $_SESSION['utilisateur_id'];

        $requete_panier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
        $requete_panier->execute([':utilisateur_id' => $utilisateur_id]);
        $panier = $requete_panier->fetch(PDO::FETCH_ASSOC);

        if (!$panier) {
            $insert_panier = $dbh->prepare('INSERT INTO paniers (utilisateur_id) VALUES (:utilisateur_id)');
            $insert_panier->execute([':utilisateur_id' => $utilisateur_id]);
            $panier_id = $dbh->lastInsertId();
        } else {
            $panier_id = $panier['id'];
        }

        $requete_produit = $dbh->prepare('SELECT quantite FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $requete_produit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
        $produit_panier = $requete_produit->fetch(PDO::FETCH_ASSOC);

        if ($produit_panier) {
            $nouvelle_quantite = $produit_panier['quantite'] + $quantite;
            $update_produit = $dbh->prepare('UPDATE paniers_produits SET quantite = :quantite WHERE panier_id = :panier_id AND produit_id = :produit_id');
            $update_produit->execute([':quantite' => $nouvelle_quantite, ':panier_id' => $panier_id, ':produit_id' => $product_id]);
        } else {
            $insert_produit = $dbh->prepare('INSERT INTO paniers_produits (panier_id, produit_id, quantite) VALUES (:panier_id, :produit_id, :quantite)');
            $insert_produit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id, ':quantite' => $quantite]);
        }
    } else {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        $stmt = $dbh->prepare("SELECT nom, prix FROM produits WHERE id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produit) {
            if (isset($_SESSION['panier'][$product_id])) {
                $_SESSION['panier'][$product_id]['quantite'] += $quantite;
            } else {
                $_SESSION['panier'][$product_id] = array(
                    'nom' => $produit['nom'],
                    'prix' => $produit['prix'],
                    'quantite' => $quantite
                );
            }
        }
    }
    header('Location: panier.php');
    exit;
} else {
    echo "Données du produit manquantes.";
}
?>
