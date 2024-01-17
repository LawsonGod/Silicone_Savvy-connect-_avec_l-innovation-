<?php
global $dbh;
session_start();

global $stmt;
include('connect.php');

$msg = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];

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
        $conditions[] = "nom LIKE :keyword";
        $params[':keyword'] = $keyword;
    }

    if (!empty($filtreMarques)) {
        $marquesPlaceholder = implode(', ', array_fill(0, count($filtreMarques), ':marque'));
        $sql .= ' AND marque_id IN (' . $marquesPlaceholder . ')';
        foreach ($filtreMarques as $key => $value) {
            $params[":marque$key"] = $value;
        }
    }

    if (!empty($filtreCategories)) {
        $categoriesPlaceholder = implode(', ', array_fill(0, count($filtreCategories), ':categorie'));
        $sql .= ' AND categorie_id IN (' . $categoriesPlaceholder . ')';
        foreach ($filtreCategories as $key => $value) {
            $params[":categorie$key"] = $value;
        }
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

        foreach ($params as $paramName => $paramValue) {
            $stmt->bindParam($paramName, $paramValue);
        }

        $stmt->execute();
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
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silicone Savvy</title>
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
</head>
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
            <?php echo $message; ?>
        </div>
    </div>
</div>
</body>
<?php include('footer.php');?>
</html>
