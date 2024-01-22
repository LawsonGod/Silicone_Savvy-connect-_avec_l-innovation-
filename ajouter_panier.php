<?php
// Inclusion du fichier de connexion à la base de données
global $dbh;
session_start();
include('connect.php');

// Fonction pour ajouter un produit au panier d'un utilisateur connecté
function ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite) {
    // Vérification si l'utilisateur a déjà un panier
    $requetePanier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
    $requetePanier->execute([':utilisateur_id' => $utilisateur_id]);
    $panier = $requetePanier->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur n'a pas de panier, on en crée un
    if (!$panier) {
        $insertPanier = $dbh->prepare('INSERT INTO paniers (utilisateur_id) VALUES (:utilisateur_id)');
        $insertPanier->execute([':utilisateur_id' => $utilisateur_id]);
        $panier_id = $dbh->lastInsertId();
    } else {
        $panier_id = $panier['id'];
    }

    // Vérification si le produit est déjà dans le panier de l'utilisateur
    $requeteProduit = $dbh->prepare('SELECT quantite FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
    $requeteProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
    $produitPanier = $requeteProduit->fetch(PDO::FETCH_ASSOC);

    // Si le produit est déjà dans le panier, on met à jour la quantité
    if ($produitPanier) {
        $nouvelleQuantite = $produitPanier['quantite'] + $quantite;
        $updateProduit = $dbh->prepare('UPDATE paniers_produits SET quantite = :quantite WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $updateProduit->execute([':quantite' => $nouvelleQuantite, ':panier_id' => $panier_id, ':produit_id' => $product_id]);
    } else {
        // Sinon, on ajoute le produit au panier de l'utilisateur
        $insertProduit = $dbh->prepare('INSERT INTO paniers_produits (panier_id, produit_id, quantite) VALUES (:panier_id, :produit_id, :quantite)');
        $insertProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id, ':quantite' => $quantite]);
    }
}

// Fonction pour ajouter un produit au panier d'un utilisateur non connecté
function ajouterProduitAuPanierSession($product_id, $quantite) {
    global $dbh;
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // Récupération des informations sur le produit depuis la base de données
    $stmt = $dbh->prepare("SELECT nom, prix FROM produits WHERE id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produit) {
        // Si le produit est déjà dans le panier de session, on met à jour la quantité
        if (isset($_SESSION['panier'][$product_id])) {
            $_SESSION['panier'][$product_id]['quantite'] += $quantite;
        } else {
            // Sinon, on ajoute le produit au panier de session
            $_SESSION['panier'][$product_id] = array(
                'nom' => $produit['nom'],
                'prix' => $produit['prix'],
                'quantite' => $quantite
            );
        }
    }
}

if (isset($_POST['product_id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['product_id'];
    $quantite = intval($_POST['quantite']);

    if (isset($_SESSION['utilisateur_id'])) {
        // Utilisateur connecté, on ajoute le produit à son panier
        $utilisateur_id = $_SESSION['utilisateur_id'];
        ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite);
    } else {
        // Utilisateur non connecté, on ajoute le produit au panier de session
        ajouterProduitAuPanierSession($product_id, $quantite);
    }

    // Redirection vers la page du panier
    header('Location: panier.php');
    exit;
} else {
    echo "Données du produit manquantes.";
}
?>