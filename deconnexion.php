<?php
session_start();

$_SESSION["user_type"] = null;
$_SESSION["nom"] = null;

session_destroy();

header("Location: index.php");
exit;
?>