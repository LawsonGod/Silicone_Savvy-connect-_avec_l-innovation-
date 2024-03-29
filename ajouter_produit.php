<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "administrateur") {
    header('Location: index.php');
    exit;
}

$message = '';
$categories = [];
$marques = [];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ajouter_produit"])) {
    $nom = $_POST["nom"];
    $categorie_id = $_POST["categorie_id"];
    $marque_id = $_POST["marque_id"];
    $prix = $_POST["prix"];
    $quantite_stock = $_POST["quantite_stock"];
    $description = $_POST["description"];
    $image_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

    if (!validerNomProduit($nom)) {
        $message = "Le nom du produit contient des caractères interdits.";
    } elseif (!validerPrix($prix)) {
        $message = "Le champ 'Prix' doit contenir un nombre décimal (double).";
    } elseif (!is_numeric($quantite_stock)) { // Correction : Utiliser is_numeric pour valider la quantité en stock
        $message = "Le champ 'Quantité en Stock' doit contenir un nombre entier.";
    } else {
        $en_promotion = false;

        if (isset($_POST["en_promotion"])) {
            $en_promotion = true;
            $pourcentage_remise = $_POST["pourcentage_remise"];
            $date_debut = $_POST["date_debut"];
            $date_fin = $_POST["date_fin"];

            // Valider que la date de fin est supérieure à la date de début
            if (strtotime($date_fin) <= strtotime($date_debut)) {
                $message .= " La date de fin de la promotion doit être après la date de début.";
            }
        }

        if ($message === '') {
            $message = ajouterProduit($dbh, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_extension);

            if ($en_promotion) {
                $message .= " " . ajouterPromotion($dbh, $dbh->lastInsertId(), $pourcentage_remise, $date_debut, $date_fin);
            }
        }
    }
}
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h1>Ajouter un Produit</h1>
    <?php if ($message !== '') : ?>
        <?php afficherMessageErreur($message); ?>
    <?php endif; ?>
    <form action="ajouter_produit.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom">Nom du Produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="categorie_id">Catégorie</label>
            <select name="categorie_id" class="form-control" required>
                <?php foreach (recupererCategories($dbh) as $categorie) : ?>
                    <option value="<?php echo $categorie['id']; ?>"><?php echo htmlspecialchars($categorie['nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="marque_id">Marque</label>
            <select name="marque_id" class="form-control" required>
                <?php foreach (recupererMarques($dbh) as $marque) : ?>
                    <option value="<?php echo $marque['id']; ?>"><?php echo htmlspecialchars($marque['nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="text" name="prix" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantite_stock">Quantité en Stock</label>
            <input type="text" name="quantite_stock" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="en_promotion">En promotion ?</label>
            <input type="checkbox" name="en_promotion" id="en_promotion" onchange="afficherMasquerChampPromotion()">
        </div>
        <div class="form-group" id="champ_remise" style="display:none;">
            <label for="pourcentage_remise">Pourcentage de Remise</label>
            <input type="number" name="pourcentage_remise" class="form-control" min="5" max="60">
        </div>
        <div class="form-group" id="champ_promotion" style="display:none;">
            <label for="date_debut">Date de Début de la Promotion</label>
            <input type="date" id="date_debut" name="date_debut" class="form-control" pattern="\d{2}/\d{2}/\d{4}" value="<?php echo isset
            ($date_debut) ? htmlspecialchars($date_debut) : ''; ?>">
        </div>
        <div class="form-group" id="champ_fin_promotion" style="display:none;">
            <label for="date_fin">Date de Fin de la Promotion</label>
            <input type="date" id="date_fin" name="date_fin" class="form-control" pattern="\d{2}/\d{2}/\d{4}" value="<?php echo isset
            ($date_fin) ? htmlspecialchars($date_fin) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>
        <button type="submit" name="ajouter_produit" class="btn btn-primary">Ajouter</button>
        <button type="button" class="btn btn-secondary" onclick="annulerAjout()">Annuler</button>
    </form>
</div>
<script>
    // Fonction pour afficher ou masquer les champs de promotion en fonction de l'état de la case à cocher
    function afficherMasquerChampPromotion() {
        const casePromotion = document.getElementById('en_promotion');
        const champPromotion = document.getElementById('champ_promotion');
        const champFinPromotion = document.getElementById('champ_fin_promotion');
        const champRemise = document.getElementById('champ_remise');

        if (casePromotion.checked) {
            champPromotion.style.display = 'block';
            champFinPromotion.style.display = 'block';
            champRemise.style.display = 'block';
        } else {
            champPromotion.style.display = 'none';
            champFinPromotion.style.display = 'none';
            champRemise.style.display = 'none';
        }
    }

    // Appeler la fonction au chargement de la page pour gérer l'affichage initial
    window.onload = afficherMasquerChampPromotion;
</script>
<?php include('footer.php'); ?>