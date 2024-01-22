<?php
global $dbh;
session_start();
include('connect.php');

// Fonction pour insérer un nouveau client dans la base de données
function inscrireClient($dbh, $new_email, $new_password, $nom, $adresse, $ville, $code_postal, $telephone) {
    try {
        // Vérifier si l'adresse email est déjà utilisée
        $query = $dbh->prepare("SELECT * FROM clients WHERE email = :email");
        $query->execute(['email' => $new_email]);

        if ($query->rowCount() == 0) {
            // Insérer le nouveau client dans la base de données
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

            return true; // L'inscription est réussie.
        } else {
            return false; // L'adresse email est déjà utilisée par un autre utilisateur
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
        return false; // Une erreur s'est produite lors de l'inscription
    }
}

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