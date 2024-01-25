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
    $nomMarque = $_POST['nomMarque'] ?? '';

    if (!empty($nomMarque)) {
        // Insertion dans la base de données
        $stmt = $dbh->prepare("INSERT INTO marques (nom) VALUES (?)");
        if ($stmt->execute([$nomMarque])) {
            $message = "Marque ajoutée avec succès.";
        } else {
            $message = "Erreur lors de l'ajout de la marque.";
        }
    } else {
        $message = "Le nom de la marque est requis.";
    }
}
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Ajouter une Marque</h2>
    <p><?php echo $message; ?></p>
    <form method="post">
        <div class="form-group">
            <label for="nomMarque">Nom de la Marque:</label>
            <input type="text" class="form-control" id="nomMarque" name="nomMarque" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<?php include('footer.php'); ?>