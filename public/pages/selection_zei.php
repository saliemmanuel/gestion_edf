<?php
session_start();
include "../../private/api.php";
$api = new API();
$list_zei = [];
$list_zei = $api->getListZEI();
$type_branchement = $_SESSION['type_branchement'];
$electricien = $api->selectRandomElectrician();
$maitre_oeuvre = $api->selectRandomMaitreOeuvre();
if (isset($_POST['submit'])) {
 $api->redirectionPagerecapitulatif($electricien, $maitre_oeuvre);
}

if (isset($_POST['cancel'])) {
 header("location:../pages/index.php");
}

if (isset($_SESSION['erreurLogin'])) {
 $erreurLogin = $_SESSION['erreurLogin'];
} else {
 $erreurLogin = "";
}
?>
<HTML>

<head>
 <meta charset="utf-8">
 <title>Centre EDF</title>
 <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="../css/monstyle.css">
</head>

<body>
 <div class="container col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
  <div class="panel panel-primary margetop60">
   <h3><img src="header.png" width="100%"></h3>
   <div class="panel-heading">
    <h3>Choix ZEI</h3>
   </div>
   <div class="panel-body">
    <form method="post" action="" class="form">
     </br>
     <label for="zei">Choisissez la ZEI :</label>
     <select name="zei" id="zei">
      <?php
      foreach ($list_zei as $zei) {
       echo '<option value="' . $zei['ID_ZEI'] . '">' . $zei['VILLE_ZEI'] . '</option>';
      }
      ?>
     </select>
     <hr>
     <?php if ($type_branchement == "neuf") { ?>
      <center>
       <h4>COORDONNEES DES PROFESSIONNELS QUI VOUS ACCOMPAGNENT DANS VOTRE PROJET DE CONSTRUCTION</h4>
      </center>
      <hr>
      <div class="form-group">
       <h4>Electricien</h4>
       <label for="login">Nom et prénom electricien</label>
       <input type="text" name="nom_electricien" placeholder="Nom et prénom electricien" class="form-control" autocomplete="off" value="<?= $electricien['NOM_ELECTRICIEN'] ?>" disabled />
       <br>
       <label for="login">Adresse electricien</label>
       <input type="text" name="adresse_electricien" placeholder="Adresse electricien" class="form-control" autocomplete="off" value="<?= $electricien['ADRESSE_ELECTRICIEN'] ?>" disabled />
       <br>
       <label for="login">Téléphone electricien</label>
       <input type="text" name="telephone_electricien" placeholder="Téléphone electricien" class="form-control" autocomplete="off" value="<?= $electricien['TEL_ELECTRICIEN'] ?>" disabled />
      </div>
      <hr>
      <div class="form-group">
       <h4>Maitre oeuvre</h4>
       <label for="login">Nom et prénom maitre oeuvre</label>
       <input type="text" name="nom_maitre_oeuvre" placeholder="Nom et prénom maitre oeuvre" class="form-control" autocomplete="off" value="<?= $maitre_oeuvre['NOM_MAITRE_OEUVRE'] ?>" disabled />
       <br>
       <label for="login">Adresse maitre oeuvre</label>
       <input type="text" name="adresse_maitre_oeuvre" placeholder="Adresse maitre oeuvre" class="form-control" autocomplete="off" value="<?= $maitre_oeuvre['ADRESSE_MAITRE_OEUVRE'] ?>" disabled />
       <br>
       <label for="login">Téléphone maitre oeuvre</label>
       <input type="text" name="telephone_maitre_oeuvre" placeholder="Téléphone maitre oeuvre" class="form-control" autocomplete="off" value="<?= $maitre_oeuvre['TEL_MAITRE_OEUVRE'] ?>" disabled />
      </div>
     <?php } ?>
     <br>
     <button type="submit" class="btn btn-danger" name="cancel">
      <span class="glyphicon glyphicon-remove-circle"></span>
      Annuler
     </button>
     <button type="submit" class="btn btn-success" name="submit">
      <span class="glyphicon glyphicon-log-in"></span>
      Suivant
     </button></br></br>

    </form>
   </div>
  </div>
 </div>
</body>

</HTML>