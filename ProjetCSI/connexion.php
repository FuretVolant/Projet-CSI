<?php 
include('db.php');

// Si l'utilisateur est déjà connecté, il est renvoyé à l'accueil
if(isset($_SESSION['email'])){
  header('Location: index.php');
  exit;
}

// Après le clic sur le bouton connexion
if(isset($_POST['submit'])){
    
  //Récupération des identifiants
  $mail = $_POST['inputEmail'];
  $password = $_POST['inputPassword'];
  
  // Vérification de l'existence d'un client avec ces identifiants
  $SQL = pg_query($conn, "SELECT * FROM Client WHERE mailClient= '$mail' AND mdpClient= '$password'");
  $nb_rows = pg_num_rows($SQL);
  if($nb_rows > 0)
  {
    // Connexion du client et accès à l'accueil
    $_SESSION['email']= $mail;
    header("Location: index.php");
    exit;
  }
  else
  {
    // Vérification de l'existence d'un employé avec ces identifiants
    $SQL2 = pg_query($conn, "SELECT * FROM Employe WHERE mailEmploye= '$mail' AND mdpEmploye= '$password'");
    $nb_rows2 = pg_num_rows($SQL2);
    if($nb_rows2 > 0)
    {
      // Connexion de l'employé et accès à l'accueil
      $_SESSION['email']= $mail;
      header("Location: index.php");
      exit;
    }
    else{
      // Si aucun compte existant ne correspond à ces identifiants
      header("Location: connexion.php?invalid");
      exit;
    }
  }
}

 ?>

<!doctype html>
<html lang="en">

    
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    
    <title>Connexion</title>

    

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
     integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="POST">
        <h1 class="h3 mb-3 font-weight-normal"><font size="24"><a href="index.php"><b>ToyS'R'Sus</b></a></font></h1>
        <h1 class="h3 mb-3 font-weight-normal">Veuillez vous connecter</h1>
        <?php if (isset($_GET['invalid'])){ ?> <h1 class="h3 mb-3 font-weight-normal" style="color:#FF0000"><font size="3">Adresse mail ou mot de passe incorrect</font></h1><?php } ?>
        <label for="inputEmail" class="sr-only">Adresse mail</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Adresse mail" required autofocus>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Mot de passe" required>
        <div class="checkbox mb-3">
        
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Connexion</button>
        <h5 class="h3 mb-3 font-weight-normal"><font size="3">Vous n'avez pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a></font></h5>
        
    </form>



</body>

</html>
