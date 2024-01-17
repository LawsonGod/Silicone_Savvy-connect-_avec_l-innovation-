<?php
session_start();

// Initialize the $message variable
$message = "";

if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    $message = "<h2>Merci, votre produit a été ajouté au panier avec succès !</h2>";
    $message .= "<a href='panier.php'>Voir le panier</a>";
} else {
    $message = "<h2>Votre panier est vide.</h2>";
    $message .= "<a href='index.php'>Retour à la page d'accueil</a>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silicone Savvy</title>
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
</head>
<?php include('header_nav.php');?>
<body class="bg-light">
<div class="container mt-5">
    <?php echo $message; ?>
</div>
</body>
<?php include('footer.php'); ?>
</html>

