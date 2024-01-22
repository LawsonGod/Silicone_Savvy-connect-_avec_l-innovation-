<?php
global $dbh;
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "administrateur") {
    header('Location: index.php');
    exit;
}

include('connect.php');

// Fonction pour afficher un message d'erreur
function afficherMessageErreur($message) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
}

$message = '';
$categories = [];
$marques = [];

// Fonction pour récupérer la liste des catégories depuis la base de données
function recupererCategories($dbh) {
    $stmt_cat = $dbh->query('SELECT id, nom FROM categories');
    return $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer la liste des marques depuis la base de données
function recupererMarques($dbh) {
    $stmt_marque = $dbh->query('SELECT id, nom FROM marques');
    return $stmt_marque->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour valider le nom du produit
function validerNomProduit($nom) {
    return !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $nom);
}

// Fonction pour gérer l'ajout du produit
function ajouterProduit($dbh, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_extension) {
    $image_path = './assets/' . $nom . '.' . $image_extension;
    $allowed_extensions = ["avif", "png", "jpeg", "jpg"];
    $max_file_size = 3000 * 1024;

    if (!in_array($image_extension, $allowed_extensions) || $_FILES["image"]["size"] > $max_file_size) {
        return "L'extension du fichier image n'est pas valide ou le fichier est trop volumineux.";
    }

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        return "Une erreur s'est produite lors de l'enregistrement de l'image.";
    }

    $sql = "INSERT INTO produits (nom, categorie_id, marque_id, prix, quantite_stock, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_path])) {
        return "Le produit a été ajouté avec succès.";
    } else {
        return "Erreur lors de l'ajout du produit.";
    }
}

// Fonction pour ajouter la promotion avec des dates de début et de fin
function ajouterPromotion($dbh, $produit_id, $pourcentage_remise, $date_debut_promo, $date_fin_promo) {
    $date_debut = new DateTime($date_debut_promo);
    $date_fin = new DateTime($date_fin_promo);

    // Vérifier que la date de fin est supérieure à la date de début
    if ($date_fin <= $date_debut) {
        return "La date de fin de la promotion doit être après la date de début.";
    }

    $sql = "INSERT INTO promotions (produit_id, pourcentage_remise, date_debut, date_fin) VALUES (?, ?, ?, ?)";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$produit_id, $pourcentage_remise, $date_debut_promo, $date_fin_promo])) {
        return "La promotion a été ajoutée avec succès.";
    } else {
        return "Erreur lors de l'ajout de la promotion.";
    }
}


// Fonction pour valider que le champ "Prix" est un nombre décimal (double)
function validerPrix($prix) {
    // Utilisez is_numeric pour vérifier si la valeur est un nombre
    return is_numeric($prix);
}

// Fonction pour valider que le champ "Quantité en Stock" est un entier
function validerQuantiteStock($quantite_stock) {
    // Utilisez is_numeric pour vérifier si la valeur est un nombre
    return is_numeric($quantite_stock) && intval($quantite_stock) == $quantite_stock;
}

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
    } elseif (!validerQuantiteStock($quantite_stock)) {
        $message = "Le champ 'Quantité en Stock' doit contenir un nombre entier.";
    } else {
        // Ajoutez le bloc de code ici
        if (isset($_POST["en_promotion"]) && isset($_POST["pourcentage_remise"]) && $_POST["pourcentage_remise"] >= 5 && $_POST["pourcentage_remise"] <= 60) {
            $en_promotion = true;
            $pourcentage_remise = $_POST["pourcentage_remise"];
            $date_debut_promo = $_POST["date_debut_promo"];
            $date_fin_promo = $_POST["date_fin_promo"];

            // Valider que la date de fin est supérieure à la date de début
            if (strtotime($date_fin_promo) <= strtotime($date_debut_promo)) {
                $message .= " La date de fin de la promotion doit être après la date de début.";
            } else {
                if ($en_promotion) {
                    $message .= " " . ajouterPromotion($dbh, $dbh->lastInsertId(), $pourcentage_remise, $date_debut_promo, $date_fin_promo);
                }
            }
        }
        if ($message === '') {
            $message = ajouterProduit($dbh, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $image_extension);

            if ($en_promotion) {
                $message .= " " . ajouterPromotion($dbh, $dbh->lastInsertId(), $pourcentage_remise, $date_debut_promo, $date_fin_promo);
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
            <input type="checkbox" name="en_promotion" id="en_promotion">
        </div>
        <div class="form-group" id="champ_remise" style="display:none;">
            <label for="pourcentage_remise">Pourcentage de Remise</label>
            <input type="number" name="pourcentage_remise" class="form-control" min="5" max="60">
        </div>
        <div class="form-group" id="champ_remise" style="display:none;">
        <label for="date_debut_promo">Date de Début de la Promotion</label>
            <input type="date" name="date_debut_promo" class="form-control" required>
        </div>
        <div class="form-group" id="champ_remise" style="display:none;">
            <label for="date_fin_promo">Date de Fin de la Promotion</label>
            <input type="date" name="date_fin_promo" class="form-control" required>
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
    // Fonction pour afficher ou masquer le champ "Pourcentage de Remise"
    function afficherMasquerChampRemise() {
        const casePromotion = document.getElementById('en_promotion');
        const champRemise = document.getElementById('champ_remise');

        if (casePromotion.checked) {
            champRemise.style.display = 'block';
        } else {
            champRemise.style.display = 'none';
        }
    }

    // Appeler la fonction lorsqu'il y a un changement dans la case à cocher
    document.getElementById('en_promotion').addEventListener('change', afficherMasquerChampRemise);

    // Fonction pour annuler l'ajout et revenir à la page admin.php
    function annulerAjout() {
        window.location.href = 'admin.php';
    }
</script>
<?php include('footer.php'); ?>