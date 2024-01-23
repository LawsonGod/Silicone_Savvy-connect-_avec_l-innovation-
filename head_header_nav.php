<?php
global $dbh;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');
echo '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Silicone Savvy</title>
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
    <meta name="description" content="Silicone Savvy, site e-commerce de matériel informatique">
    <meta name="keywords" content="Silicone, Savvy, matériel, informatique, pc, écran, tablette, smartphone">
    <link rel="icon" href="/assets/SiliconeSavvy80.png" type="Logo/jpg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $(\'.dropdown\').hover(function() {
                $(this).find(\'.dropdown-menu\').first().stop(true, true).slideDown();
            }, function() {
                $(this).find(\'.dropdown-menu\').first().stop(true, true).slideUp();
            });
        });
    </script>
</head>
<body>
<header class="bg-dark text-white py-4">
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-md-2"> 
                <img src="./assets/SiliconeSavvy200.png" alt="Logo du Site" class="img-fluid"> 
            </div>
            <div class="col-md-8 text-center"> 
                <h1>Bienvenue sur Silicone Savvy</h1>
            </div>
            <div class="col-md-2 text-end">';
if (isset($_SESSION["user_type"])) {
    echo '<a href="panier.php" class="text-white mx-2"><i class="fa-solid fa-cart-shopping"></i> Panier (0)</a>';
    if ($_SESSION["user_type"] == "client" && isset($_SESSION["nom"])) {
        echo '<h1>Bienvenue, ' . htmlspecialchars($_SESSION["nom"]) . '</h1>';
        echo '<a href="compte_client.php" class="btn btn-primary text-white mx-2"><i class="fa-solid fa-crown"></i> Votre compte</a>';
        echo '<a href="deconnexion.php" class="btn btn-danger mx-2"><i class="fa-regular fa-sign-out"></i> Déconnexion</a>';
    } elseif ($_SESSION["user_type"] == "administrateur" && isset($_SESSION["nom"])) {
        echo '<h1>Connexion administrateur</h1>';
        echo '<a href="admin.php" class="btn btn-primary text-white mx-2"><i class="fa-solid fa-crown"></i> Espace Admin</a>';
        echo '<a href="deconnexion.php" class="btn btn-danger mx-2"><i class="fa-regular fa-sign-out"></i> Déconnexion</a>';
    }
} else {
    echo '<a href="connexion_inscription.php" class="text-white mx-2"><i class="fa-regular fa-user"></i> Connexion/Inscription</a>';
}
echo '</div>
        </div>
    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav w-100">
                <li class="nav-item col">
                    <a class="nav-link large-nav-item" href="index.php"><i class="fa-solid fa-house"></i> Accueil</a>
                </li>
                <li class="nav-item col dropdown">
                    <a class="nav-link large-nav-item dropdown-toggle" href="#" id="navbarDropdownCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Catégories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCategories">';
//echo "Starting execution.<br>";
try {
    $stmt = $dbh->prepare("SELECT id, nom FROM categories");
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        echo "No categories found.<br>";
    } else {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<li><a class="dropdown-item" href="categorie.php?cat_id=' . $row['id'] . '">' . htmlspecialchars($row['nom']) . '</a></li>';
        }
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
//echo "Execution finished.<br>";
echo '                </ul>
                </li>
                <li class="nav-item col dropdown">
                    <a class="nav-link large-nav-item dropdown-toggle" href="#" id="navbarDropdownMarques" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Marques
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMarques">';
                        try {
                            $stmt = $dbh->prepare("SELECT id, nom FROM marques");
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<li><a class="dropdown-item" href="marque.php?marque_id=' . $row['id'] . '">' . htmlspecialchars($row['nom']) . '</a></li>';
                            }
                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
echo '</ul>
                </li>
                <li class="nav-item col">
                    <a class="nav-link large-nav-item" href="promotions.php"><i class="fa-solid fa-bolt"></i> Promotions</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
';
?>