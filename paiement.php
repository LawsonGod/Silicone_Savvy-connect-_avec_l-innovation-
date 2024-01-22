<?php
session_start();
include('connect.php');

if (!isset($_SESSION['email'])) {
    header('Location: connexion_inscription.php');
    exit;
}
$email = $_SESSION['email'];
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h2 class="my-4">Paiement par Carte Bleue</h2>

    <form action="#" method="post" id="payment-form">
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