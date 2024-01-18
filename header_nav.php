<?php
global $dbh;
require 'connect.php';
echo '<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silicone Savvy</title>
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>';
echo '
<header class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="./assets/SiliconeSavvy200.png" alt="Logo du Site">
            </div>
            <div class="col-md-6">
                <h1 class="text-center">Bienvenue sur Silicone Savvy</h1>
            </div>
            <div class="col-md-3">
                <div class="text-end">';
error_reporting(E_ALL);
ini_set('display_errors', '1');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo '<a href="panier.php" class="text-white mx-2"><i class="fa-solid fa-cart-shopping"></i> Panier (0)</a>';
echo '<a href="connexion_inscription.php" class="text-white mx-2"><i class="fa-regular fa-user"></i> Mon Compte</a>';
if (isset($_SESSION["user_type"])) {
    if ($_SESSION["user_type"] == "client" && isset($_SESSION["nom"])) {
        echo '<h1>Bienvenue, ' . $_SESSION["nom"] . '</h1>';
        echo '<a href="deconnexion.php" class="btn btn-danger mx-2"><i class="fa-regular fa-sign-out"></i> Déconnexion</a>';
    } elseif ($_SESSION["user_type"] == "admin" && isset($_SESSION["nom"])) {
        echo '<h1>Bienvenue, ' . $_SESSION["nom"] . '</h1>';
        echo '<a href="accueil_admin.php" class="text-white mx-2"><i class="fa-solid fa-crown"></i> Espace Admin</a>';
        echo '<a href="deconnexion.php" class="btn btn-danger mx-2"><i class="fa-regular fa-sign-out"></i> Déconnexion</a>';
    }
}
echo '</div>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i> Accueil</a>
                </li>
                <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Catégories
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">';
try {
    $stmt = $dbh->prepare("SELECT id, nom FROM categories");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li><a class="dropdown-item" href="categorie.php?cat_id=' . $row['id'] . '">' . htmlspecialchars($row['nom']) . '</a></li>';
    }
} catch (PDOException $e) {
    echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
}
echo '</ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-bullhorn"></i> Nouveautés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-bolt"></i> Ventes flash</a>
            </li>
        </ul>
    </div>
</div>
</nav>
<div id="categorie-info"></div>';
?>
