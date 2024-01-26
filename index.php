<?php
// Inclure la session et la connexion à la base de données
global $dbh;
session_start();

include('connect.php');
require_once('./inc/outils.php');

// Variables pour les filtres et l'ordre de tri
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
$filtreRemise = isset($_POST['filtreRemise']) ? $_POST['filtreRemise'] : '';
$tranchePrix = isset($_POST['tranchePrix']) ? $_POST['tranchePrix'] : '';
$filtreNote = isset($_POST['filtreNote']) ? $_POST['filtreNote'] : '';
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

try {
    // Vérifier la connexion à la base de données
    if ($dbh === null) {
        die("Erreur de connexion à la base de données.");
    }

    // Récupérer les catégories depuis la base de données
    $stmt_cat = $dbh->query('SELECT id, nom FROM categories');
    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer les marques depuis la base de données
    $stmt_marque = $dbh->query('SELECT id, nom FROM marques');
    $marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

    // Début de la requête SQL
    $sql = 'SELECT produits.id, produits.image, produits.nom, produits.prix, 
        COALESCE(promotions.pourcentage_remise, 0) AS pourcentage_remise,
        CASE
            WHEN promotions.pourcentage_remise IS NOT NULL 
                THEN produits.prix - (produits.prix * promotions.pourcentage_remise / 100)
            ELSE produits.prix
        END AS prix_final,
        COALESCE(noteMoyenne.note_moyenne, 0) AS note_moyenne
        FROM produits 
        LEFT JOIN (SELECT produit_id, AVG(note) AS note_moyenne 
                   FROM evaluations 
                   GROUP BY produit_id) AS noteMoyenne ON produits.id = noteMoyenne.produit_id
        LEFT JOIN promotions ON produits.id = promotions.produit_id
        AND NOW() BETWEEN promotions.date_debut AND promotions.date_fin';

    // Tableaux pour stocker les conditions et les paramètres de requête
    $conditions = [];
    $params = [];

    // Filtrage par mot-clé
    if (!empty($keyword)) {
        $keyword = '%' . $keyword . '%';
        $conditions[] = "produits.nom LIKE ?";
        $params[] = $keyword;
    }

    // Filtrage par marques sélectionnées
    if (!empty($filtreMarques)) {
        $marquesPlaceholder = implode(', ', array_fill(0, count($filtreMarques), '?'));
        $conditions[] = "marque_id IN ($marquesPlaceholder)";
        $params = array_merge($params, $filtreMarques);
    }

    // Filtrage par catégories sélectionnées
    if (!empty($filtreCategories)) {
        $categoriesPlaceholder = implode(', ', array_fill(0, count($filtreCategories), '?'));
        $conditions[] = "categorie_id IN ($categoriesPlaceholder)";
        $params = array_merge($params, $filtreCategories);
    }

    // Gestion de la condition de filtre par tranche de prix
    if (!empty($tranchePrix)) {
        $prixRange = explode('-', $tranchePrix);
        if (count($prixRange) == 2) {
            $conditions[] = "prix >= ? AND prix <= ?";
            $params[] = $prixRange[0];
            $params[] = $prixRange[1];
        } elseif ($prixRange[0] == '1000') {
            $conditions[] = "prix >= ?";
            $params[] = 1000;
        }
    }

    // Filtrage par pourcentage de remise
    if (!empty($filtreRemise)) {
        $conditions[] = "COALESCE(promotions.pourcentage_remise, 0) >= ?";
        $params[] = $filtreRemise;
    }

    // Filtrage par note
    if (!empty($filtreNote) && $filtreNote != 'non-note') {
        $noteValue = (int)$filtreNote;
        $conditions[] = "note_moyenne >= ?";
        $params[] = $noteValue;
    } elseif ($filtreNote == 'non-note') {
        $conditions[] = "note_moyenne = 0";
    }

    // Ajouter les conditions à la requête
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    // Ajout de GROUP BY
    $sql .= ' GROUP BY produits.id, produits.image, produits.nom, produits.prix';

    // Gestion de l'ordre de tri
    if (isset($_POST['tri'])) {
        $orderBy = $_POST['tri'];
        if ($orderBy == 'asc') {
            $sql .= ' ORDER BY prix_final ASC';
        } elseif ($orderBy == 'desc') {
            $sql .= ' ORDER BY prix_final DESC';
        }
    } else {
        $sql .= ' ORDER BY produits.id ASC';
    }

    // Exécution de la requête SQL
    $stmt = executerRequeteIndex($dbh, $sql, $params);

    // Appel de la fonction pour construire la liste de produits
    $message = construireListeProduitsPourLaPageDAccueil($stmt);

} catch (PDOException $e) {
    $message = 'Une erreur PDO est survenue : ' . $e->getMessage() . ' dans le fichier ' . $e->getFile() . ' à la ligne ' . $e->getLine();
}

