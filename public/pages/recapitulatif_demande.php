<?php
session_start();
include "../../private/api.php";
$api = new API();
$date_demande = date('Y-m-d');
$nom_client = $_SESSION['nom'];
$prenom_client = $_SESSION['prenom'];
$telephone_client = $_SESSION['telephone'];
$adresse_client = $_SESSION['nom_lotissement'];
$rue_travaux = $_SESSION['rue_lotissement'];
$nom_lotissement = $_SESSION['nom_lotissement'];
$commune_travaux = $_SESSION['commune_lotissement'];
$type_branchement = $_SESSION['type_branchement'];
$id_maitre_oeuvre = $_SESSION['maitre_oeuvre']['ID_MAITRE_OEUVRE'];
$id_electricien = $_SESSION['electricien']['ID_ELECTRICIEN'];

$ref_dossier = 'REF' . rand(10440, 9995553);
$id_zei = $_SESSION['zei'];
$zei = $api->selectZEIById($id_zei);
if (isset($_POST['submit'])) {
 $api->insertDemande($ref_dossier, $id_zei);
}

if (isset($_POST['cancel'])) {
 header("location:../pages/index.php");
}

if (isset($_POST['download'])) {
 $_SESSION['success'] = null;
 $api->donwloadPDF(
  $date_demande,
  $nom_client,
  $prenom_client,
  $telephone_client,
  $adresse_client,
  $rue_travaux,
  $nom_lotissement,
  $commune_travaux,
  $type_branchement,
  $_SESSION['maitre_oeuvre'],
  $_SESSION['electricien'],
  $ref_dossier,
  $zei
 );
 // session_destroy();
 // header("location:../pages/index.php");
}

?>
<HTML>

<head>
 <meta charset="utf-8">
 <title>Centre EDF</title>
 <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
 <style>
  table {
   border-collapse: collapse;
   width: 100%;
  }

  td,
  th {
   border: 1px solid black;
   padding: 8px;
   text-align: left;
  }

  th {
   background-color: #f2f2f2;
  }
 </style>
</head>

<body>
 <div class="container col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
  <div class="panel panel-primary margetop60">
   <div class="panel-heading">
    <br>
    <?php if (!empty($_SESSION['success'])) { ?>
     <div class="alert alert-success">
      <?php echo $_SESSION['success'] ?>
     </div>
     <form action="" method="post"> <button type="submit" class="btn btn-success" name="download">
       <span class="glyphicon glyphicon-ok"></span>
       Télécharger la demande
      </button></form>
    <?php } ?>
    <h3>
     <h3><img src="header.png" width="100%"></h3>
     <center>RECAPITULATIF DEMANDE DE BRANCHEMENT ELECTRIQUE</center>
    </h3>
    <h4>
     <center>Date de la demande : <?= date("d/m/Y") ?></center>
    </h4>
   </div>
   <br>
   <table>
    <tr>
     <td>Reference Dossier</td>
     <td><?= $ref_dossier ?></td>
     <td>ZEI de Rattachement</td>
     <td><?= $zei['VILLE_ZEI'] ?></td>
    </tr>
   </table>

   <div class="panel-body">
    <form method="post" action="" class="form">
     </br>
     Nom client : <?= $nom_client ?> <br> <br> Prénom client : <?= $prenom_client ?>
     <hr>

     <table>
      <tr>
       <th>COORDONNEES ACTUELLES</th>
      </tr>
      <tr>
       <td>ADRESSE : <?= $adresse_client ?> <br> TEL : <?= $telephone_client ?></td>
      </tr>
     </table>
     <br>
     <table>
      <tr>
       <th>ADRESSE DES TRAVAUX</th>
      </tr>
      <tr>
       <td>RUE : <?= $rue_travaux ?> <br> NOM LOTISSEMENT : <?= $nom_lotissement ?> <br> COMMUNE : <?= $commune_travaux ?></td>
      </tr>
     </table>
     <br>
     <table>
      <tr>
       <th>TYPE DEMANDE</th>
      </tr>
      <tr>
       <td>TYPE: <?= $type_branchement ?></td>
      </tr>
     </table>

     <br>
     <?php if ($type_branchement == "neuf") { ?>
      <h4>COORDONNEES DES PROFESSIONNELS QUI VONT VOUS ACCOMPAGNER DANS VOTRE PROJET DE CONSTRUCTION</h4>
      <hr>
      <div class="form-group">
       <label for="login">Nom et prénom electricien</label>
       <input type="text" name="nom_electricien" placeholder="Nom et prénom electricien" class="form-control" autocomplete="off" value="<?= $_SESSION['electricien']['NOM_ELECTRICIEN'] ?>" disabled />
       <br>
       <label for="login">Adresse electricien</label>
       <input type="text" name="adresse_electricien" placeholder="Adresse electricien" class="form-control" autocomplete="off" value="<?= $_SESSION['electricien']['ADRESSE_ELECTRICIEN'] ?>" disabled />
       <br>
       <label for="login">Téléphone electricien</label>
       <input type="text" name="telephone_electricien" placeholder="Téléphone electricien" class="form-control" autocomplete="off" value="<?= $_SESSION['electricien']['TEL_ELECTRICIEN'] ?>" disabled />
      </div>
      <hr>
      <div class="form-group">
       <label for="login">Nom et prénom maitre oeuvre</label>
       <input type="text" name="nom_maitre_oeuvre" placeholder="Nom et prénom maitre oeuvre" class="form-control" autocomplete="off" value="<?= $_SESSION['maitre_oeuvre']['NOM_MAITRE_OEUVRE'] ?>" disabled />
       <br>
       <label for="login">Adresse maitre oeuvre</label>
       <input type="text" name="adresse_maitre_oeuvre" placeholder="Adresse maitre oeuvre" class="form-control" autocomplete="off" value="<?= $_SESSION['maitre_oeuvre']['ADRESSE_MAITRE_OEUVRE'] ?>" disabled />
       <br>
       <label for="login">Téléphone maitre oeuvre</label>
       <input type="text" name="telephone_maitre_oeuvre" placeholder="Téléphone maitre oeuvre" class="form-control" autocomplete="off" value="<?= $_SESSION['maitre_oeuvre']['TEL_MAITRE_OEUVRE'] ?>" disabled />
      </div>
     <?php } ?>

     <br>
     <button type="submit" class="btn btn-danger" name="cancel">
      <span class="glyphicon glyphicon-remove-circle"></span>
      Annuler
     </button>
     <button type="submit" class="btn btn-success" name="submit">
      <span class="glyphicon glyphicon-log-in"></span>
      Enregistrez
     </button></br></br>

    </form>
   </div>
  </div>
 </div>
</body>

</HTML>