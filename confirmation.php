<?php
session_start();
include('connect.php');
require_once ('./inc/outils.php');
$message = "";

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    $message = "<h2>Merci, votre produit a été ajouté au panier avec succès !</h2>";
    $message .= "<a href='panier.php'>Voir le panier</a>";
} else {
    $message = "<h2>Votre panier est vide.</h2>";
    $message .= "<a href='index.php'>Retour à la page d'accueil</a>";
}
?>
<?php include('head_header_nav.php');?>
<div class="container mt-5">
    <?php echo $message; ?>
</div>
<?php include('footer.php'); ?>