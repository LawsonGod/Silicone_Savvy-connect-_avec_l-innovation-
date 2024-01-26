<?php
// Inclusion du fichier de connexion à la base de données et initialisation de la session
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

// Vérification de la soumission du formulaire
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Tentative de connexion en tant que client
    if (!login($dbh, $email, $password, 'clients', 'client')) {
        // Si l'authentification en tant que client échoue, tentative de connexion en tant qu'administrateur
        if (!login($dbh, $email, $password, 'administrateurs', 'administrateur')) {
            echo "L'adresse email ou le mot de passe est incorrect.";
        }
    }
}
?>