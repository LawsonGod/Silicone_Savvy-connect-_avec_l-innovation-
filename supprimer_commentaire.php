<?php
// Inclusion de la session, de la connexion à la base de données et d'autres fichiers nécessaires
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

// Vérification de l'existence de l'identifiant du commentaire dans l'URL
$commentaireId = isset($_GET['id']) ? $_GET['id'] : null;
$commentaire = null;

// Si un identifiant de commentaire est fourni, récupérer les informations du commentaire
if ($commentaireId) {
    $commentaire = obtenirCommentaireParId($dbh, $commentaireId);
}

// Vérification de la soumission du formulaire de suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $commentaireId = $_POST['id'];

    // Exécution de la requête de suppression du commentaire
    $stmt = $dbh->prepare("DELETE FROM evaluations WHERE id = :id");
    $stmt->bindParam(':id', $commentaireId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirection après la suppression
    header('Location: compte_client.php');
    exit();
}
?>
<?php include('head_header_nav.php');?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if ($commentaire): ?>
                <div class="text-center mt-5">
                    <h2>Confirmer la suppression</h2>
                    <p>Êtes-vous sûr de vouloir supprimer le commentaire suivant sur le produit "<?= htmlspecialchars(isset($commentaire['produit_nom']) ?
                            $commentaire['produit_nom'] :
                            'Inconnu') ?>" ?</p>
                    <blockquote class="blockquote">
                        <p class="mb-0"><?= htmlspecialchars(isset($commentaire['commentaire']) ?
                                $commentaire['commentaire'] :
                                '') ?></p>
                        <br>
                        <footer class="blockquote-footer">Produit : <?= htmlspecialchars(isset($commentaire['produit_nom']) ?
                                $commentaire['produit_nom'] :
                                'Inconnu') ?></footer>
                    </blockquote>
                    <form action="supprimer_commentaire.php" method="post">
                        <input type="hidden" name="id" value="<?= htmlspecialchars(isset($commentaire['id']) ?
                            $commentaire['id'] :
                            '') ?>">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                        <a href="index.php" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            <?php else: ?>
                <p class="text-center mt-5">Commentaire non trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include('footer.php');?>