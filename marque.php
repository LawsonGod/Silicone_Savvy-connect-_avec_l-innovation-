<?php
// Inclure la connexion à la base de données
global $dbh;
require 'connect.php';
require_once ('./inc/outils.php');

// Récupérer l'identifiant de la marque depuis l'URL
$marque_id = isset($_GET['marque_id']) ? $_GET['marque_id'] : 0;

// Récupérer le nom de la marque
$marque_nom = getMarqueNom($dbh, $marque_id);
?>

<?php include('head_header_nav.php'); ?>
<div class="container mt-4">
    <h2><?php echo htmlspecialchars($marque_nom); ?></h2>
    <div class="row">
        <?php afficherProduitsMarque($dbh, $marque_id); ?>
    </div>
</div>
<?php include('footer.php'); ?>