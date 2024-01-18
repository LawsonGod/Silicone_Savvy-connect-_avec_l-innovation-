<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees;charset=utf8', 'votre_utilisateur', 'votre_mot_de_passe');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $bdd->prepare("SELECT * FROM clients WHERE email = :email AND mot_de_passe = :password");
    $query->execute(array(
        'email' => $email,
        'password' => $password
    ));

    if ($query->rowCount() == 1) {
        $_SESSION['user_type'] = 'client';
        $_SESSION['email'] = $email;
        header('Location: accueil_client.php');
        exit();
    }

    $query = $bdd->prepare("SELECT * FROM administrateurs WHERE email = :email AND mot_de_passe = :password");
    $query->execute(array(
        'email' => $email,
        'password' => $password
    ));

    if ($query->rowCount() == 1) {
        $_SESSION['user_type'] = 'administrateur';
        $_SESSION['email'] = $email;
        header('Location: accueil_admin.php');
        exit();
    }

    echo "L'utilisateur n'existe pas ou les informations d'identification sont incorrectes.";
}
?>

