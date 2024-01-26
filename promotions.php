<?php
// Inclusion de la connexion à la base de données
global $dbh;
require 'connect.php';
require_once ('./inc/outils.php');
include('head_header_nav.php');
?>
<div class="container mt-4">
    <h2>Promotions</h2>
    <div class="row">
        <?php echo obtenirProduitsEnPromotion($dbh); ?>
    </div>
</div>
<?php
include('footer.php');
?>