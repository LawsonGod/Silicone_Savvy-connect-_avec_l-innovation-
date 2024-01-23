<?php
// Démarrage de la session
session_start();

// Inclusion du fichier de connexion à la base de données
global $dbh;
include('connect.php');
include('inc/outils.php');

// Récupération de l'identifiant du client à partir de la session
$client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;

// Initialisation des tableaux pour stocker les informations du client, les commandes et les évaluations
$clientInfo = [];
$commandes = [];
$evaluations = [];

// Vérification si l'utilisateur est connecté en tant que client
if ($client_id) {
    // Récupération des informations du client
    $stmtClient = $dbh->prepare("SELECT * FROM clients WHERE id = :client_id");
    $stmtClient->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtClient->execute();
    $clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

    // Récupération des commandes du client
    $stmtCommandes = $dbh->prepare("SELECT c.*, e.methode, e.cout, e.date_livraison_estimee FROM commandes c LEFT JOIN expeditions e ON c.id = e.commande_id WHERE c.client_id = :client_id");
    $stmtCommandes->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtCommandes->execute();
    $commandes = $stmtCommandes->fetchAll(PDO::FETCH_ASSOC);

    // Vérification s'il y a des commandes
    // if ($stmtCommandes->rowCount() > 0) {
    //     echo "Commandes trouvées : ". $stmtCommandes->rowCount();
    // } else {
    //     echo "Aucune commande trouvée pour l'ID du client : $client_id";
    // }

    // Récupération des évaluations faites par le client
    $stmtEvaluations = $dbh->prepare("SELECT e.*, p.nom AS produit_nom FROM evaluations e JOIN produits p ON e.produit_id = p.id WHERE e.utilisateur_id = :client_id");
    $stmtEvaluations->bindParam(':client_id', $client_id, PDO::PARAM_INT);
    $stmtEvaluations->execute();
    $evaluations = $stmtEvaluations->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "L'utilisateur n'est pas connecté.";
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    // header('Location: login.php');
    // exit();
}
?>

<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Informations du compte</h2>
    <!-- Affichage des informations du compte dans un tableau -->
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
            <td><?= isset($clientInfo['nom']) ? htmlspecialchars($clientInfo['nom']) : '' ?></td>
            <td><?= isset($clientInfo['alias']) ? htmlspecialchars($clientInfo['alias']) : '' ?></td>
            <td><?= isset($clientInfo['email']) ? htmlspecialchars($clientInfo['email']) : '' ?></td>
            <td><?= isset($clientInfo['adresse']) ? htmlspecialchars($clientInfo['adresse']) : '' ?></td>
            <td><?= isset($clientInfo['ville']) ? htmlspecialchars($clientInfo['ville']) : '' ?></td>
            <td><?= isset($clientInfo['code_postal']) ? htmlspecialchars($clientInfo['code_postal']) : '' ?></td>
            <td><?= isset($clientInfo['telephone']) ? htmlspecialchars($clientInfo['telephone']) : '' ?></td>
            <td><?= isset($clientInfo['date_enregistrement']) ? date('d/m/Y', strtotime($clientInfo['date_enregistrement'])) : '' ?></td>
        </tr>
        </tbody>
    </table>
    <!-- Boutons pour éditer les informations du compte -->
    <button class="btn btn-primary">Éditer les informations</button>

    <!-- Bouton pour supprimer le compte -->
    <a href="supprimer_client.php" class="btn btn-danger">Supprimer le compte</a>

    <h2>Mes Commandes</h2>
    <!-- Affichage des commandes dans un tableau -->
    <table class="table table-bordered">
        <tr>
            <th>Date</th>
            <th>Statut</th>
            <th>Montant Total</th>
            <th>Méthode de livraison</th>
            <th>Coût de livraison (€)</th>
            <th>Date de livraison ou date de livraison estimée</th>
        </tr>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?= isset($commande['date']) ? date('d/m/Y', strtotime($commande['date'])) : '' ?></td>
                <td><?= isset($commande['statut']) ? htmlspecialchars($commande['statut']) : '' ?></td>
                <td><?= isset($commande['montant_total']) ? htmlspecialchars($commande['montant_total']) . ' €' : '' ?></td>
                <?php if (isset($commande['statut']) && $commande['statut'] != 'annulé'): ?>
                    <td><?= isset($commande['methode']) ? htmlspecialchars($commande['methode']) : '' ?></td>
                    <td><?= isset($commande['cout']) ? htmlspecialchars($commande['cout']) . ' €' : '' ?></td>
                    <td><?= isset($commande['date_livraison_estimee']) ? date('d/m/Y', strtotime($commande['date_livraison_estimee'])) : '' ?></td>
                <?php else: ?>
                    <td></td>
                    <td></td>
                    <td></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Mes Avis</h2>
    <!-- Affichage des évaluations dans un tableau -->
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
                <td class="align-middle"><?= date('d/m/Y', strtotime($evaluation['date_publication'])) ?></td>
                <td class="align-middle">
                    <!-- Boutons pour éditer ou supprimer les évaluations -->
                    <div class="d-flex flex-column">
                        <a href="editer_commentaire.php?id=<?= $evaluation['id'] ?>" class="btn btn-primary mb-1">Éditer</a>
                        <a href="supprimer_commentaire.php?id=<?= $evaluation['id'] ?>" class="btn btn-danger">Supprimer</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include('footer.php'); ?>