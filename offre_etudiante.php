<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <h1>Offre Étudiante</h1>
    <p>Voici notre offre spéciale pour les étudiants :</p>
    <ul>
        <li>Réduction supplémentaire de 5% sur tous nos produits pour les étudiants.</li>
        <li>Présentez simplement votre carte étudiante lors de l'achat pour bénéficier de la réduction.</li>
        <li>Cette offre est valable tout au long de l'année scolaire.</li>
    </ul>
</div>
<?php include('footer.php');?>