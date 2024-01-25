<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de connexion à la base de données
global $dbh;
include('connect.php');
require_once ('./inc/outils.php');

// Récupération de l'identifiant du client à partir de la session
$client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;

if (isset($_POST['confirmDelete'])) {
    // Appeler les fonctions pour supprimer les données du client
    supprimerProduitsPanier($client_id, $dbh);
    supprimerPanier($client_id, $dbh);
    supprimerEvaluations($client_id, $dbh);
    supprimerExpeditions($client_id, $dbh);
    supprimerCommandes($client_id, $dbh);
    supprimerClient($client_id, $dbh);

    // Déconnexion de la session
    session_destroy();

     header('Location: index.php');
    // exit();
}
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h2>Confirmation de suppression de compte</h2>
    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.</p>
    <form method="post">
        <button type="submit" class="btn btn-danger" name="confirmDelete">Confirmer</button>
        <a href="compte_client.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php include('footer.php');?>