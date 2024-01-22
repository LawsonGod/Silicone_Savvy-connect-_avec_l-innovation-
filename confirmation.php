<?php
session_start();

$message = "";

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    $message = "<h2>Merci, votre produit a été ajouté au panier avec succès !</h2>";
    $message .= "<a href='panier.php'>Voir le panier</a>";
} else {
    $message = "<h2>Votre panier est vide.</h2>";
    $message .= "<a href='index.php'>Retour à la page d'accueil</a>";
}
?>
<?php include('header_nav.php');?>
<div class="container mt-5">
    <?php echo $message; ?>
</div>
</body>
<?php include('footer.php'); ?>
</html>

