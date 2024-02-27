<?php
session_start();
include "../../private/api.php";
if (isset($_POST['submit'])) {
 $api = new API();
 $api->redirectionPageDevis();
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

    <center>
     <h3>Renseigner les informations pour votre branchement</h3>
    </center>
   </div>
   <div class="panel-body">
    <form method="post" action="" class="form">

     </br>
     <h4>Information sur votre lotissement(votre adresse actuel)</h4>
     <hr>
     <div class="form-group">
      <label for="login">Nom lotissement</label>
      <input type="text" name="nom_lotissement" placeholder="Nom lotissement (Ex : Maroua)" class="form-control" autocomplete="off" required />
     </div>

     <div class="form-group">
      <label for="login">Rue lotissement</label>
      <input type="text" name="rue_lotissement" placeholder="Rue lotissement (Ex : Deux voie Domayo)" class="form-control" autocomplete="off" required />
     </div>

     <div class="form-group">
      <label for="login">Commune lotissement</label>
      <input type="text" name="commune_lotissement" placeholder="Commune lotissement (Ex : Commune Maroua 1)" class="form-control" autocomplete="off" required />
     </div>
     <br>
     <h4>Type branchement</h4>

     <select name="type_branchement" id="type_branchement">
      <option value="neuf">Neuf</option>
      <option value="provisoire">Provisoire</option>
      <option value="modification">Modification</option>
     </select>
     <br>
     <br>
     <button type="submit" class="btn btn-danger" name="submit">
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