<?php
session_start();
include "../../private/api.php";
if (isset($_POST['submit'])) {
 $api = new API();
 $api->redirectionPageDemandeBranchement();
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
    <h3>Votre dévis est le suivant</h3>
   </div>
   <div class="panel-body">
    <form method="post" action="" class="form">

     <?php if (!empty($erreurLogin)) { ?>
      <div class="alert alert-danger">
       <?php echo $erreurLogin ?>
      </div>
     <?php } ?>
     </br>
     <div class="form-group">
      <label for="login">Date</label>
      <input type="text" name="nom_lotissement" placeholder=<?=date("Y/m/d")?> class="form-control" autocomplete="off" required />
     </div>

     <div class="form-group">
      <label for="login">Montant</label>
      <input type="text" name="rue_lotissement" placeholder="300000" class="form-control" autocomplete="off" required />
     </div>


     <br>
     <button type="submit" class="btn btn-danger" name="submit">
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