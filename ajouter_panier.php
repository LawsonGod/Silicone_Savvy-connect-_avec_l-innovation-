<?php
global $dbh;
session_start();
include('connect.php');  // Assure une connexion à la base de données
require_once ('./inc/outils.php');

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