<?php
global $dbh;
session_start();
include('connect.php');

if (!isset($_SESSION['email'])) {
    header('Location: connexion_inscription.php');
    exit;
}

$query = $dbh->prepare("SELECT adresse, ville, code_postal FROM clients WHERE email = :email");
$query->execute(['email' => $_SESSION['email']]);
$userInfo = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<?php include('head.php'); ?>
<body>
<?php include('header_nav.php'); ?>
<div class="container mt-4">
    <h1 class="my-4">Informations de Livraison</h1>
    <p>Adresse: <strong><?php echo htmlspecialchars($userInfo['adresse']); ?></strong></p>
    <p>Ville: <strong><?php echo htmlspecialchars($userInfo['ville']); ?></strong></p>
    <p>Code Postal: <strong><?php echo htmlspecialchars($userInfo['code_postal']); ?></strong></p>

    <a href="paiement.php" class="btn btn-success">Passer au paiement</a>
    <a href="panier.php" class="btn btn-primary">Retour au Panier</a>
</div>
<?php include('script_jquery.php'); ?>
<?php include('footer.php'); ?>
</body>
</html>
