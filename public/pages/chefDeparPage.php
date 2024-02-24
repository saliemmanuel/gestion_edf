<?php
//Page Chef de departement
require_once('role.php');
require_once("connexiondb.php");
//recuperation des information de connexion
$login = isset($_GET['login']) ? $_GET['login'] : "";
$size = isset($_GET['size']) ? $_GET['size'] : 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $size;

$requeteUser = "select * from utilisateur where login like '%$login%'";
$requeteCount = "select count(*) countUser from utilisateur";

$resultatUser = $pdo->query($requeteUser);
$resultatCount = $pdo->query($requeteCount);

$tabCount = $resultatCount->fetch();
$nbrUser = $tabCount['countUser'];
$reste = $nbrUser % $size;
if ($reste === 0)
    $nbrPage = $nbrUser / $size;
else
    $nbrPage = floor($nbrUser / $size) + 1;
?>
<! DOCTYPE HTML>
    <HTML>

    <head>
        <meta charset="utf-8">
        <title>Acceuil </title>
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
    </head>

    <body>
        <?php include("header.php"); ?>

        <div class="container">
            <br>
            <br>
            <br> 
            <br><br>
            <div class="panel panel-primary">
                <div class="panel-heading">Acceuil</div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-body">
                    <ul class="nav navbaqr-nav">

                        <?php if ($_SESSION['user']['role'] == 'CD') { ?>
                            <li><a href="pageSalle.php">
                                    <i class="fa fa-magic"></i>
                                    &nbsp Gerer les Salles
                                </a>
                            </li>
                            <li><a href="pageUE.php">
                                    <i class="fa fa-folder-open"></i>
                                    &nbsp Gerer les UE
                                </a>
                            </li>
                            <li><a href="pageEtudiant.php">
                                    <i class="fa fa-users"></i>
                                    &nbsp Gerer les Etudiants
                                </a>
                            </li>

                            <li><a href="#">
                                    <i class="fa fa-file-text-o"></i>
                                    &nbsp Gerer les Resultats
                                </a>
                            </li>
                        <?php } ?>

                        <?php if ($_SESSION['user']['role'] == 'ADMIN') { ?>

                            <li><a href="adminPage.php">
                                    <i class="fa fa-users"></i>
                                    &nbsp Gerer les Utilisteurs
                                </a>
                            </li>

                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>
    </body>

    </HTML>