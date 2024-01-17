<?php
session_start();

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    echo "<h2>Merci, votre produit a été ajouté au panier avec succès !</h2>";
    echo "<a href='panier.php'>Voir le panier</a>";
} else {
    echo "<h2>Votre panier est vide.</h2>";
    echo "<a href='index.php'>Retour à la page d'accueil</a>";
}
?>