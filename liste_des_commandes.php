<?php
global $dbh;
include('connect.php');
require_once ('./inc/outils.php');
$stmt = $dbh->query("SELECT c.nom, com.id, com.date, com.statut, com.montant_total FROM commandes com JOIN clients c ON com.client_id = c.id");
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Liste des Commandes</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nom du Client</th>
            <th>ID Commande</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Montant Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($commandes as $commande): ?>
            <tr>
                <td><?php echo htmlspecialchars($commande['nom']); ?></td>
                <td><?php echo htmlspecialchars($commande['id']); ?></td>
                <td><?php echo htmlspecialchars($commande['date']); ?></td>
                <td><?php echo htmlspecialchars($commande['statut']); ?></td>
                <td><?php echo htmlspecialchars($commande['montant_total']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include('footer.php'); ?>
