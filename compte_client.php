<?php
session_start(); // Start the session at the very beginning

global $dbh;
include('connect.php');

$client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;

$clientInfo = [];
$commandes = [];
$evaluations = [];

if ($client_id) {
    $stmtClient = $dbh->prepare("SELECT * FROM clients WHERE id = :client_id");
    $stmtClient->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtClient->execute();
    $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

    $stmtCommandes = $dbh->prepare("SELECT c.*, e.methode, e.cout, e.date_livraison_estimee FROM commandes c LEFT JOIN expeditions e ON c.id = e.commande_id WHERE c.client_id = :client_id");
    $stmtCommandes->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtCommandes->execute();
    $commandes = $stmtCommandes->fetchAll(PDO::FETCH_ASSOC);

    if ($stmtCommandes->rowCount() > 0) {
        echo "Commandes found: " . $stmtCommandes->rowCount();
    } else {
        echo "No commandes found for client_id: $client_id";
    }

    $stmtEvaluations = $dbh->prepare("SELECT e.*, p.nom AS produit_nom FROM evaluations e JOIN produits p ON e.produit_id = p.id WHERE e.utilisateur_id = :client_id");
    $stmtEvaluations->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtEvaluations->execute();
    $evaluations = $stmtEvaluations->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "User is not logged in.";
    // header('Location: login.php');
    // exit();
}
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Informations du compte</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Alias</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Ville</th>
            <th>Code Postal</th>
            <th>Téléphone</th>
            <th>Date d'inscription</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= htmlspecialchars(isset($clientInfo['nom']) ?
                    $clientInfo['nom'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['alias']) ?
                    $clientInfo['alias'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['email']) ?
                    $clientInfo['email'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['adresse']) ?
                    $clientInfo['adresse'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['ville']) ?
                    $clientInfo['ville'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['code_postal']) ?
                    $clientInfo['code_postal'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['telephone']) ?
                    $clientInfo['telephone'] :
                    '') ?></td>
            <td><?= htmlspecialchars(isset($clientInfo['date_enregistrement']) ?
                    $clientInfo['date_enregistrement'] :
                    '') ?></td>
        </tr>
        </tbody>
    </table>
    <button class="btn btn-primary">Éditer les informations</button>
    <button class="btn btn-danger">Supprimer le compte</button>
    <h2>Mes Commandes</h2>
    <table class="table table-bordered">
        <tr>
            <th>Date</th>
            <th>Statut</th>
            <th>Montant Total</th>
            <th>Méthode de livraison</th>
            <th>Coût de livraison</th>
            <th>Date de livraison ou date de livraison estimée</th>
        </tr>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?= htmlspecialchars($commande['date']) ?></td>
                <td><?= htmlspecialchars($commande['statut']) ?></td>
                <td><?= htmlspecialchars($commande['montant_total']) ?> €</td>
                <td><?= htmlspecialchars($commande['methode']) ?></td>
                <td><?= htmlspecialchars($commande['cout']) ?> €</td>
                <td><?= htmlspecialchars($commande['date_livraison_estimee']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <h2>Mes Avis</h2>
    <table class="table table-bordered">
        <tr>
            <th>Produit</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Date</th>
        </tr>
        <?php foreach ($evaluations as $evaluation): ?>
            <tr>
                <td class="align-middle"><?= htmlspecialchars($evaluation['produit_nom']) ?></td>
                <td class="align-middle"><?= htmlspecialchars($evaluation['note']) ?></td>
                <td class="align-middle"><?= htmlspecialchars($evaluation['commentaire']) ?></td>
                <td class="align-middle"><?= htmlspecialchars($evaluation['date_publication']) ?></td>
                <td class="align-middle">
                    <div class="d-flex flex-column">
                        <a href="#?id=<?= $evaluation['id'] ?>" class="btn btn-primary mb-1">Éditer</a>
                        <a href="supprimer_commentaire.php?id=<?= $evaluation['id'] ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include('footer.php'); ?>
</body>
</html>
