<?php
global $dbh;
include('connect.php');
require_once ('./inc/outils.php');
$stmt = $dbh->query("SELECT nom, alias, email, adresse, ville, code_postal, telephone, date_enregistrement FROM clients");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Liste des Clients</h2>
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
            <th>Date d'Enregistrement</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['nom']); ?></td>
                <td><?php echo htmlspecialchars($client['alias']); ?></td>
                <td><?php echo htmlspecialchars($client['email']); ?></td>
                <td><?php echo htmlspecialchars($client['adresse']); ?></td>
                <td><?php echo htmlspecialchars($client['ville']); ?></td>
                <td><?php echo htmlspecialchars($client['code_postal']); ?></td>
                <td><?php echo htmlspecialchars($client['telephone']); ?></td>
                <td><?php echo htmlspecialchars($client['date_enregistrement']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include('footer.php'); ?>