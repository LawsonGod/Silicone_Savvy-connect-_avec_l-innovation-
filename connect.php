<?php
    $pseudo = 'root';
    $password = 'root';
    $dbh = new PDO ('mysql:host=localhost:8889;dbname=projetphp', $pseudo,$password);
//    print_r($dbh);
$dsn =
    'mysql:host=localhost:8889;dbname=projetphp';

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
}
