<?php
global $dbh;
session_start();

include('connect.php');

$msg = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
$tranchePrix = isset($_POST['tranchePrix']) ? $_POST['tranchePrix'] : '';
$filtreNote = isset($_POST['filtreNote']) ? $_POST['filtreNote'] : '';

function isChecked($value, $postArray) {
    return in_array($value, $postArray) ? 'checked' : '';
}

try {
    if ($dbh === null) {
        die("Erreur de connexion à la base de données.");
    }
    $stmt_cat = $dbh->query('SELECT id, nom FROM categories');
    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

    $stmt_marque = $dbh->query('SELECT id, nom FROM marques');
    $marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT produits.id, produits.image, produits.nom, produits.prix, 
    COALESCE(AVG(evaluations.note), 0) AS note_moyenne,
    COALESCE(promotions.pourcentage_remise, 0) AS pourcentage_remise
    FROM produits 
    LEFT JOIN evaluations ON produits.id = evaluations.produit_id
    LEFT JOIN promotions ON produits.id = promotions.produit_id
    AND NOW() BETWEEN promotions.date_debut AND promotions.date_fin';
    $conditions = [];
    $params = [];

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $keyword = '%' . $_POST['keyword'] . '%';
        $conditions[] = "nom LIKE ?";
        $params[] = $keyword;
    }

    if (!empty($filtreMarques)) {
        $marquesPlaceholder = implode(', ', array_fill(0, count($filtreMarques), '?'));
        $conditions[] = "marque_id IN ($marquesPlaceholder)";
        $params = array_merge($params, $filtreMarques);
    }

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

    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }
    $sql .= ' GROUP BY produits.id, produits.image, produits.nom, produits.prix ';
    $havingConditions = [];

    if ($filtreNote == 'positives') {
        $havingConditions[] = 'COALESCE(AVG(evaluations.note), 0) > 3';
    } elseif ($filtreNote == 'negatives') {
        $havingConditions[] = 'COALESCE(AVG(evaluations.note), 0) < 3';
    }

    if (!empty($havingConditions)) {
        $sql .= ' HAVING ' . implode(' AND ', $havingConditions);
    }
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

    $stmt = $dbh->prepare($sql);
    try {
        if (!$stmt) {
            throw new PDOException("La préparation de la requête a échoué.");
        }

        $stmt->execute($params);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

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
            $message .= "<img src='$image' alt='$nom'>";
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

$dbh = null;
?>
<?php include('head_header_nav.php');?>
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
                        <option value="negatives">Négatives (< 3)</option>
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
</body>
<?php include('footer.php');?>
</html>