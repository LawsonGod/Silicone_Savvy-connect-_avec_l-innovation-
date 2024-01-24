<?php
// Inclure la session et la connexion à la base de données
global $dbh;
session_start();

include('connect.php');

// Variables pour les filtres et l'ordre de tri
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
$tranchePrix = isset($_POST['tranchePrix']) ? $_POST['tranchePrix'] : '';
$filtreNote = isset($_POST['filtreNote']) ? $_POST['filtreNote'] : '';

// Fonction pour vérifier si une valeur est cochée
function isChecked($value, $postArray) {
    return in_array($value, $postArray) ? 'checked' : '';
}

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

// Construction de la requête SQL de base pour les produits
    $sql = 'SELECT produits.id, produits.image, produits.nom, produits.prix, 
    COALESCE(AVG(evaluations.note), 0) AS note_moyenne,
    COALESCE(promotions.pourcentage_remise, 0) AS pourcentage_remise
    FROM produits 
    LEFT JOIN evaluations ON produits.id = evaluations.produit_id
    LEFT JOIN promotions ON produits.id = promotions.produit_id
    AND NOW() BETWEEN promotions.date_debut AND promotions.date_fin';

    // Tableaux pour stocker les conditions et les paramètres de requête
    $conditions = [];
    $params = [];

// Filtrage par mot-clé
    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $keyword = '%' . $_POST['keyword'] . '%';
        $conditions[] = "nom LIKE ?";
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

// Ajout des conditions à la requête SQL
    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    // Groupement et conditions HAVING pour la note moyenne
    $sql .= ' GROUP BY produits.id, produits.image, produits.nom, produits.prix ';
    $havingConditions = [];

    if ($filtreNote == 'positives') {
        $havingConditions[] = 'COALESCE(AVG(evaluations.note), 0) > 3';
    } elseif ($filtreNote == 'negatives') {
        $havingConditions[] = 'COALESCE(AVG(evaluations.note), 0) < 3';
    }

// Ajout des conditions HAVING à la requête SQL
    if (!empty($havingConditions)) {
        $sql .= ' HAVING ' . implode(' AND ', $havingConditions);
    }

    // Gestion de l'ordre de tri
    if (isset($_POST['tri'])) {
        $orderBy = $_POST['tri'];
        if ($orderBy == 'asc') {
            $sql .= ' ORDER BY prix ASC';
        } elseif ($orderBy == 'desc') {
            $sql .= ' ORDER BY prix DESC';
        }
    } else {
        $sql .= ' ORDER BY id ASC';
    }

// Préparation et exécution de la requête SQL
    $stmt = $dbh->prepare($sql);

    try {
        if (!$stmt) {
            throw new PDOException("La préparation de la requête a échoué.");
        }

        $stmt->execute($params);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

// Génération de la liste de produits à afficher
    if ($stmt->rowCount() === 0) {
        $message = '<p>Aucun résultat trouvé.</p>';
    } else {
        $message = '<div class="product-grid">';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product_id = $row['id'];
            $image = $row['image'];
            $nom = $row['nom'];
            $prix = $row['prix'];
            $note_moyenne = round($row['note_moyenne'], 1);
            $pourcentage_remise = $row['pourcentage_remise'];

            $prix_final = $pourcentage_remise > 0 ? $prix - ($prix * $pourcentage_remise / 100) : $prix;
            $prix_final_formatte = number_format($prix_final, 2, '.', '');

            $message .= '<div class="product">';
            $message .= "<a href='produit.php?id=$product_id'>";
            $message .= "<img src='$image' alt='$nom' class='product-image card-img-top'>";
            $message .= "<h3>$nom</h3>";

            if ($pourcentage_remise > 0) {
                $message .= "<p class='prix-original'><s>Prix : $prix €</s></p>";
                $message .= "<p class='remise'>Remise : $pourcentage_remise%</p>";
                $message .= "<p class='prix-remise'>Après remise : $prix_final_formatte €</p>";
            } else {
                $message .= "<p>Prix : $prix €</p>";
            }

            $message .= "<p>Note moyenne : $note_moyenne / 5</p>";
            $message .= '</a>';
            $message .= '</div>';
        }
        $message .= '</div>';
    }
} catch (PDOException $e) {
    $message = 'Une erreur est survenue lors de la récupération des données : ' . $e->getMessage();
}

// Fermeture de la connexion à la base de données
$dbh = null;
?>
<?php include('head_header_nav.php');?>
    <br>
    <br>
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

            <form method="post" class="mb-3">
                <div class="form-group mb-2">
                    <select id="tri" name="tri" class="form-control">
                        <option value="">Par défaut</option>
                        <option value="asc" <?php echo $orderBy == 'asc' ? 'selected' : ''; ?>>Croissant</option>
                        <option value="desc" <?php echo $orderBy == 'desc' ? 'selected' : ''; ?>>Décroissant</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Rechercher par mot clé" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="tranchePrix" class="form-label">Tranche de Prix:</label>
                    <select id="tranchePrix" name="tranchePrix" class="form-select">
                        <option value="">Tous les prix</option>
                        <option value="0-100" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '0-100') ? 'selected' : ''; ?>>0 - 100 €</option>
                        <option value="100-500" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '100-500') ? 'selected' : ''; ?>>100 - 500 €</option>
                        <option value="500-1000" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '500-1000') ? 'selected' : ''; ?>>500 - 1000 €</option>
                        <option value="1000" <?php echo (isset($_POST['tranchePrix']) && $_POST['tranchePrix'] == '1000') ? 'selected' : ''; ?>>Plus de 1000 €</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <select id="filtreNote" name="filtreNote" class="form-select">
                        <option value="">Filtrer par Note</option>
                        <option value="positives">Positives (> 3)</option>
                        <option value="negatives">Négatives (&amp; 3)</option>
                    </select>
                </div>

                <h4>Catégories</h4>
                <?php foreach ($categories as $categorie): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $categorie['id']; ?>" <?php echo isChecked($categorie['id'], $filtreCategories); ?>>
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($categorie['nom']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <h4>Marques</h4>
                <?php foreach ($marques as $marque): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="marques[]" value="<?php echo $marque['id']; ?>" <?php echo isChecked($marque['id'], $filtreMarques); ?>>
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