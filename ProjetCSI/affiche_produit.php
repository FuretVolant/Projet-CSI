<?php
include('db.php');
if(isset($_GET['id'])){
  $idproduit=$_GET['id'];
  $nomproduit = pg_fetch_array(pg_query($conn, "SELECT nomproduit FROM produit where idproduit='$idproduit' "))[0]; 	
  $prix = pg_fetch_array(pg_query($conn, "SELECT prix FROM produit  where idproduit='$idproduit' "))[0];
  $stock = pg_fetch_array(pg_query($conn, "SELECT stock FROM produit  where idproduit='$idproduit' "))[0];
}

if(isset($_POST['ajouter'])){
  header("Location:index.php");
  exit;
  /* $quantite = intval($_POST['quantite']);
  $check_exist = pg_query($conn, "SELECT * FROM panier WHERE idproduit='$idproduit' AND idclient='$id'");
  $check_stock = pg_fetch_array(pg_query($conn, "SELECT stock FROM produit WHERE idproduit='$idproduit'"));
  $stock = $check_stock[0];
  if(pg_num_rows($check_exist) > 0){
    $check_current_quantite = pg_fetch_array(pg_query($conn,"SELECT quantite FROM panier WHERE idproduit='$idproduit' AND idclient='$id'"));
    $current_quantite = $check_current_quantite[0];
    if($current_quantite+$quantite > $stock){
      header("Location:produits.php?id=".intval($idproduit)."&error");
    }
    else{
      pg_query($conn, "UPDATE panier SET quantite=(SELECT quantite FROM panier WHERE idproduit='$idproduit' AND idclient='$id')+$quantite WHERE idproduit='$idproduit' AND idclient='$id'");
      header("Location:produits.php?id=".intval($idproduit)."&added");
    }
  }
  else{
    if($quantite > $stock){
      header("Location:produits.php?id=".intval($idproduit)."&error");
    }
    else{
      pg_query($conn, "INSERT INTO panier(idproduit, idclient, quantite) VALUES ('$idproduit', '$id', '$quantite')");
      header("Location:produits.php?id=".intval($idproduit)."&added");
    }
  } */
}


/* if(isset($_GET['ajouter'])){
    pg_query($conn, "INSERT INTO panier(idproduit, idclient, quantite) VALUES ('$_GET[id]', '$id', '$quantite')");
    header("Location:produits.php?id=".$_GET['id']."&added");
} */


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>ToyS'R'Sus</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/jumbotron/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
     integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    


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
    <link href="jumbotron.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand"><b>ToyS'R'Sus</b></a>
  <li class="navbar-toggler" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </li>
  

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a href="index.php" class="nav-link">Accueil<span class="sr-only">(current)</span></a>
      </li>
      
      <li class="nav-item active">
        <a class="nav-link" href="produits">Tous les produits</a>
      </li>

      <?php if(isset ($statut)){?>
      <li class="nav-item active">
        <a class="nav-link" href="commandes">Commandes</a> 
      </li>
      <?php }?>
      

      <?php if(isset ($statut)){ if($statut=='Responsable'){?>
      <li class="nav-item active">
        <a class="nav-link" href="creation_utilisateur">Créer un utilisateur</a> 
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="clients">Clients</a> 
      </li>
      <?php }}?>

      
    </ul>

    <form class="form-inline my-2 my-lg-0">
      <?php if(isset($_SESSION['email'])){?>
      <?php if(!isset($statut)){?><a href="panier.php?id=<?=$id?>" class="btn btn-outline-success my-2 my-sm-0">Panier</a><?php }?>
      &nbsp;
      <a href="mon_compte.php?id=<?= $id?><?php if(isset($statut)){echo '&?statut='.$statut;}?>" class="btn btn-outline-success my-2 my-sm-0">Mon compte</a>
      &nbsp;
      <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0">Déconnexion</a>
      <?php } else { ?>
      <a href="connexion.php" class="btn btn-outline-success my-2 my-sm-0">Connexion</a>
      &nbsp;
      <a href="inscription.php" class="btn btn-outline-success my-2 my-sm-0">Inscription</a>
      <?php } ?>
    </form>
  </div>
</nav>

<main role="main">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron" style="background-color:#fff;">
    <div class="container">
    <form>
      <br>
      <h2>Présentation du produit</h2>
      <br>

      <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Nom : </label>
    <div class="col-sm-10">
      <input type="text" name="nom" id="nom" class="form-control-plaintext" value="<?=$nomproduit;?>">
    </div>
  </div>

      <div class="form-group row">
    <label class="col-sm-2 col-form-label">Prix : </label>
    <div class="col-sm-10">
      <input type="text" name="prix" id="prix" class="form-control-plaintext" value="<?=$prix;?>">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Stock disponible : </label>
    <div class="col-sm-10">
      <input type="text" name="stock" readonly class="form-control-plaintext" id="stock" value="<?=$stock ?>">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Quantité à ajouter au panier </label>
    <div class="col-sm-10">
      <input type="text" name="quantite" class="form-control" id="quantite">
    </div>
  </div>
  <center><button name="ajouter" type="submit" class="info">Ajouter au panier</button></center>
</form>
  </div>
  </div>

</main>






<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>