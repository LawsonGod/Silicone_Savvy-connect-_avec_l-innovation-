<?php
global $dbh;
session_start();
include('connect.php');

$msg = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];

$stmt_cat = $dbh->query('SELECT id, nom FROM categories');
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);

$stmt_marque = $dbh->query('SELECT id, nom FROM marques');
$marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

$sql = 'SELECT id, image, nom, prix FROM produits';
$conditions = [];
$params = [];

// Filtre par mot-clé
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = '%' . $_GET['keyword'] . '%';
    $conditions[] = "nom LIKE :keyword";
    $params[':keyword'] = $keyword;
}

if (!empty($filtreMarques)) {
    $marquesPlaceholder = implode(',', array_fill(0, count($filtreMarques), '?'));
    $conditions[] = "marque_id IN ($marquesPlaceholder)";
    $params = array_merge($params, $filtreMarques);
}

if (!empty($filtreCategories)) {
    $categoriesPlaceholder = implode(',', array_fill(0, count($filtreCategories), '?'));
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
$stmt->execute($params);

$msg .= '<div class="product-grid">';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $product_id = $row['id'];
    $image = $row['image'];
    $nom = $row['nom'];
    $prix = $row['prix'];

    $msg .= '<div class="product">';
    $msg .= "<a href='produit.php?id=$product_id'>";
    $msg .= "<img src='$image' alt='$nom'>";
    $msg .= "<h3>$nom</h3>";
    $msg .= "<p>Prix : $prix €</p>";
    $msg .= '</a>';
    $msg .= '</div>';
}
$msg .= '</div>';

$dbh = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silicone Savvy</title>
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="jumbotron text-center">
    <h1>Accueil du site SiliconeSavvy</h1>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <h2>Options de Tri et Recherche</h2>

            <form method="post" class="mb-3">
                <div class="form-group mb-2">
                    <select id="tri" name="tri" class="form-control">
                        <option value="">Par défaut</option>
                        <option value="asc">Croissant</option>
                        <option value="desc">Décroissant</option>
                    </select>
                </div>

                <div class="form-group mb-2">
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="Rechercher par mot clé">
                </div>

                <h4>Catégories</h4>
                <?php foreach ($categories as $categorie): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $categorie['id']; ?>">
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($categorie['nom']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <!-- Filtres par marque -->
                <h4>Marques</h4>
                <?php foreach ($marques as $marque): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="marques[]" value="<?php echo $marque['id']; ?>">
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($marque['nom']); ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary mt-2">Rechercher et Filtrer</button>
            </form>
        </div>

        <div class="col-md-8">
            <h2>Liste des Produits</h2>
            <?php echo $msg; ?>
        </div>
    </div>
</div>
</body>
</html>


