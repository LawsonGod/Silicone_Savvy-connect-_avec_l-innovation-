<?php
function convertirFormatDate($date) {
    // Utilisez la fonction strtotime pour convertir la date en timestamp
    $timestamp = strtotime($date);

    // Utilisez la fonction date pour formater la date dans le nouveau format
    $nouveauFormat = date('d/m/Y', $timestamp);

    return $nouveauFormat;
}

// Exemple d'utilisation de la fonction
//$dateOriginale = '2024-01-15 00:00:00';
//$nouvelleDate = convertirFormatDate($dateOriginale);
//echo $nouvelleDate; // Cela affichera "15/01/2024"

function convertirFormatDateInverse($date) {
    // Utilisez la fonction explode pour diviser la date en jour, mois et année
    $elementsDate = explode('/', $date);

    // Vérifiez si le tableau a les éléments nécessaires (jour, mois et année)
    if (count($elementsDate) !== 3) {
        return false; // Format incorrect
    }

    // Créez une nouvelle date au format "AAAA-MM-JJ 00:00:00"
    $nouveauFormat = $elementsDate[2] . '-' . $elementsDate[1] . '-' . $elementsDate[0] . ' 00:00:00';

    return $nouveauFormat;
}

// Exemple d'utilisation de la fonction
//$dateOriginale = '15/01/2024';
//$nouvelleDate = convertirFormatDateInverse($dateOriginale);
//echo $nouvelleDate; // Cela affichera "2024-01-15 00:00:00"
?>