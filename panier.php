<?php
session_start();
include('connect.php');

function calculerTotalPanier() {
    $total = 0;
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $produit) {
            if (isset($produit['prix'], $produit['quantite'])) {
                $total += $produit['prix'] * $produit['quantite'];
            }
        }
    }
    return $total;
}

if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    if (isset($_SESSION['panier'][$_GET['id']])) {
        unset($_SESSION['panier'][$_GET['id']]);
    }
}

$contenuPanier = '';
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $product_id => $produit) {
        if (isset($produit['nom'], $produit['prix'], $produit['quantite'])) {
            $totalProduit = $produit['prix'] * $produit['quantite'];
            $contenuPanier .= "<tr>
                                 <td>" . htmlspecialchars($produit['nom']) . "</td>
                                 <td>" . htmlspecialchars($produit['prix']) . " €</td>
                                 <td>" . htmlspecialchars($produit['quantite']) . "</td>
                                 <td>" . htmlspecialchars($totalProduit) . " €</td>
                                 <td><a href='panier.php?action=supprimer&id=$product_id' class='btn btn-danger btn-sm'>Supprimer</a></td>
                               </tr>";
        }
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
<?php include('head_header_nav.php'); ?>
<?php var_dump($_SESSION);?>
<div class="container">
    <?php if (isset($_SESSION['erreur'])): ?>
        <p class="alert alert-danger"><?php echo $_SESSION['erreur']; ?></p>
        <?php unset($_SESSION['erreur']);?>
    <?php endif; ?>
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
        <div>
            <?php if (isset($_SESSION['email'])): ?>
                <a href="expedition.php" class="btn btn-success">Confirmer la Commande</a>
            <?php else: ?>
                <a href="connexion_inscription.php" class="btn btn-success">Connectez-vous pour continuer</a>
            <?php endif; ?>
            <a href="index.php" class="btn btn-primary">Retour à la page d'accueil</a>
        </div>
    <?php else: ?>
        <p>Votre panier est vide. <a href="index.php" class="btn btn-primary">Retour à la page d'accueil</a></p>
    <?php endif; ?>
</div>
<?php include('script_jquery.php'); ?>
<?php include('footer.php'); ?>
</body>
</html>
