<?php
// Démarrage de la session
global $dbh;
session_start();

// Inclusion du fichier de connexion à la base de données
include('connect.php');
include('inc/outils.php');

// Récupération de l'identifiant du client à partir de la session
$client_id = isset($_SESSION['client_id']) ? $_SESSION['client_id'] : null;

// Vérification si l'utilisateur est connecté en tant que client
if (!$client_id) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: login.php');
    exit();
}

// Récupération des informations actuelles du client depuis la base de données
$stmtClient = $dbh->prepare("SELECT * FROM clients WHERE id = :client_id");
$stmtClient->bindParam(':client_id', $client_id, PDO::PARAM_INT);
$stmtClient->execute();
$clientInfo = $stmtClient->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données soumises
    $nom = $_POST['nom'];
    $alias = $_POST['alias'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $telephone = $_POST['telephone'];
    $nouveau_mot_de_passe = $_POST['nouveau_mot_de_passe'];

    // Vérifier si le nouveau mot de passe a été saisi
    if (!empty($nouveau_mot_de_passe)) {
        // Hacher le nouveau mot de passe
        $mot_de_passe_hache = password_hash($nouveau_mot_de_passe, PASSWORD_DEFAULT);

        // Mettre à jour les informations du client avec le nouveau mot de passe
        $stmtUpdate = $dbh->prepare("UPDATE clients SET
            nom = :nom,
            alias = :alias,
            email = :email,
            adresse = :adresse,
            ville = :ville,
            code_postal = :code_postal,
            telephone = :telephone,
            mot_de_passe = :mot_de_passe
            WHERE id = :client_id");

        $stmtUpdate->bindParam(':mot_de_passe', $mot_de_passe_hache, PDO::PARAM_STR);
    } else {
        // Mettre à jour les informations du client sans changer le mot de passe
        $stmtUpdate = $dbh->prepare("UPDATE clients SET
            nom = :nom,
            alias = :alias,
            email = :email,
            adresse = :adresse,
            ville = :ville,
            code_postal = :code_postal,
            telephone = :telephone
            WHERE id = :client_id");
    }

    $stmtUpdate->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':ville', $ville, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':code_postal', $code_postal, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':client_id', $client_id, PDO::PARAM_INT);

    if ($stmtUpdate->execute()) {
        // Rediriger vers la page compte_client.php après la mise à jour
        header('Location: compte_client.php');
        exit();
    } else {
        echo "Erreur lors de la mise à jour des informations du client : " . $stmtUpdate->errorInfo()[2];
    }
}
?>
<?php include('head_header_nav.php'); ?>
<div class="container">
    <h2>Éditer les informations du compte</h2>
    <form method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($clientInfo['nom']) ?>">
        </div>
        <div class="form-group">
            <label for="alias">Alias</label>
            <input type="text" class="form-control" id="alias" name="alias" value="<?= htmlspecialchars($clientInfo['alias']) ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($clientInfo['email']) ?>">
        </div>
        <div class="form-group">
            <label for="adresse">Adresse</label>
            <textarea class="form-control" id="adresse" name="adresse"><?= htmlspecialchars($clientInfo['adresse']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" value="<?= htmlspecialchars($clientInfo['ville']) ?>">
        </div>
        <div class="form-group">
            <label for="code_postal">Code Postal</label>
            <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?= htmlspecialchars($clientInfo['code_postal']) ?>">
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" value="<?= htmlspecialchars($clientInfo['telephone']) ?>">
        </div>
        <div class="form-group">
            <label for="nouveau_mot_de_passe">Mot de Passe</label>
            <input type="password" class="form-control" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe" placeholder="Nouveau mot de passe ou laissez vide pour ne pas changer">
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="compte_client.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php include('footer.php'); ?>