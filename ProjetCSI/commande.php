<?php
include('db.php');

$liste = pg_query($conn, "SELECT * FROM produit ORDER BY nomproduit");

if (isset($_GET['quantite'])) {
    $idproduit = intval($_GET['id']);
    $quantite = intval($_GET['quantite']);
    $check_exist = pg_query($conn, "SELECT * FROM panier WHERE idproduit='$idproduit' AND idclient='$id'");
    $check_stock = pg_fetch_array(pg_query($conn, "SELECT stock FROM produit WHERE idproduit='$idproduit'"));
    $stock = $check_stock[0];
    if (pg_num_rows($check_exist) > 0) {
        $check_current_quantite = pg_fetch_array(pg_query($conn, "SELECT quantite FROM panier WHERE idproduit='$idproduit' AND idclient='$id'"));
        $current_quantite = $check_current_quantite[0];
        if ($current_quantite + $quantite > $stock) {
            header("Location:produits.php?id=" . intval($idproduit) . "&error");
        } else {
            pg_query($conn, "UPDATE panier SET quantite=(SELECT quantite FROM panier WHERE idproduit='$idproduit' AND idclient='$id')+$quantite WHERE idproduit='$idproduit' AND idclient='$id'");
            header("Location:produits.php?id=" . intval($idproduit) . "&added");
        }
    } else {
        if ($quantite > $stocl) {
            header("Location:produits.php?id=" . intval($idproduit) . "&error");
        } else {
            pg_query($conn, "INSERT INTO panier(idproduit, idclient, quantite) VALUES ('$idproduit', '$id', '$quantite')");
            header("Location:produits.php?id=" . intval($idproduit) . "&added");
        }
    }
}

if (isset($_GET['create'])){
    $sql = "insert into commande(dateretrait, horaireretrait, montantcommande, quai, preparateur, livreur, client)  values(to_date('27/04/2022', 'DD/MM/YYYY'), '15:00', 229.96, 1, 1, 1, $id)";
    pg_query($conn, $sql);
}

if (isset($_GET['added']) || isset($_GET['error'])) {
    $nomproduit = pg_fetch_array(pg_query($conn, "SELECT nomproduit FROM produit WHERE idproduit = '$_GET[id]'"));
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
    <link href="jumbotron.css" rel="stylesheet">
</head>

<body class="text-center">
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand"><b>ToyS'R'Sus</b></a>
    <li class="navbar-toggler" data-toggle="collapse" data-target="#navbarsExampleDefault"
        aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
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

            <?php if (isset ($statut)) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="commandes.php">Commandes</a>
                </li>
            <?php } ?>


            <?php if (isset ($statut)) {
                if ($statut == 'Responsable') { ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="creation_utilisateur">Créer un utilisateur</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="clients">Clients</a>
                    </li>
                <?php }
            } ?>
        </ul>

        <form class="form-inline my-2 my-lg-0">
            <?php if (isset($_SESSION['email'])) { ?>
                <?php if (!isset($statut)) { ?><a href="panier.php?id=<?= $id ?>"
                                                  class="btn btn-outline-success my-2 my-sm-0">Panier</a><?php } ?>
                &nbsp;
                <a href="mon_compte.php?id=<?= $id ?><?php if (isset($statut)) {
                    echo '&?statut=' . $statut;
                } ?>" class="btn btn-outline-success my-2 my-sm-0">Mon compte</a>
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
            <form method="POST">
                <br>
                <h2>Ma commande</h2>
                <br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Total</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sqlitems = "SELECT pr.nomproduit, pa.quantite, pr.prix, pr.idproduit FROM Produit pr, Panier pa WHERE pr.idproduit = pa.idproduit AND pa.idclient='$id'";
                    $items = pg_query($conn, $sqlitems);
                    $total = 0;
                    $nb = 0;
                    while ($row = pg_fetch_assoc($items)): ?>
                        <tr>
                            <td><?= $row['nomproduit'] ?></td>
                            <td><?= $row['prix'] ?></td>
                            <td><?= $row['quantite']; ?></td>
                            <td><?= $row['quantite'] * $row['prix'] ?></td>
                            <td><a href="panier.php?id=<?= $row['idproduit'];?>&delete">Supprimer</a></td>
                        </tr>
                        <?php $total += $row['quantite'] * $row['prix'];
                        $nb += $row['quantite']; endwhile; ?>
                    </tbody>
                </table>
                <select class="form-select" id="date" name="date">
                    <option selected>Sélectionnez une date</option>
                    <option value="27/04/2022">27/04/2022</option>
                </select>
                <select class="form-select" id="heure" name="heure">
                    <option selected>Sélectionnez un horaire</option>
                    <option value="11:00">11:00</option>
                </select>
                <h2><font size="3"> Total de la commande : <?= $total ?>€</font></h2>
                <h2><font size="3"> Nombre de produits commandés : <?= $nb ?></font></h2>
                <?php if(!isset($_GET['create'])):?>
                <center><a class="btn btn-primary" type="submit" href="commande.php?create">Valider la commande</a></center>
                <?php endif ?>
            </form>
        </div>
    </div>
</main>


</body>

</html>