<?php
session_start();
include "../../private/api.php";
if (isset($_POST['demande'])) {
  header('location:info_client.php');
}

if (isset($_POST['sous-traitant'])) {
  header('location:page_insertion_sous_traitant.php');
}

if (isset($_POST['demande-abonne'])) {
  header('location:page_list_demande_abonne.php');
}

if (isset($_POST['electriciens-zozo'])) {
  header('location:page_electricien_ayant_tavaille_avec_zozo.php');
}

if (isset($_POST['derniers-jours'])) {
  header('location:page_insertion_sous_traitant.php');
}

if (isset($_POST['contrat-sous-traitant'])) {
  header('location:page_insertion_sous_traitant.php');
}
?>
<! DOCTYPE HTML>
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
          <br>

          <h3>
            <center>Bienvenue sur le site de gestion du centre EDF </center>

          </h3>
        </div>
        <div class="panel-body">
          <br>
          <form method="post" action="" class="form">
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="sous-traitant">
                <span class="glyphicon glyphicon-plus"></span>
                Enregistrer un sous-traitant
              </button></center>
            <br>
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="demande">
                <span class="glyphicon glyphicon-plus"></span>
                Formuler une demande de branchement
              </button></center>
            <br>
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="demande-abonne">
                <span class="glyphicon glyphicon-plus"></span>
                Liste des abonnés ayant sollicités un branchement
              </button></center>
            <br>
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="electriciens-zozo">
                <span class="glyphicon glyphicon-plus"></span>
                List électriciens ayant pour maitre
                d’œuvre « Monsieur Zozo ».
              </button></center>

            </br>
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="derniers-jours">
                <span class="glyphicon glyphicon-plus"></span>
                Liste opérations ayant eu lieu les
                07 derniers jours.
              </button></center>

            </br>
            <center> <button type="submit" class="btn btn-primary btn-lg btn-block" name="contrat-sous-traitant">
                <span class="glyphicon glyphicon-plus"></span>
                Liste sous-traitants ayant contractés avec le centre EDF
              </button></center>

            </br>
            </br>
          </form>
        </div>
      </div>
    </div>
  </body>

  </HTML>