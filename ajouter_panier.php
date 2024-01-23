<?php
global $dbh;
session_start();
include('connect.php');  // Assure une connexion à la base de données

// Fonction pour vérifier la quantité de stock disponible
function verifierQuantiteStock($dbh, $product_id, $quantiteDemandee) {
    $stmt = $dbh->prepare("SELECT quantite_stock FROM produits WHERE id = :product_id");
    $stmt->execute([':product_id' => $product_id]);
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    return $produit && $produit['quantite_stock'] >= $quantiteDemandee;
}

// Fonction pour ajouter ou mettre à jour un produit dans le panier d'un utilisateur connecté
function ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite) {
    if (!verifierQuantiteStock($dbh, $product_id, $quantite)) {
        $_SESSION['erreur'] = "La quantité demandée pour le produit dépasse le stock disponible.";
        return;
    }
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

    if (!verifierQuantiteStock($dbh, $product_id, $quantite)) {
        $_SESSION['erreur'] = "La quantité demandée pour le produit dépasse le stock disponible.";
        return;
    }

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // Si le produit est déjà dans le panier de session, on met à jour la quantité
    if (isset($_SESSION['panier'][$product_id])) {
        $_SESSION['panier'][$product_id]['quantite'] += $quantite;
    } else {
        // Sinon, on ajoute le produit au panier de session
        $_SESSION['panier'][$product_id] = $quantite;
    }
}

// Fonction pour transférer le panier de session vers le panier utilisateur après la connexion
function transfererPanierSessionVersUtilisateur($dbh, $utilisateur_id) {
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product_id => $quantite) {
            ajouterProduitAuPanierUtilisateur($dbh, $utilisateur_id, $product_id, $quantite);
        }
        unset($_SESSION['panier']);  // Vider le panier de session après le transfert
    }
}

function retirerProduitDuPanierUtilisateur($dbh, $utilisateur_id, $product_id) {
    $requetePanier = $dbh->prepare('SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id');
    $requetePanier->execute([':utilisateur_id' => $utilisateur_id]);
    $panier = $requetePanier->fetch(PDO::FETCH_ASSOC);

    if ($panier) {
        $panier_id = $panier['id'];
        $supprimerProduit = $dbh->prepare('DELETE FROM paniers_produits WHERE panier_id = :panier_id AND produit_id = :produit_id');
        $supprimerProduit->execute([':panier_id' => $panier_id, ':produit_id' => $product_id]);
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    if (isset($_SESSION['utilisateur_id'])) {
        retirerProduitDuPanierUtilisateur($dbh, $_SESSION['utilisateur_id'], $product_id);
    }
    unset($_SESSION['panier'][$product_id]);
}

if (isset($_POST['product_id']) && isset($_POST['quantite'])) {
    $product_id = $_POST['product_id'];
    $quantite = intval($_POST['quantite']);

    if (isset($_SESSION['utilisateur_id'])) {
        // L'utilisateur est connecté, mise à jour du panier dans la base de données
        ajouterProduitAuPanierUtilisateur($dbh, $_SESSION['utilisateur_id'], $product_id, $quantite);
    } else {
        // L'utilisateur n'est pas connecté, mise à jour du panier de session
        ajouterProduitAuPanierSession($product_id, $quantite);
    }

    header('Location: panier.php');
    exit;
} else {
    echo "Données du produit manquantes.";
}

if (isset($_SESSION['utilisateur_id'])) {
    transfererPanierSessionVersUtilisateur($dbh, $_SESSION['utilisateur_id']);
}
?>