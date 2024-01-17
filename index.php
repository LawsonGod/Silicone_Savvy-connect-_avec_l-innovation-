<?php
    global $dbh;
    session_start();
    include('connect.php');

    $msg = '';
    $orderBy = '';

    if (isset($_POST['tri'])) {
        $orderBy = $_POST['tri'];
    }

    $sql = 'SELECT image, nom, prix FROM produits';
    if ($orderBy == 'asc') {
        $sql .= ' ORDER BY prix ASC';
    } elseif ($orderBy == 'desc') {
        $sql .= ' ORDER BY prix DESC';
    }

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $msg .= '<div class="product-grid">';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $image = $row['image'];
        $nom = $row['nom'];
        $prix = $row['prix'];

        $msg .= '<div class="product">';
        $msg .= "<img src='$image' alt='$nom'>";
        $msg .= "<h3>$nom</h3>";
        $msg .= "<p>Prix : $prix €</p>";
        $msg .= '</div>';
    }
    $msg .= '</div>';

    $dbh = null;
?>
<!DOCTYPE html>
<html lang="en">
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

<div class="container">
    <h2>Liste des Produits</h2>
    <form method="post">
        <label for="tri">Trier par prix :</label>
        <select id="tri" name="tri">
            <option value="asc">Croissant</option>
            <option value="desc">Décroissant</option>
        </select>
        <input type="submit" value="Trier">
    </form>
    <?php
    echo $msg;
    ?>
</div>
</body>
<!-- <?php echo $sql; ?> -->
</html>
