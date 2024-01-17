<?php
require_once "./inc/outils.php";

session_start();
$role = isset($_SESSION["role"]) ? $_SESSION["role"] : 'anonyme';

try {
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=geographie;port=3306;charset=utf8mb4', 'marco', 'polo');
    $stmt = $dbh->query('SELECT * FROM pays');
    $les_pays = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $nb_pays = count($les_pays);
    $dbh = null;
} catch (Exception $e) {
    $message = $e->getMessage();
    $feedback = alerte($message, 'alert-danger');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiliconeSavvy</title>
    <!-- Bootstrap 5.1 CSS -->
    <link href="./styles/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="./styles/silicone-savvy.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="jumbotron text-center">
        <h1>Accueil du site SiliconeSavvy</h1>
    </div>





</body>
</html>