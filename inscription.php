<?php
global $dbh;
session_start();
include('connect.php');
require_once ('./inc/outils.php');

if (isset($_POST['new_email'], $_POST['new_password'], $_POST['nom'], $_POST['adresse'], $_POST['ville'], $_POST['code_postal'], $_POST['telephone'])) {
    $new_email = $_POST['new_email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];

    // Appeler la fonction pour inscrire le client
    $inscriptionReussie = inscrireClient($dbh, $new_email, $new_password, $nom, $adresse, $ville, $code_postal, $telephone);

    if ($inscriptionReussie) {
        $_SESSION['user_type'] = 'client';
        $_SESSION['email'] = $new_email;
        $_SESSION['nom'] = $nom;
        header('Location: index.php');
        exit();
    } else {
        echo "L'adresse email est déjà utilisée par un autre utilisateur.";
    }
}
?>