<?php
session_start();
include "../../private/api.php";
$api = new API();
$demande = $api->selectAllDemande();
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
          <h3><img src="header.png" width="115%"></h3>
        </h3>
        <br>
        <h4>
          <center>Liste des client ayant sollicité un branchement</center>
          <center>Date : <?= date("d/m/Y") ?></center>
        </h4>
      </div>
      <div class="panel-body">
        <form method="post" action="" class="form">
          <hr>
          <table>
            <tr>
              <th>DATE_DEMANDE</th>
              <th>NOM_CLIENT</th>
              <th>PRENOM_CLIENT</th>
              <th>TEL_CLIENT</th>
              <th>TYPE_BRANCHEMENT</th>
            </tr>

            <?php
            foreach ($demande as $key => $value) { ?>
              </tr>
              <tr>
                <td><?= $value['DATE_DEMANDE'] ?></td>
                <td><?= $value['NOM_CLIENT_DEMANDE'] ?></td>
                <td><?= $value['PRENOM_CLIENT_DEMANDE'] ?></td>
                <td><?= $value['TEL_CLIENT_DEMANDE'] ?></td>
                <td><?= $value['TYPE_BRANCHEMENT'] ?></td>
              <?php   } ?>
          </table>

          <br><br>
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