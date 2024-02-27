<?php
session_start();
include "../../private/api.php";
$api = new API();
$code_sous_traitant = 'code' . rand(100, 999);
$list_zei = [];
$list_zei = $api->getListZEI();

if (isset($_POST['submit'])) {
 $api->insertionSousTraitant($code_sous_traitant);
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
   <div class="panel-heading">
    <h3><img src="header.png" width="100%"></h3>
    <h3>Page ajout sous-trant</h3>
    <br>
    <?php if (!empty($_SESSION['success_sous_traitant'])) { ?>
     <div class="alert alert-success">
      <?php echo $_SESSION['success_sous_traitant'] ?>
     </div>
    <?php } ?>
   </div>
   <div class="panel-body">
    <form method="post" action="" class="form">
     <div class="form-group">
      <label for="login">Nom et prénom sous-traitant</label>
      <input type="text" name="nom_sous_traitant" placeholder="Nom et prénom sous-traitant" class="form-control" autocomplete="off" required />
     </div>

     <div class="form-group">
      <label for="login">Téléphone sous-traitant</label>
      <input type="number" name="telephone_sous_traitant" placeholder="Téléphone sous-tratant" class="form-control" autocomplete="off" required />
     </div>
     <div class="form-group">
      <label for="login">Code sous-traitant</label>
      <input type="number" name="Code sous-traitant" placeholder=<?= $code_sous_traitant ?> value=<?= $code_sous_traitant ?> class="form-control" autocomplete="off" required disabled />
     </div>
     <br>

     <label for="zei">Choisissez la ZEI :</label>
     <select name="zei" id="zei">
      <?php
      foreach ($list_zei as $zei) {
       echo '<option value="' . $zei['ID_ZEI'] . '">' . $zei['VILLE_ZEI'] . '</option>';
      }
      ?>
     </select>

     <br>
     <br>
     <label for="login">Jour de travaille</label><br>
     <label>
      <input type="checkbox" name="jour[]" value="Lundi"> Lundi
     </label>
     <label>
      <input type="checkbox" name="jour[]" value="Mardi"> Mardi
     </label>
     <label>
      <input type="checkbox" name="jour[]" value="Mercredi"> Mercredi
     </label>
     <label>
      <input type="checkbox" name="jour[]" value="Jeudi"> Jeudi
     </label>
     <label>
      <input type="checkbox" name="jour[]" value="Vendredi"> Vendredi
     </label>

     <br>
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