// Fermeture de la connexion à la base de données
$dbh = null;
?>
<?php include('head_header_nav.php');?>
    <br><br>
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
        <li data-bs-target="#myCarousel" data-bs-slide-to="3"></li>
        <li data-bs-target="#myCarousel" data-bs-slide-to="4"></li>
        <li data-bs-target="#myCarousel" data-bs-slide-to="5"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./assets/Image_Silicone_Savyy/Carousel7.png" alt="Image 1">
        </div>
        <div class="carousel-item">
            <img src="./assets/Image_Silicone_Savyy/Carousel1.png" alt="Image 2">
        </div>
        <div class="carousel-item">
            <img src="./assets/Image_Silicone_Savyy/Carousel2.png" alt="Image 3">
        </div>
        <div class="carousel-item">
            <img src="./assets/Image_Silicone_Savyy/Carousel4.png" alt="Image 4">
        </div>
        <div class="carousel-item">
            <img src="./assets/Image_Silicone_Savyy/Carousel5.png" alt="Image 5">
        </div>
        <div class="carousel-item">
            <img src="./assets/Image_Silicone_Savyy/Carousel6.png" alt="Image 6">
        </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </a>
</div>
<br>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <h2>Options de Tri et Recherche</h2>
            <br><br>
            <h4>Trier par :</h4>
            <form method="post" class="mb-3">
                <div class="form-group mb-2">
                    <select id="tri" name="tri" class="form-control">
                        <option value="">Par défaut</option>
                        <option value="asc" <?php echo $orderBy == 'asc' ? 'selected' : ''; ?>>Croissant</option>
                        <option value="desc" <?php echo $orderBy == 'desc' ? 'selected' : ''; ?>>Décroissant</option>
                    </select>
                </div>

                <h4>Rechercher sur notre site :</h4>
                <div class="form-group mb-2">
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Rechercher par mot clé" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>">
                </div>

                <h4>Prix :</h4>
                <div class="form-group mb-2">
                    <select id="tranchePrix" name="tranchePrix" class="form-select">
                        <option value="">Tous les prix</option>
                        <option value="0-100" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '0-100') ? 'selected' : ''; ?>>0 - 100 €</option>
                        <option value="100-500" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '100-500') ? 'selected' : ''; ?>>100 - 500 €</option>
                        <option value="500-1000" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '500-1000') ? 'selected' : ''; ?>>500 - 1000 €</option>
                        <option value="1000" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '1000') ? 'selected' : ''; ?>>Plus de 1000 €</option>
                    </select>
                </div>

                <h4>Remise :</h4>
                <div class="form-group mb-2">
                    <select id="filtreRemise" name="filtreRemise" class="form-select">
                        <option value="">Sélectionnez une remise</option>
                        <option value="10" <?php echo (isset($_POST['filtreRemise']) && $_POST['filtreRemise'] == '10') ? 'selected' : ''; ?>>10 % de remise ou plus</option>
                        <option value="20" <?php echo (isset($_POST['filtreRemise']) && $_POST['filtreRemise'] == '20') ? 'selected' : ''; ?>>20 % de remise ou plus</option>
                        <option value="30" <?php echo (isset($_POST['filtreRemise']) && $_POST['filtreRemise'] == '30') ? 'selected' : ''; ?>>30 % de remise ou plus</option>
                        <option value="50" <?php echo (isset($_POST['filtreRemise']) && $_POST['filtreRemise'] == '50') ? 'selected' : ''; ?>>50 % de remise ou plus</option>
                    </select>
                </div>

                <h4>Moyenne des commentaires des clients :</h4>
                <div class="form-group mb-2">
                    <select id="filtreNote" name="filtreNote" class="form-select">
                        <option value="">Toutes les notes</option>
                        <option value="1" <?php echo ($filtreNote == '1') ? 'selected' : ''; ?>>1 et plus</option>
                        <option value="2" <?php echo ($filtreNote == '2') ? 'selected' : ''; ?>>2 et plus</option>
                        <option value="3" <?php echo ($filtreNote == '3') ? 'selected' : ''; ?>>3 et plus</option>
                        <option value="4" <?php echo ($filtreNote == '4') ? 'selected' : ''; ?>>4 et plus</option>
                        <option value="non-note" <?php echo ($filtreNote == 'non-note') ? 'selected' : ''; ?>>Non noté</option>
                    </select>
                </div>

                <h4>Catégories :</h4>
                <?php foreach ($categories as $categorie): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $categorie['id']; ?>" <?php echo estCochee($categorie['id'], $filtreCategories); ?>>
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($categorie['nom']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <h4>Marques :</h4>
                <?php foreach ($marques as $marque): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="marques[]" value="<?php echo $marque['id']; ?>" <?php echo estCochee($marque['id'], $filtreMarques); ?>>
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($marque['nom']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary mt-2">Rechercher et Filtrer</button>
                <a href='index.php' class='btn btn-secondary mt-2'>Réinitialiser</a>
                <br>
                <br>

            </form>

        </div>

        <div class="col-md-8">
            <h2>Liste des Produits</h2>
            <br><br>
            <?php echo $message; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#myCarousel').carousel();
        interval: 1000;
    });
</script>
<?php include('footer.php');?>