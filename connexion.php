<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=projetphp;charset=utf8', 'root', '');
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
        $user = $query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_type'] = 'client';
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['alias'] = $user['alias'];
        $_SESSION['adresse'] = $user['adresse'];
        $_SESSION['ville'] = $user['ville'];
        $_SESSION['code_postal'] = $user['code_postal'];
        $_SESSION['telephone'] = $user['telephone'];
        $_SESSION['date_enregistrement'] = $user['date_enregistrement'];
        header('Location: accueil_client.php');
        exit();
    }

    $query = $bdd->prepare("SELECT * FROM administrateurs WHERE email = :email AND mot_de_passe = :password");
    $query->execute(array(
        'email' => $email,
        'password' => $password
    ));

    if ($query->rowCount() == 1) {
        $admin = $query->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user_type'] = 'administrateur';
        $_SESSION['email'] = $email;
        $_SESSION['nom'] = $admin['nom'];
        $_SESSION['role'] = $admin['role'];
        $_SESSION['derniere_connexion'] = $admin['derniere_connexion'];
        setcookie("admin_username", $email, time() + 3600 * 24 * 30, "/");
        header('Location: accueil_admin.php');
        exit();
    }

    echo "L'utilisateur n'existe pas ou les informations d'identification sont incorrectes.";
}
?>
