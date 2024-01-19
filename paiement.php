<?php
global $dbh;
session_start();
include('connect.php');
include('inclusion.php');

if (!isset($_SESSION['email'])) {
    header('Location: connexion_inscription.php');
    exit;
}

$queryUtilisateur = $dbh->prepare("SELECT id FROM clients WHERE email = :email");
$queryUtilisateur->execute(['email' => $_SESSION['email']]);
$utilisateurInfo = $queryUtilisateur->fetch(PDO::FETCH_ASSOC);

if ($utilisateurInfo) {
    $utilisateur_id = $utilisateurInfo['id'];

    $queryPanier = $dbh->prepare("SELECT id FROM paniers WHERE utilisateur_id = :utilisateur_id");
    $queryPanier->execute(['utilisateur_id' => $utilisateur_id]);
    $panierInfo = $queryPanier->fetch(PDO::FETCH_ASSOC);

    if ($panierInfo) {
        $panier_id = $panierInfo['id'];

        $queryProduits = $dbh->prepare("SELECT COUNT(*) FROM paniers_produits WHERE panier_id = :panier_id");
        $queryProduits->execute(['panier_id' => $panier_id]);
        $count = $queryProduits->fetchColumn();

        if ($count == 0) {
            $_SESSION['erreur'] = "Votre panier est vide.";
            header('Location: panier.php');
            exit;
        }
    } else {
        $_SESSION['erreur'] = "Vous n'avez pas de panier.";
        header('Location: panier.php');
        exit;
    }
} else {
    header('Location: connexion_inscription.php');
    exit;
}
?>
<!DOCTYPE html>
<?php include('head.php');?>
<body>
<?php include('header_nav.php');?>

<div class="container">
    <h2 class="my-4">Paiement par Carte Bleue</h2>

    <form action="traitement_paiement.php" method="post" id="payment-form">
        <div class="mb-3">
            <label for="card-holder-name" class="form-label">Nom sur la carte</label>
            <input type="text" class="form-control" id="card-holder-name" name="card_holder_name" required>
        </div>
        <div class="mb-3">
            <label for="card-number" class="form-label">Numéro de la carte</label>
            <input type="text" class="form-control" id="card-number" name="card_number" required>
        </div>
        <div class="mb-3">
            <label for="card-expiry" class="form-label">Date d'expiration</label>
            <input type="text" class="form-control" id="card-expiry" name="card_expiry" placeholder="MM/AA" required>
        </div>
        <div class="mb-3">
            <label for="card-cvc" class="form-label">CVC</label>
            <input type="text" class="form-control" id="card-cvc" name="card_cvc" required>
        </div>
        <button type="submit" class="btn btn-primary">Payer</button>
    </form>
</div>

<?php include('script_jquery.php'); ?>
<?php include('footer.php'); ?>
</body>
</html>
