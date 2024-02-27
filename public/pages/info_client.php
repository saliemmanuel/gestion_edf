<?php
session_start();
include "../../private/api.php";
if (isset($_POST['submit'])) {
    $api = new API();
    $api->redirectionPageDemandeBranchement();
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

                <h3>Remplissez les information du client</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="" class="form">

                    </br>
                    <div class="form-group">
                        <label for="login">Nom :</label>
                        <input type="text" name="nom" placeholder="Nom" class="form-control" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="login">Prenom :</label>
                        <input type="text" name="prenom" placeholder="Prenom" class="form-control" autocomplete="off" required />
                    </div>

                    <div class="form-group">
                        <label for="login">Téléphone :</label>
                        <input type="number" name="telephone" placeholder="Téléphone" class="form-control" autocomplete="off" required />
                    </div>
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