<?php
global $dbh;
require 'connect.php';
require_once ('./inc/outils.php');

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
