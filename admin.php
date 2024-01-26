<?php
// Inclure le fichier de connexion
global $dbh;
include('connect.php');
require_once('./inc/outils.php');
session_start();

if (!estAdministrateur()) {
    header('Location: index.php');
    exit;
}

$message = '';
$orderBy = '';
$filtreMarques = isset($_POST['marques']) ? $_POST['marques'] : [];
$filtreCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
$tranchePrix = isset($_POST['tranchePrix']) ? $_POST['tranchePrix'] : '';
$filtreQuantiteStock = isset($_POST['quantiteStock']) ? $_POST['quantiteStock'] : '';
$filtreRemise = isset($_POST['filtreRemise']) ? $_POST['filtreRemise'] : '';
$filtreNote = isset($_POST['filtreNote']) ? $_POST['filtreNote'] : '';
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

$categories = obtenirCategories($dbh);
$marques = obtenirMarques($dbh);

$parametresFiltres = [
    'motCle' => isset($_POST['keyword']) ? $_POST['keyword'] : '',
    'filtreMarques' => $filtreMarques,
    'filtreCategories' => $filtreCategories,
    'tranchePrix' => $tranchePrix,
    'tri' => $orderBy,
    'quantiteStock' => $filtreQuantiteStock,
    'triPourcentageRemise' => '',
    'triMoyenneEvaluations' => '',
];

$produits = obtenirProduitsFiltres($dbh, $parametresFiltres);
?>
    <script>
        // Fonction de confirmation de suppression d'un produit
        function confirmerLaSuppression(productId) {
            if (confirm("Êtes-vous sûr de vouloir supprimer le produit ?")) {
                $.ajax({
                    type: 'POST',
                    url: 'supprimer_produit.php',
                    data: { productId: productId },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>
<?php include('head_header_nav.php');?>
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
                            <option value="desc_note" <?php echo $orderBy == 'desc_note' ? 'selected' : ''; ?>>Note</option>
                            <option value="quantiteStock_asc" <?php echo $orderBy == 'quantiteStock_asc' ? 'selected' : ''; ?>>Stock croissant</option>
                            <option value="quantiteStock_desc" <?php echo $orderBy == 'quantiteStock_desc' ? 'selected' : ''; ?>>Stock décroissant</option>
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
                    <a href='admin.php' class='btn btn-secondary mt-2'>Réinitialiser</a>
                    <br>
                    <br>

                </form>
            </div>
            <div class="col-md-8">
                <h1>Liste des Produits</h1>
                <a href="./ajouter_produit.php" class="btn btn-primary">Ajouter un Produit</a>
                <a href="./ajouter_categorie.php" class="btn btn-secondary">Ajouter une Catégorie</a>
                <a href="./ajouter_marque.php" class="btn btn-secondary">Ajouter une Marque</a>
                <a href="./liste_des_clients.php" class="btn btn-info">Voir la Liste des Clients</a>
                <a href="./liste_des_commandes.php" class="btn btn-info">Voir la Liste des Commandes</a>
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
                            <td class="align-middle">
                                <img src="<?php echo htmlspecialchars(isset($produit['Image']) ? $produit['Image'] : ''); ?>"
                                     alt="<?php echo htmlspecialchars(isset($produit['NomProduit']) ? $produit['NomProduit'] : ''); ?>"
                                     style="max-width: 210px; max-height: 210px;">
                            </td>
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
                                    <form action="editer_produit.php" method="POST">
                                        <input type="hidden" name="edit_product_id" value="<?php echo htmlspecialchars($produit['id']); ?>">
                                        <button type="submit" class="btn btn-primary mb-2 w-100">Éditer</button>
                                    </form>
                                    <form action="admin.php" method="POST">
                                        <input type="hidden" name="delete_product_id" value="<?php echo htmlspecialchars(isset($produit['id']) ? $produit['id'] : ''); ?>">
                                        <button class="btn btn-danger" onclick="confirmerLaSuppression(<?php echo $produit['id']; ?>)">Supprimer</button>
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
<?php include('footer.php');?>