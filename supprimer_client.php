<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de connexion à la base de données
global $dbh;
include('connect.php');

// Fonction pour supprimer les produits dans le panier du client
function supprimerProduitsPanier($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE pp FROM paniers_produits pp
                           INNER JOIN paniers p ON pp.panier_id = p.id
                           WHERE p.utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour supprimer le panier du client
function supprimerPanier($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM paniers WHERE utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour supprimer les évaluations du client
function supprimerEvaluations($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM evaluations WHERE utilisateur_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour supprimer les expéditions liées aux commandes du client
function supprimerExpeditions($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE e FROM expeditions e
                           INNER JOIN commandes c ON e.commande_id = c.id
                           WHERE c.client_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour supprimer les commandes du client
function supprimerCommandes($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM commandes WHERE client_id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

// Fonction pour supprimer le client
function supprimerClient($clientId, $dbh) {
    $stmt = $dbh->prepare("DELETE FROM clients WHERE id = :client_id");
    $stmt->bindParam(':client_id', $clientId, PDO::PARAM_INT);
    $stmt->execute();
}

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