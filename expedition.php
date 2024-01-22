<?php
global $dbh;
session_start();
include('connect.php');

if (!isset($_SESSION['email'])) {
    header('Location: connexion_inscription.php');
    exit;
}

$query = $dbh->prepare("SELECT nom, adresse, ville, code_postal FROM clients WHERE email = :email");
$query->execute(['email' => $_SESSION['email']]);
$userInfo = $query->fetch(PDO::FETCH_ASSOC);
?>
<?php include('head_header_nav.php'); ?>
<div class="container mt-4">
    <h1 class="my-4">Informations de Livraison</h1>
    <p><strong>Nom du Client:</strong> <?php echo htmlspecialchars($userInfo['nom']); ?></p>
    <p><strong>Adresse:</strong> <?php echo htmlspecialchars($userInfo['adresse']); ?></p>
    <p><strong>Ville:</strong> <?php echo htmlspecialchars($userInfo['ville']); ?></p>
    <p><strong>Code Postal:</strong> <?php echo htmlspecialchars($userInfo['code_postal']); ?></p>

    <a href="paiement.php" class="btn btn-success">Passer au paiement</a>
    <a href="panier.php" class="btn btn-primary">Retour au Panier</a>
</div>
<?php include('script_jquery.php'); ?>
<?php include('footer.php'); ?>