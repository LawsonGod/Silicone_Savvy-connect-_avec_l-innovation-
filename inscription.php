<?php
global $dbh;
session_start();
include('connect.php');

if (isset($_POST['new_email'], $_POST['new_password'], $_POST['nom'], $_POST['adresse'], $_POST['ville'], $_POST['code_postal'], $_POST['telephone'])) {
    try {
        $new_email = $_POST['new_email'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT); // Hash the password
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $code_postal = $_POST['code_postal'];
        $telephone = $_POST['telephone'];

        $query = $dbh->prepare("SELECT * FROM clients WHERE email = :email");
        $query->execute(['email' => $new_email]);

        if ($query->rowCount() == 0) {
            $insertQuery = $dbh->prepare("INSERT INTO clients (nom, email, adresse, ville, code_postal, telephone, mot_de_passe) VALUES (:nom, :email, :adresse, :ville, :code_postal, :telephone, :mot_de_passe)");
            $insertQuery->execute([
                'nom' => $nom,
                'email' => $new_email,
                'adresse' => $adresse,
                'ville' => $ville,
                'code_postal' => $code_postal,
                'telephone' => $telephone,
                'mot_de_passe' => $new_password
            ]);

            $_SESSION['user_type'] = 'client';
            $_SESSION['email'] = $new_email;
            $_SESSION['nom'] = $nom;
            header('Location: index.php');
            exit();
        } else {
            echo "L'adresse email est déjà utilisée par un autre utilisateur.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>
