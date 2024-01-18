<?php
session_start();
include('connect.php');

function calculerTotalPanier() {
    $total = 0;
    foreach ($_SESSION['panier'] as $produit) {
        $total += $produit['prix'] * $produit['quantite'];
    }
    return $total;
}

if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    unset($_SESSION['panier'][$_GET['id']]);
}

$contenuPanier = '';
$totalPanier = 0;
if (!empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $product_id => $produit) {
        $totalProduit = $produit['prix'] * $produit['quantite'];
        $totalPanier += $totalProduit;
        $contenuPanier .= "<tr>
                             <td>" . htmlspecialchars($produit['nom']) . "</td>
                             <td>" . htmlspecialchars($produit['prix']) . " €</td>
                             <td>" . htmlspecialchars($produit['quantite']) . "</td>
                             <td>" . htmlspecialchars($totalProduit) . " €</td>
                             <td><a href='panier.php?action=supprimer&id=$product_id' class='btn btn-danger btn-sm'>Supprimer</a></td>
                           </tr>";
    }
    $contenuPanier .= "<tr>
                         <td colspan='3'><strong>Total</strong></td>
                         <td><strong>" . calculerTotalPanier() . " €</strong></td>
                         <td></td>
                       </tr>";
} else {
    $contenuPanier = "<tr><td colspan='5'>Votre panier est vide.</td></tr>";
}
?>


<!DOCTYPE html>
<?php include('head.php');?>
<?php include('header_nav.php');?>
<body>
<div class="container">
    <h1 class="my-4">Votre Panier</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Produit</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php echo $contenuPanier; ?>
        </tbody>
    </table>
    <?php if (!empty($_SESSION['panier'])): ?>
        <a href="confirmation.php" class="btn btn-success">Confirmer la Commande</a>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">Retour à la page d'accueil</a>
</div>
</body>
<?php include('footer.php');?>
</html>

