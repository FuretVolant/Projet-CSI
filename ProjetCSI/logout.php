<?php
//Permet la suppression de la session active suite à la déconnexion
include("db.php");
session_unset();
session_destroy();
header('Location: connexion.php');
exit;
?>