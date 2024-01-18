<?php
global $dbh;
require 'connect.php';

if (isset($_POST['categorie'])) {
    $categorie = $_POST['categorie'];

    try {
        $stmt = $dbh->prepare(
            "SELECT DISTINCT marques.nom FROM marques 
             JOIN produits ON marques.id = produits.marque_id 
             JOIN categories ON produits.categorie_id = categories.id 
             WHERE categories.nom = :categorie"
        );
        $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
        $stmt->execute();

        $marques = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $html = '<h4>Marques de la catégorie ' . htmlspecialchars($categorie) . '</h4>';
        $html .= '<ul>';
        foreach ($marques as $marque) {
            $html .= '<li>' . htmlspecialchars($marque) . '</li>';
        }
        $html .= '</ul>';

        echo $html;
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
}
?>
