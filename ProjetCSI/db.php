<?php
session_start();

//Connexion à la BDD
$dbhost = "localhost";
$dbuser = "postgres";
$dbpswd = "root";
$dbname = "projetCSI";
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpswd") or die ("Impossible de se connecter au serveur\n");

// Si l'utilisateur est connecté, on récupère ses informations
if(isset($_SESSION['email'])){

    // Vérifie si l'utilisateur est un client
    $sqlidclient = "SELECT idClient FROM Client WHERE mailclient='$_SESSION[email]'";
    $idUtilisateur = pg_query($conn, $sqlidclient);
    $nb_rows = pg_num_rows($idUtilisateur);
    if ($nb_rows == 1){ // Si c'est un client
        while($row = pg_fetch_assoc($idUtilisateur)){
            $id = $row['idclient'];
        }

        $sqlprenom = "SELECT prenomclient FROM Client WHERE mailclient='$_SESSION[email]'";
        $prenomutilisateur = pg_query($conn, $sqlprenom);
        while ($row = pg_fetch_assoc($prenomutilisateur)){
        $prenom = $row['prenomclient'];
        }

        $sqlnom = "SELECT nomclient from Client WHERE mailclient='$_SESSION[email]'";
        $nomutilisateur = pg_query($conn, $sqlnom);
        while ($row = pg_fetch_assoc($nomutilisateur)){
        $nom = $row['nomclient'];
        }

        $sqlmdp = "SELECT mdpclient FROM Client WHERE mailclient='$_SESSION[email]'";
        $mdputilisateur = pg_query($conn, $sqlmdp);
        while($row = pg_fetch_assoc($mdputilisateur)){
            $mdp=$row['mdpclient'];
        }
    }

    else{ // Si c'est un employé
        $sqlidemploye = "SELECT idemploye FROM employe WHERE mailemploye='$_SESSION[email]'";
        $idUtilisateur = pg_query($conn,$sqlidemploye);
        while($row = pg_fetch_assoc($idUtilisateur)){
            $id = $row['idemploye'];
        }
        $sqlprenom = "SELECT prenomemploye FROM Employe WHERE mailEmploye='$_SESSION[email]'";
        $prenomutilisateur = pg_query($conn, $sqlprenom);
        while ($row = pg_fetch_assoc($prenomutilisateur)){
            $prenom = $row['prenomemploye'];
        }

        $sqlnom = "SELECT nomemploye FROM Employe WHERE mailEmploye='$_SESSION[email]'";
        $nomutilisateur = pg_query($conn, $sqlnom);
        while ($row = pg_fetch_assoc($nomutilisateur)){
        $nom = $row['nomemploye'];
        }

        $sqlstatut = "SELECT statutemploye FROM Employe WHERE mailEmploye='$_SESSION[email]'";
        $statututilisateur = pg_query($conn, $sqlstatut);
        while ($row = pg_fetch_assoc($statututilisateur)){
        $statut = $row['statutemploye'];
        }

        $sqlmdp = "SELECT mdpemploye FROM Employe WHERE mailemploye='$_SESSION[email]'";
        $mdputilisateur = pg_query($conn, $sqlmdp);
        while($row = pg_fetch_assoc($mdputilisateur)){
            $mdp=$row['mdpemploye'];
        }
    }
}
?>

