<?php
global $dbh;
include('connect.php');
require_once ('./inc/outils.php');

if (!estAdministrateur()) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomCategorie = $_POST['nomCategorie'] ?? '';

    if (!empty($nomCategorie)) {
        // Insertion dans la base de données
        $stmt = $dbh->prepare("INSERT INTO categories (nom) VALUES (?)");
        if ($stmt->execute([$nomCategorie])) {
            $message = "Catégorie ajoutée avec succès.";
            $messageType = "success";
        } else {
            $message = "Erreur lors de l'ajout de la catégorie.";
            $messageType = "danger";
        }
    } else {
        $message = "Le nom de la catégorie est requis.";
        $messageType = "danger";
    }
}
?>
<?php include('head_header_nav.php'); ?>
    <div class="container">
        <h2>Ajouter une Catégorie</h2>
        <p><?php echo $message; ?></p>
        <form method="post">
            <div class="form-group">
                <label for="nomCategorie">Nom de la Catégorie:</label>
                <input type="text" class="form-control" id="nomCategorie" name="nomCategorie" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
<?php include('footer.php'); ?>