<?php 
include('db.php');
// Si l'utilisateur est déjà connecté, il est renvoyé à l'accueil
if(isset($_SESSION['email'])){
  header('Location: index.php');
  exit;
}

// Après clic sur le bouton inscription
if(isset($_POST['submit'])){
  // Récupérations des identifiants
  $prenom = $_POST['inputPrenom'];
  $nom = $_POST['inputNom'];
  $mail = $_POST['inputEmail'];
  $password = $_POST['inputPassword'];
  $password2 = $_POST['inputPassword2'];
  
  // Vérification de l'existence d'un compte avec ce mail
  $mailcheck = pg_num_rows(pg_query($conn, "SELECT idClient FROM Client WHERE mailClient='$mail'"));
  if($mailcheck > 0){ // Si un compte est déjà créé avec cette adresse mail
    header("Location : inscription.php?invalidmail");
    exit;
  }
  else{
    if ($password==$password2){ // Insertion si les mots de passes sont identiques
      $insert_query = pg_query($conn, "INSERT INTO Client(nomclient, prenomclient, mailclient, mdpclient) 
      VALUES ('$nom', '$prenom', '$mail', '$password')");
      header("Location: connexion.php");
      exit;
    }else{// Si les mots de passes sont différents
      header("Location: inscription.php?invalidpw");
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
        <h1 class="h3 mb-3 font-weight-normal">Inscription</h1>
        <?php if (isset($_GET['invalidmail'])){ ?> <h1 class="h3 mb-3 font-weight-normal" style="color:#FF0000"><font size="3">L'adresse mail est déjà associée à un compte</font></h1><?php }
        else if (isset($_GET['invalidpw'])){?> <h1 class="h3 mb-3 font-weight-normal" style="color:#FF0000"><font size="3">Les mots de passes doivent être identiques</font></h1><?php } ?>
        <label for="inputPrenom" class="sr-only">Prénom</label>
        <input type="text" id="inputPrenom" name="inputPrenom" class="form-control" placeholder="Prénom" required autofocus>
        <label for="inputNom" class="sr-only">Nom</label>
        <input type="text" id="inputNom" name="inputNom" class="form-control" placeholder="Nom" required>
        <label for="inputEmail" class="sr-only">Adresse mail</label>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Adresse mail" required>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Mot de passe" required>
        <label for="inputPassword2" class="sr-only">Confirmer le mot de passe</label>
        <input type="password" id="inputPassword2" name="inputPassword2" class="form-control" placeholder="Confirmer le mot de passe" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Inscription</button>
        <h5 class="h3 mb-3 font-weight-normal"><font size="3">Vous avez déjà un compte ? <br><a href="connexion.php">Connectez-vous</a></font></h5>
        
    </form>



</body>

</html>
