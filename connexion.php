<?php
// Inclusion du fichier de connexion à la base de données et initialisation de la session
global $dbh;
session_start();
include('connect.php');

// Fonction pour gérer l'authentification
function login($dbh, $email, $password, $table, $userType) {
    // Préparation de la requête SQL pour récupérer l'utilisateur par son email
    $query = $dbh->prepare("SELECT * FROM $table WHERE email = :email");
    $query->execute(['email' => $email]);

    // Vérification s'il y a un résultat
    if ($query->rowCount() == 1) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        // Vérification du mot de passe en utilisant la fonction password_verify
        if (password_verify($password, $user['mot_de_passe'])) {
            // Réinitialisation de l'ID de session pour des raisons de sécurité
            session_regenerate_id();
            $_SESSION['user_type'] = $userType;
            $_SESSION['client_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $user['nom'];

            // Stockage des informations spécifiques à l'utilisateur (client ou administrateur)
            if ($userType === 'client') {
                $_SESSION['alias'] = $user['alias'];
                $_SESSION['adresse'] = $user['adresse'];
                $_SESSION['ville'] = $user['ville'];
                $_SESSION['code_postal'] = $user['code_postal'];
                $_SESSION['telephone'] = $user['telephone'];
                $_SESSION['date_enregistrement'] = $user['date_enregistrement'];
            } else if ($userType === 'administrateur') {
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $email;
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['derniere_connexion'] = $user['derniere_connexion'];
            }

            // Redirection vers la page d'accueil après une connexion réussie
            header('Location: index.php');
            exit;
        }
    }
    // Si l'authentification échoue, la fonction retourne false
    return false;
}

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