<?php
global $dbh;
session_start();
include('connect.php');

function login($dbh, $email, $password, $table, $userType) {
    $query = $dbh->prepare("SELECT * FROM $table WHERE email = :email");
    $query->execute(['email' => $email]);

    if ($query->rowCount() == 1) {
        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['mot_de_passe'])) {
            session_regenerate_id();
            $_SESSION['user_type'] = $userType;
            $_SESSION['client_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['nom'] = $user['nom'];

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

            header('Location: index.php');
            exit;
        }
    }
    return false;
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!login($dbh, $email, $password, 'clients', 'client')) {
        if (!login($dbh, $email, $password, 'administrateurs', 'administrateur')) {
            echo "L'adresse email ou le mot de passe est incorrect.";
        }
    }
}
?>
