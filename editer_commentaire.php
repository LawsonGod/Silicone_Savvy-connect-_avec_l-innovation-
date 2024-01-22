<?php

session_start();
include ('connect.php'); 

$commentaireId = isset($_GET['id']) ? $_GET['id'] : null;
$commentaire = null;

try{
    if ($commentaireId) {
        $stmtCommentaire = $dbh->prepare("SELECT e.*, p.nom AS produit_nom, p.image AS produit_image FROM evaluations e JOIN produits p ON e.produit_id = p.id WHERE e.id = :id");
        $stmtCommentaire->bindParam(':id', $commentaireId, PDO::PARAM_INT);
        $stmtCommentaire->execute();
        $commentaire = $stmtCommentaire->fetch(PDO::FETCH_ASSOC);
    }
}catch (PDOException $e){
    echo "Erreur de base de données : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $commentaireId = $_POST['id'];
    $nouveauCommentaire = $_POST['commentaire'];
    $nouvelleNote = $_POST['note'];

    // Exécuter la requête de mise à jour du commentaire
    $stmt = $dbh->prepare("UPDATE evaluations SET commentaire = :commentaire, note = :note WHERE id = :id");
    $stmt->bindParam(':commentaire', $nouveauCommentaire, PDO::PARAM_STR);
    $stmt->bindParam(':note', $nouvelleNote, PDO::PARAM_INT);
    $stmt->bindParam(':id', $commentaireId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirection après la modification
    header('Location: compte_client.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer le commentaire</title>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
   
   <style>
        body {
            background-color: #f4f4f4; 
        }
        .edit-form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .edit-form-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .edit-form-container .form-control, .edit-form-container .btn-custom {
            border-radius: 5px;
        }
        .edit-form-container .btn-custom {
            background-color: #0069D9; 
            border-color: #0062CC;
            color: #fff;
            padding: 10px 25px;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        .product-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-info img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .edit-form-container .btn-secondary, .edit-form-container .btn-success {
            padding: 10px 20px;
            font-size: 18px;
            margin: 5px; 
        }

        .edit-form-container .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .return-link {
            display: block;
            width: fit-content;
            padding: 10px;
            color: #007bff;
            text-decoration: none;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <a href="compte_client.php" class="return-link">← Retour</a>
    <div class="edit-form-container">
        <h2>Modifier votre avis</h2>
        <?php if ($commentaire): ?>
            <div class="product-info">
                <img src="<?= htmlspecialchars($commentaire['produit_image']) ?>" alt="<?= htmlspecialchars($commentaire['produit_nom']) ?>">
                <h3><?= htmlspecialchars($commentaire['produit_nom']) ?></h3>
            </div>
            <form action="editer_commentaire.php" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($commentaire['id']) ?>">
                <div class="form-group">
                    <label for="commentaire">Votre commentaire:</label>
                    <textarea name="commentaire" class="form-control" id="commentaire" required><?= htmlspecialchars($commentaire['commentaire']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="note">Votre note:</label>
                    <input type="number" name="note" class="form-control" id="note" value="<?= htmlspecialchars($commentaire['note']) ?>" required min="0" max="5">
                </div>
                <div class="btn-group d-flex" role="group">
                    <button type="submit" class="btn btn-custom">Modifier le commentaire</button>
                </div>
            </form>
        <?php else: ?>
            <p class="text-center mt-5">Commentaire non trouvé ou non spécifié.</p>
        <?php endif; ?>
    </div>
</body>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/

   