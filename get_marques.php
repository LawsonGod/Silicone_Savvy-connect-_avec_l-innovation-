<?php
global $dbh;
require 'connect.php';

// Fonction pour récupérer les marques d'une catégorie
function getMarquesByCategorie($dbh, $categorie) {
    try {
        $stmt = $dbh->prepare(
            "SELECT DISTINCT marques.nom FROM marques 
             JOIN produits ON marques.id = produits.marque_id 
             JOIN categories ON produits.categorie_id = categories.id 
             WHERE categories.nom = :categorie"
        );
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        return [];
    }
}

if (isset($_POST['categorie'])) {
    $categorie = $_POST['categorie'];

    // Appel de la fonction pour obtenir les marques
    $marques = getMarquesByCategorie($dbh, $categorie);

    $html = '<h4>Marques de la catégorie ' . htmlspecialchars($categorie) . '</h4>';
    $html .= '<ul>';
    foreach ($marques as $marque) {
        $html .= '<li>' . htmlspecialchars($marque) . '</li>';
    }
    $html .= '</ul>';

    echo $html;
}
?>
