<?php
session_start();
include "../../private/api.php";
$api = new API();
$electriciens = $api->selectElectriciansByMasterBuilder();
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
              <th>NOM_ELECTRICIEN</th>
              <th>ADRESSE_ELECTRICIEN</th>
              <th>TEL_ELECTRICIEN</th>
            </tr>

            <?php
            foreach ($electriciens as $key => $value) { ?>
              </tr>
              <tr>
                <td><?= $value['NOM_ELECTRICIEN'] ?></td>
                <td><?= $value['ADRESSE_ELECTRICIEN'] ?></td>
                <td><?= $value['TEL_ELECTRICIEN'] ?></td>
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