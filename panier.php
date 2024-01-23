<?php
global $dbh;
session_start();
include('connect.php');  // Assure une connexion à la base de données

// Fonction pour calculer le total du panier
function calculerTotal($dbh) {
    $total = 0;
    if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product_id => $quantite) {
            $stmt = $dbh->prepare("SELECT prix FROM produits WHERE id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $produit = $stmt->fetch(PDO::FETCH_ASSOC);
            $total += $produit['prix'] * $quantite;
        }
    }
    return $total;
}

// Suppression d'un produit du panier
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    unset($_SESSION['panier'][$product_id]);
}

// Affichage du contenu du panier
$contenuPanier = '';
if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
    foreach ($_SESSION['panier'] as $product_id => $quantite) {
        $stmt = $dbh->prepare("SELECT nom, prix FROM produits WHERE id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalProduit = $produit['prix'] * $quantite;

        $contenuPanier .= "<tr>
                            <td>" . htmlspecialchars($produit['nom']) . "</td>
                            <td>" . htmlspecialchars($produit['prix']) . "</td>
                            <td>" . htmlspecialchars($quantite) . "</td>
                            <td>" . htmlspecialchars($totalProduit) . "</td>
                            <td><a href='panier.php?action=remove&id=$product_id' class='btn btn-danger'>Supprimer</a></td>
                         </tr>";
    }
    $contenuPanier .= "<tr>
                        <td colspan='3'><strong>Total</strong></td>
                        <td><strong>" . calculerTotal($dbh) . "</strong></td>
                        <td></td>
                     </tr>";
} else {
    $contenuPanier = "<tr><td colspan='5'>Votre panier est vide.</td></tr>";
}
?>
<?php include('head_header_nav.php'); ?>
<?php //var_dump($_SESSION);?>
<div class="container">
    <?php if (isset($_SESSION['erreur'])): ?>
        <p class="alert alert-danger"><?php echo $_SESSION['erreur']; ?></p>
        <?php unset($_SESSION['erreur']); ?>
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