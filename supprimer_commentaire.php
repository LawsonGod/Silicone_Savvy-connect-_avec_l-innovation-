<?php
session_start();
include('connect.php');

$commentaireId = isset($_GET['id']) ? $_GET['id'] : null;
$commentaire = null;

if ($commentaireId) {
    // Récupérer les informations du commentaire
    $stmtCommentaire = $dbh->prepare("SELECT * FROM evaluations WHERE id = :id");
    $stmtCommentaire->bindParam(':id', $commentaireId, PDO::PARAM_INT);
    $stmtCommentaire->execute();
    $commentaire = $stmtCommentaire->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $commentaireId = $_POST['id'];

    // Exécuter la requête de suppression
    $stmt = $dbh->prepare("DELETE FROM evaluations WHERE id = :id");
    $stmt->bindParam(':id', $commentaireId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirection après la suppression
    header('Location: compte_client.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Inclusion des styles Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($commentaire): ?>
                    <div class="text-center mt-5">
                        <h2>Confirmer la suppression</h2>
                        <p>Êtes-vous sûr de vouloir supprimer le commentaire suivant ?</p>
                        <blockquote class="blockquote">
                            <p class="mb-0"><?= htmlspecialchars($commentaire['commentaire']?? '') ?></p>
                            <footer class="blockquote-footer"><?= htmlspecialchars($commentaire['nom']?? '') ?></footer>
                        </blockquote>
                        <form action="supprimer_commentaire.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($commentaire['id']?? '') ?>">
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

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>