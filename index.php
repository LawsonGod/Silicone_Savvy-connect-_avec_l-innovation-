<?php
global $dbh;
session_start();

include('connect.php');

$msg = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];

function isChecked($value, $postArray) {
    return in_array($value, $postArray) ? 'checked' : '';
}

try {
    $stmt_cat = $dbh->query('SELECT id, nom FROM categories');
    $categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

    $stmt_marque = $dbh->query('SELECT id, nom FROM marques');
    $marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT id, image, nom, prix FROM produits';
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

    if (!empty($conditions)) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
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

            $message .= '<div class="product">';
            $message .= "<a href='produit.php?id=$product_id'>";
            $message .= "<img src='$image' alt='$nom'>";
            $message .= "<h3>$nom</h3>";
            $message .= "<p>Prix : $prix €</p>";
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
<!DOCTYPE html>
<?php include('head.php');?>
<?php include('header_nav.php');?>
<body>
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
