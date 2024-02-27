<?php
session_start();
include "../../private/api.php";
if (isset($_POST['submit'])) {

 $api = new API();
 $api->redirectionPageSelectionZEI();
}

if (isset($_POST['cancel'])) {
 header("location:../pages/index.php");
}
$montant = "";
//estimation devis
$type_branchement = $_SESSION['type_branchement'];
if ($type_branchement == "neuf") {
 $montant = "10000";
}
if ($type_branchement == "provisoire") {
 $montant = "5000";
}
if ($type_branchement == "modification") {
 $montant = "3000";
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
   <div class="panel-heading">
    <h3><img src="header.png" width="100%"></h3>

    <h3>Votre dévis est le suivant</h3>
   </div>
   <div class="panel-body">
    <form method="post" action="" class="form">
     </br>
     <div class="form-group">
      <label for="login">Montant</label>
      <input type="text" name="montant" placeholder=<?= $montant ?> value="<?= $montant ?>" disabled class="form-control" autocomplete="off" required />
     </div>
     <div class="form-group">
      <label for="date">Date</label>
      <input type="text" name="date" disabled value=<?= date("d/m/Y") ?> placeholder=<?= date("d/m/Y") ?> class="form-control" autocomplete="off" required />
     </div>
     <br>
     <h6>NB : Vous pouvez accepter le devis ou annuler</h6>
     <br>
     <button type="submit" class="btn btn-danger" name="cancel">
      <span class="glyphicon glyphicon-remove-circle"></span>
      Annuler
     </button>
     <button type="submit" class="btn btn-success" name="submit">
      <span class="glyphicon glyphicon-log-in"></span>
      J'accepte
     </button></br></br>

    </form>
   </div>
  </div>
 </div>
</body>

</HTML>