<?php
global $dbh;
require 'connect.php';
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
                <div class="text-end">
                    <a href="panier.php" class="text-white mx-2"><i class="fa-solid fa-cart-shopping"></i> Panier (0)</a>
                    <a href="connexion_inscription.php" class="text-white mx-2"><i class="fa-regular fa-user"></i> Mon Compte</a>
                </div>
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

echo '            </ul>
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
<script>
    $(document).ready(function() {
        $(".nav-item").hover(function() {
            var categorie = $(this).find("a.nav-link").text();

            if (categorie === 'Catégories') {
                $.ajax({
                    url: "get_marques.php",
                    method: "POST",
                    data: {categorie: categorie},
                    success: function(response) {
                        $("#categorie-info").html(response);
                    }
                });
            }
        }, function() {
            if ($(this).find("a.nav-link").text() === 'Catégories') {
                $("#categorie-info").empty();
            }
        });
    });
</script>
