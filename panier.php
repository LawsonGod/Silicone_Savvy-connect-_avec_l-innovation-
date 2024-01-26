<?php
global $dbh;
session_start();
include('connect.php');  // Assure une connexion à la base de données
require_once ('./inc/outils.php');

// Supprimer un produit du panier si nécessaire
supprimerProduitDuPanier($dbh);

// Afficher la page du panier
afficherPagePanier();
?>
