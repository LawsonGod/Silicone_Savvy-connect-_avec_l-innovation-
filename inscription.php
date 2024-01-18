<?php
session_start();

if (isset($_POST['new_email']) && isset($_POST['new_password']) && isset($_POST['nom']) && isset($_POST['adresse']) && isset($_POST['ville']) && isset($_POST['code_postal']) && isset($_POST['telephone'])) {
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=projetphp;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $query = $bdd->prepare("SELECT * FROM clients WHERE email = :email");
    $query->execute(array('email' => $new_email));

    if ($query->rowCount() == 0) {
        $insertQuery = $bdd->prepare("INSERT INTO clients (nom, email, adresse, ville, code_postal, telephone, mot_de_passe) VALUES (:nom, :email, :adresse, :ville, :code_postal, :telephone, :mot_de_passe)");
        $insertQuery->execute(array(
            'nom' => $nom,
            'email' => $new_email,
            'adresse' => $adresse,
            'ville' => $ville,
            'code_postal' => $code_postal,
            'telephone' => $telephone,
            'mot_de_passe' => $new_password
        ));

        if ($insertQuery) {
            $_SESSION['user_type'] = 'client';
            $_SESSION['email'] = $new_email;
            $_SESSION['nom'] = $nom;
            header('Location: accueil_client.php');
            exit();
        } else {
            echo "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    } else {
        echo "L'adresse email est déjà utilisée par un autre utilisateur.";
    }
}
?>
