<?php
// Démarrage de la session, nécessaire pour gérer les sessions utilisateur
session_start();

// Supprime les données de session spécifiques que vous souhaitez effacer
$_SESSION["user_type"] = null; // Efface le type d'utilisateur
$_SESSION["nom"] = null; // Efface le nom de l'utilisateur

// Détruit complètement la session, ce qui supprime toutes les données de session
session_destroy();

// Redirection vers la page d'accueil (index.php) après avoir terminé les opérations de session
header("Location: index.php");

// Termine le script PHP et arrête son exécution
exit;
?>