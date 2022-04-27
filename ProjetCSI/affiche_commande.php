<?php
include('db.php');
$etat=null;
$quai=null;

if(isset($_GET['id'])){
  $idcommande=$_GET['id'];
  $idclient = pg_fetch_array(pg_query($conn, "SELECT client FROM commande where idcommande='$idcommande'"))[0]; 	
  $nomclient = pg_fetch_array(pg_query($conn,"SELECT nomclient FROM client WHERE idclient='$idclient'"))[0];
  $montant = pg_fetch_array(pg_query($conn, "SELECT montantcommande FROM commande  where idcommande='$idcommande' "))[0];
  $liste = pg_query($conn, "SELECT * FROM estcommande WHERE idcommande='$idcommande'");
  $etat = pg_fetch_array(pg_query($conn, "SELECT etatcommande FROM commande WHERE idcommande='$idcommande'"))[0];
  $preparateur = pg_fetch_array(pg_query($conn, "SELECT preparateur FROM commande WHERE idcommande='$idcommande'"))[0];
}

if(isset($_POST['etat'])){
    $etat = $_POST['etat'];
    pg_query($conn, "UPDATE commande SET etatcommande='$etat' WHERE idcommande ='$idcommande'");
    if($etat=='En préparation'){
        pg_query($conn,"UPDATE commande SET preparateur='$id' WHERE idcommande='$idcommande'");
    }

    if($etat=='Prête'){
        while($donnees = pg_fetch_array($liste)){
            pg_query($conn, "UPDATE produit SET stock=(SELECT stock FROM produit WHERE idproduit='$donnees[idproduit]')-'$donnees[quantite]' WHERE idproduit = '$donnees[idproduit]'");
        }
    }

    if($etat=='Livrée'){
        pg_query($conn, "UPDATE commande SET livreur='$id' WHERE idcommande='$idcommande'");
        pg_query($conn, "UPDATE client SET points=$montant/10 WHERE idclient='$id'");
        pg_query($conn, "UPDATE commande SET horaireretraitrelle=NOW() WHERE idcommande='$idcommande'");
    }
}

if(isset($_POST['quai'])){
    $quai=$_POST['quai'];
    pg_query($conn,"UPDATE commande SET quai='$quai' WHERE idcommande='$idcommande'");
}

if(isset($_POST['Payer'])){
    pg_query($conn, "UPDATE commande SET etatcommande='Payée' WHERE idcommande='$idcommande'");
}

if(isset($_POST['Annuler'])){
    pg_query($conn, "UPDATE commande SET etatcommande='Annulée' WHERE idcommande='$idcommande'");
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
        <a class="nav-link" href="produits.php">Tous les produits</a>
      </li>

      <?php if(isset ($statut)){?>
      <li class="nav-item active">
        <a class="nav-link" href="commandes.php">Commandes</a>
      </li>
      <?php }?>
      

      <?php if(isset ($statut)){ if($statut=='Responsable'){?>
      <li class="nav-item active">
        <a class="nav-link" href="creation_utilisateur.php">Créer un utilisateur</a> 
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="clients.php">Clients</a> 
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
    <form method='POST'>
      <br>
      <h2>Commande <?=$idcommande?></h2>
      <br>

      <div class="form-group row">
    <label class="col-sm-2 col-form-label">Client : </label>
    <div class="col-sm-10">
      <input type="text" name="client" id="client" class="form-control-plaintext" value="<?=$nomclient;?>">
    </div>

    <label class="col-sm-2 col-form-label">ID : </label>
    <div class="col-sm-10">
      <input type="text" name="idclient" id="idclient" class="form-control-plaintext" value="<?=$idclient;?>">
    </div>
  </div>
  <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col>">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($donnees = pg_fetch_array($liste)){
                ?>
                <tr><td><?= $donnees['idproduit'];?></td>
                    <td><?= pg_fetch_array(pg_query($conn,"SELECT nomproduit FROM produit WHERE idproduit='$donnees[idproduit]'"))[0];?></td>
                    <td><?= $donnees['quantite']; ?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
  
        <div class="form-group row">
    <label class="col-sm-2 col-form-label">Montant : </label>
    <div class="col-sm-10">
      <input type="text" name="montant" id="montant" class="form-control-plaintext" value="<?=$montant;?>">
    </div>
  </div>

  <?php if(isset($statut)){?>
  <div class="col-sm-10">
            <label class="col-sm-2 col-form-label">Etat : </label>
            <select name="etat" id="etat" class="form-control" onchange="this.form.submit()">
            <?php switch($etat) {
                case 'Payée' : ?>
                    <option value="Payée" selected>Payée</option>
                    <option value="En préparation">En préparation</option>
                <?php  break;


                case 'En préparation' : ?>
                    <option value="En préparation" selected>En préparation</option>
                    <option value="Prête">Prête</option>
                <?php  break;

                case 'Prête' : ?>
                    <option value="Prête" selected>Prête</option>
                    <?php if ($preparateur != $id){ ?><option value="Livrée">Livrée</option> <?php } ?>
                <?php break;

                default : ?>
                    <option value="<?=$etat;?>"><?=$etat?></option>
                <?php break;
            }?>
            </select>
        </div>
        <?php } 
        else{ ?>
            <label class="col-sm-2 col-form-label">Etat : </label>
            <div class="col-sm-10">
             <input readonly type="text" name="etatclient" class="form-control" id="etatclient" value=<?=$etat?>>
            </div>
            <?php if($etat=='Soumise'){?>
            <center><button name="Payer" type="submit" class="info">Payer</button></center>
            <center><button name="Annuler" type="submit" class="info">Annuler</button></center>
            <?php } ?>
        <?php } ?>
</form>
  </div>
  </div>

</main>






<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>