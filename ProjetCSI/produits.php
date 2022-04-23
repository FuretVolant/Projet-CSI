<?php
include('db.php');
$liste = pg_query($conn, "SELECT * FROM produit ORDER BY nomproduit");
$quantite=1;
if(isset($_POST['q'])){
    $quantite=$_POST['q'];
    if(isset($_GET['ajouter'])){
        pg_query($conn, "INSERT INTO panier(idproduit, idclient, quantite) VALUES ('$_GET[id]', '$id', '$quantite')");
        //header("Location:produits.php?id=".$_GET['id']."&added");
    }
}

//problème quand + d'1 produit

/* if(isset($_GET['ajouter'])){
    pg_query($conn, "INSERT INTO panier(idproduit, idclient, quantite) VALUES ('$_GET[id]', '$id', '$quantite')");
    header("Location:produits.php?id=".$_GET['id']."&added");
} */
if(isset($_GET['id'])){
    $query_name = pg_query($conn,"SELECT nomproduit FROM produit WHERE idproduit = '$_GET[id]'");
    $name = pg_fetch_array($query_name);
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
    <form method="post">
        <br>
        <h2>Liste des produits</h2>
        <br>
        <?php if(isset($_GET['added'])){?><h2 style="color:#90EE90"><font size="3">L'article <?=$name[0]?> a bien été ajouté au panier.</font></h2><?php } ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">En stock</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Action</th>
                    <?php if(!isset($statut)){?><th scope="col">Quantité</th><?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($donnees = pg_fetch_array($liste)){
                ?>
                <tr>
                    <td><?= $donnees['nomproduit']; ?></td>
                    <td><?= $donnees['stock']; ?></td>
                    <td><?= $donnees['prix']; ?></td>
                    <?php if(isset($statut)){ if($statut='Responsable'){?><td><a href="produits_modif.php?id=<?=$donnees['idproduit'];?>">Modifier</a></td><?php }}
                    else {?><td><a href="produits.php?id=<?=$donnees['idproduit'];?>&ajouter">Ajouter au panier</a></td>
                    <td>
                        <select name="q" class="form-control" onchange="this.form.submit()">
                            <?php for($i=1; $i<=$donnees['stock']; $i++){?>
                                <option value=<?=$i?> <?php if(isset($_POST['q'])){ if ($_POST['q'] == $i){echo "selected";}}?>><?=$i?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
    </div>
  </div>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>