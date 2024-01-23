<?php
global $dbh;
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "administrateur") {
    header('Location: index.php');
    exit;
}

include('connect.php');

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

// Fonction pour valider le prix du produit (nombre décimal)
function validerPrix($prix) {
    return is_numeric($prix);
}

// Fonction pour valider la quantité en stock (nombre entier)
function validerQuantiteStock($quantite_stock) {
    return filter_var($quantite_stock, FILTER_VALIDATE_INT) !== false;
}

// Fonction pour valider le pourcentage de remise (entre 5 et 60)
function validerPourcentageRemise($pourcentage_remise) {
    return $pourcentage_remise >= 5 && $pourcentage_remise <= 60;
}

// Fonction pour gérer la mise à jour du produit
function editerProduit($dbh, $id, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description) {
    $sql = "UPDATE produits SET nom = ?, categorie_id = ?, marque_id = ?, prix = ?, quantite_stock = ?, description = ? WHERE id = ?";
    $stmt = $dbh->prepare($sql);

    if ($stmt->execute([$nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description, $id])) {
        return "Le produit a été mis à jour avec succès.";
    } else {
        return "Erreur lors de la mise à jour du produit.";
    }
}

// Fonction pour récupérer les détails du produit à éditer
function recupererDetailsProduit($dbh, $id) {
    $sql = "SELECT * FROM produits WHERE id = ?";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour ajouter ou mettre à jour la promotion du produit
function gererPromotion($dbh, $id_produit, $pourcentage_remise, $date_debut_promo, $date_fin_promo) {
    // Vérifier si une promotion existe déjà pour ce produit
    $sql_check_promo = "SELECT id FROM promotions WHERE produit_id = ?";
    $stmt_check_promo = $dbh->prepare($sql_check_promo);
    $stmt_check_promo->execute([$id_produit]);
    $existing_promo = $stmt_check_promo->fetch(PDO::FETCH_ASSOC);

    if ($existing_promo) {
        // Mettre à jour la promotion existante
        $sql_update_promo = "UPDATE promotions SET pourcentage_remise = ?, date_debut = ?, date_fin = ? WHERE produit_id = ?";
        $stmt_update_promo = $dbh->prepare($sql_update_promo);
        $stmt_update_promo->execute([$pourcentage_remise, $date_debut_promo, $date_fin_promo, $id_produit]);
    } else {
        // Insérer une nouvelle promotion
        $sql_insert_promo = "INSERT INTO promotions (produit_id, pourcentage_remise, date_debut, date_fin) VALUES (?, ?, ?, ?)";
        $stmt_insert_promo = $dbh->prepare($sql_insert_promo);
        $stmt_insert_promo->execute([$id_produit, $pourcentage_remise, $date_debut_promo, $date_fin_promo]);
    }
}

// Fonction pour convertir le format de date du formulaire au format de la base de données
function convertirFormatDateInverse($date) {
    $elementsDate = explode('/', $date);

    if (count($elementsDate) !== 3) {
        return false;
    }

    $nouveauFormat = $elementsDate[2] . '-' . $elementsDate[1] . '-' . $elementsDate[0] . ' 00:00:00';

    return $nouveauFormat;
}

// Fonction pour convertir le format de date de la base de données au format du formulaire
function convertirFormatDate($date) {
    $timestamp = strtotime($date);
    $nouveauFormat = date('d/m/Y', $timestamp);
    return $nouveauFormat;
}

// Récupérer les détails du produit à éditer (si l'ID est défini)
$details_produit = null;
if (isset($_POST["edit_product_id"])) {
    $id_produit_a_editer = $_POST["edit_product_id"];
    $details_produit = recupererDetailsProduit($dbh, $id_produit_a_editer);

    // Récupérer les informations de la promotion (le cas échéant)
    $sql_promotion = "SELECT pourcentage_remise, date_debut, date_fin FROM promotions WHERE produit_id = ?";
    $stmt_promotion = $dbh->prepare($sql_promotion);
    $stmt_promotion->execute([$id_produit_a_editer]);
    $promotion = $stmt_promotion->fetch(PDO::FETCH_ASSOC);

    // Si des informations de promotion sont trouvées, les attribuer aux variables correspondantes
    if ($promotion) {
        $pourcentage_remise = $promotion['pourcentage_remise'];
        $date_debut_promo = convertirFormatDate($promotion['date_debut']); // Conversion de la date au format du formulaire
        $date_fin_promo = convertirFormatDate($promotion['date_fin']); // Conversion de la date au format du formulaire
    }
}

// Récupérer les valeurs des champs pour le produit
$nom = isset($_POST["nom"]) ? $_POST["nom"] : (isset($details_produit['nom']) ? $details_produit['nom'] : '');
$categorie_id = isset($_POST["categorie_id"]) ? $_POST["categorie_id"] : (isset($details_produit['categorie_id']) ? $details_produit['categorie_id'] : '');
$marque_id = isset($_POST["marque_id"]) ? $_POST["marque_id"] : (isset($details_produit['marque_id']) ? $details_produit['marque_id'] : '');
$prix = isset($_POST["prix"]) ? $_POST["prix"] : (isset($details_produit['prix']) ? $details_produit['prix'] : '');
$quantite_stock = isset($_POST["quantite_stock"]) ? $_POST["quantite_stock"] : (isset($details_produit['quantite_stock']) ? $details_produit['quantite_stock'] : '');
$description = isset($_POST["description"]) ? $_POST["description"] : (isset($details_produit['description']) ? $details_produit['description'] : '');

// Récupérer les valeurs des champs pour la promotion
$pourcentage_remise = isset($_POST["pourcentage_remise"]) ? $_POST["pourcentage_remise"] : (isset($promotion['pourcentage_remise']) ? $promotion['pourcentage_remise'] : '');
$date_debut_promo = isset($_POST["date_debut"]) ? $_POST["date_debut"] : (isset($promotion['date_debut']) ? $promotion['date_debut'] : '');
$date_fin_promo = isset($_POST["date_fin"]) ? $_POST["date_fin"] : (isset($promotion['date_fin']) ? $promotion['date_fin'] : '');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["editer_produit"])) {
    if (!validerNomProduit($nom)) {
        $message = "Le nom du produit contient des caractères interdits.";
    } elseif (!validerPrix($prix)) {
        $message = "Le champ 'Prix' doit contenir un nombre décimal (double).";
    } elseif (!validerQuantiteStock($quantite_stock)) {
        $message = "Le champ 'Quantité en Stock' doit contenir un nombre entier.";
    } else {
        $message = editerProduit($dbh, $id_produit_a_editer, $nom, $categorie_id, $marque_id, $prix, $quantite_stock, $description);

        // Gérer la promotion (ajout ou mise à jour)
        if (!empty($pourcentage_remise) && !empty($date_debut_promo) && !empty($date_fin_promo)) {
            if (validerPourcentageRemise($pourcentage_remise)) {
                // Convertir les dates au format de la base de données
                $date_debut_promo_db = convertirFormatDateInverse($date_debut_promo);
                $date_fin_promo_db = convertirFormatDateInverse($date_fin_promo);
                gererPromotion($dbh, $id_produit_a_editer, $pourcentage_remise, $date_debut_promo_db, $date_fin_promo_db);
            } else {
                $message .= " La promotion n'a pas été ajoutée car le pourcentage de remise doit être entre 5 et 60.";
            }
        }
    }
}
?>
<?php include('head_header_nav.php'); ?>
<?php
//var_dump($nom);
//var_dump($categorie_id);
//var_dump($marque_id);
//var_dump($prix);
//var_dump($quantite_stock);
//var_dump($description);
//var_dump($pourcentage_remise);
//var_dump($date_debut_promo);
//var_dump($date_fin_promo);
//?>
    <div class="container">
        <h1>Éditer un Produit</h1>
        <?php if ($message !== '') : ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>
    <form action="editer_produit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="edit_product_id" value="<?php echo $id_produit_a_editer; ?>"> <!-- Correction de la clé ici -->
        <div class="form-group">
            <label for="nom">Nom du Produit</label>
            <input type="text" name="nom" class="form-control" value="<?php echo isset($nom) ? htmlspecialchars($nom) : (isset($details_produit['nom']) ? htmlspecialchars($details_produit['nom']) : ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="categorie_id">Catégorie</label>
            <select name="categorie_id" class="form-control" required>
                <?php foreach (recupererCategories($dbh) as $categorie) : ?>
                    <option value="<?php echo $categorie['id']; ?>" <?php if ($categorie['id'] == $categorie_id || (isset($details_produit['categorie_id']) && $categorie['id'] == $details_produit['categorie_id'])) echo 'selected'; ?>><?php echo htmlspecialchars($categorie['nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="marque_id">Marque</label>
            <select name="marque_id" class="form-control" required>
                <?php foreach (recupererMarques($dbh) as $marque) : ?>
                    <option value="<?php echo $marque['id']; ?>" <?php if ($marque['id'] == $marque_id || (isset($details_produit['marque_id']) && $marque['id'] == $details_produit['marque_id'])) echo 'selected'; ?>><?php echo htmlspecialchars($marque['nom']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="text" name="prix" class="form-control" value="<?php echo isset($prix) ? htmlspecialchars($prix) : (isset($details_produit['prix']) ? htmlspecialchars($details_produit['prix']) : ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="quantite_stock">Quantité en Stock</label>
            <input type="text" name="quantite_stock" class="form-control" value="<?php echo isset($quantite_stock) ? htmlspecialchars($quantite_stock) : (isset($details_produit['quantite_stock']) ? htmlspecialchars($details_produit['quantite_stock']) : ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required><?php echo isset($description) ? htmlspecialchars($description) : (isset($details_produit['description']) ? htmlspecialchars($details_produit['description']) : ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="en_promotion">En promotion ?</label>
            <input type="checkbox" name="en_promotion" id="en_promotion" <?php if(isset($promotion)) echo 'checked'; ?> onchange="afficherMasquerChampPromotion()">
        </div>
        <div class="form-group" id="champ_remise" style="display:<?php if(isset($promotion)) echo 'block'; else echo 'none'; ?>">
            <label for="pourcentage_remise">Pourcentage de Remise</label>
            <input type="number" name="pourcentage_remise" class="form-control" min="5" max="60" value="<?php echo htmlspecialchars($pourcentage_remise); ?>">
        </div>
        <div class="form-group" id="champ_promotion" style="display:<?php if(isset($promotion)) echo 'block'; else echo 'none'; ?>">
            <label for="date_debut">Date de Début de la Promotion</label>
            <input type="date" id="date_debut" name="date_debut" class="form-control" pattern="\d{2}/\d{2}/\d{4}" value="<?php echo isset($date_debut_promo) ? htmlspecialchars($date_debut_promo) : ''; ?>">
        </div>
        <div class="form-group" id="champ_fin_promotion" style="display:<?php if(isset($promotion)) echo 'block'; else echo 'none'; ?>">
            <label for="date_fin">Date de Fin de la Promotion</label>
            <input type="date" id="date_fin" name="date_fin" class="form-control" pattern="\d{2}/\d{2}/\d{4}" value="<?php echo isset($date_fin_promo) ? htmlspecialchars($date_fin_promo) : ''; ?>">
        </div>
        <button type="submit" name="editer_produit" class="btn btn-primary">Mettre à jour</button>
        <a href="admin.php" class="btn btn-secondary">Annuler</a>
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