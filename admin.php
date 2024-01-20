<?php
global $dbh;

include('connect.php');
session_start();

// Redirection si l'utilisateur n'est pas un administrateur
if (!isset($_SESSION["user_type"]) || $_SESSION["user_type"] !== "administrateur") {
    header('Location: index.php');
    exit;
}

$message = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
$tranchePrix = isset($_POST['tranchePrix']) ? $_POST['tranchePrix'] : '';

function isChecked($value, $postArray) {
    return in_array($value, $postArray) ? 'checked' : '';
}

$stmt_cat = $dbh->query('SELECT id, nom FROM categories');
$categories = $stmt_cat->fetchAll(PDO::FETCH_ASSOC);
$stmt_marque = $dbh->query('SELECT id, nom FROM marques');
$marques = $stmt_marque->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT
    p.id,  
    p.nom AS NomProduit,
    c.nom AS NomCategorie,
    m.nom AS NomMarque,
    p.prix AS Prix,
    pr.pourcentage_remise AS PourcentageRemise,
    CASE
        WHEN pr.pourcentage_remise > 0 THEN (p.prix - (p.prix * pr.pourcentage_remise / 100))
        ELSE p.prix
    END AS PrixApresRemise,
    p.quantite_stock AS QuantiteStock,
    p.image AS Image  
FROM produits p
INNER JOIN categories c ON p.categorie_id = c.id
INNER JOIN marques m ON p.marque_id = m.id
LEFT JOIN promotions pr ON p.id = pr.produit_id";

$conditions = [];
$params = [];

if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
    $keyword = '%' . $_POST['keyword'] . '%';
    $conditions[] = "p.nom LIKE ?";
    $params[] = $keyword;
}

if (!empty($filtreMarques)) {
    $marquesPlaceholder = implode(', ', array_fill(0, count($filtreMarques), '?'));
    $conditions[] = "p.marque_id IN ($marquesPlaceholder)";
    $params = array_merge($params, $filtreMarques);
}

if (!empty($filtreCategories)) {
    $categoriesPlaceholder = implode(', ', array_fill(0, count($filtreCategories), '?'));
    $conditions[] = "p.categorie_id IN ($categoriesPlaceholder)";
    $params = array_merge($params, $filtreCategories);
}

if (!empty($tranchePrix)) {
    $prixRange = explode('-', $tranchePrix);
    if (count($prixRange) == 2) {
        $conditions[] = "p.prix >= ? AND p.prix <= ?";
        $params[] = $prixRange[0];
        $params[] = $prixRange[1];
    } elseif ($tranchePrix == '1000') {
        $conditions[] = "p.prix >= 1000";
    }
}

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

if (isset($_POST['tri'])) {
    $orderBy = $_POST['tri'];
    $sql .= $orderBy == 'asc' ? ' ORDER BY Prix ASC' : ' ORDER BY Prix DESC';
} else {
    $sql .= ' ORDER BY p.id ASC';
}

$stmt = $dbh->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<?php include('head.php');?>
<body>
<?php include('header_nav.php');?>
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
                <a href='admin.php' class='btn btn-secondary mt-2'>Réinitialiser</a>
            </form>
        </div>
        <div class="col-md-8">
            <h1>Liste des Produits</h1>
            <button id="ajouter-produit" class="btn btn-primary">Ajouter un Produit</button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom du Produit</th>
                    <th>Catégorie</th>
                    <th>Marque</th>
                    <th>Prix</th>
                    <th>Pourcentage de Remise</th>
                    <th>Prix Après Remise (%)</th>
                    <th>Quantité en Stock</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($produits as $produit) {
                    $prixApresRemise = number_format($produit['PrixApresRemise'], 2);
                    $hasRemise = $produit['PourcentageRemise'] > 0;
                    ?>
                    <tr>
                        <td class="align-middle"><img src="<?php echo htmlspecialchars(isset($produit['Image']) ?
                                $produit['Image'] :
                                ''); ?>" alt="<?php echo htmlspecialchars(isset($produit['NomProduit']) ?
                                $produit['NomProduit'] :
                                ''); ?>"></td>
                        <td class="align-middle"><?php echo htmlspecialchars(isset($produit['NomProduit']) ?
                                $produit['NomProduit'] :
                                ''); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars(isset($produit['NomCategorie']) ?
                                $produit['NomCategorie'] :
                                ''); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars(isset($produit['NomMarque']) ?
                                $produit['NomMarque'] :
                                ''); ?></td>
                        <td class="align-middle"><?php echo htmlspecialchars(isset($produit['Prix']) ?
                                $produit['Prix'] :
                                ''); ?></td>

                        <td class="align-middle <?php echo $hasRemise ? 'text-danger' : ''; ?>">
                            <?php echo $hasRemise ? htmlspecialchars($produit['PourcentageRemise']) . '%' : ''; ?>
                        </td>

                        <td class="align-middle <?php echo $hasRemise ? 'text-danger' : ''; ?>">
                            <?php echo $hasRemise ? htmlspecialchars($prixApresRemise) : ''; ?>
                        </td>

                        <td class="align-middle"><?php echo htmlspecialchars(isset($produit['QuantiteStock']) ?
                                $produit['QuantiteStock'] :
                                ''); ?></td>
                        <td class="align-middle">
                            <div class="d-flex flex-column">
                                <form action="admin.php" method="POST">
                                    <input type="hidden" name="edit_product_id" value="<?php echo htmlspecialchars(isset($produit['id']) ?
                                        $produit['id'] :
                                        ''); ?>">
                                    <button type="submit" name="editer_produit" class="btn btn-primary mb-2 w-100">Éditer</button>
                                </form>
                                <form action="admin.php" method="POST">
                                    <input type="hidden" name="delete_product_id" value="<?php echo htmlspecialchars(isset($produit['id']) ?
                                        $produit['id'] :
                                        ''); ?>">
                                    <button type="submit" name="supprimer_produit" class="btn btn-danger w-100">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
if ($message !== '') {
    echo $message;
}
?>
<div id="formulaire-ajout" style="display: none;">
    <h2>Ajouter un Produit</h2>
    <form action="admin.php" method="POST">
        <button type="submit" name="ajouter_produit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include('footer.php'); ?>
</body>
</html>