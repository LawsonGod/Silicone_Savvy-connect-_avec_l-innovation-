<?php
global $port, $pseudo, $password;
include('fichier_de_configuration.php');

    $dbh = new PDO ("mysql:host=localhost:$port;dbname=projetphp", $pseudo,$password);
//    print_r($dbh);
$dsn =
    "mysql:host=localhost:$port;dbname=projetphp";

try {
    $dbh =
        new PDO($dsn,
            $pseudo,
            $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " .
        $e->getMessage();
    exit();
}