 <?php
    //Contrôle de l'authentification de l'user 
    if (!isset($_SESSION['user'])) {
        header('location:login.php');
        exit();
    }
    // if (isset($_SESSION['user'])) {
    //     if ($_SESSION['user']['role'] == "ADMIN")
    //         echo "Admin";
    //         // header('location:adminPage.php');
    //     if ($_SESSION['user']['role'] == "CD")
    //         header('location:chefDeparPage.php');
    //     if ($_SESSION['user']['role'] == "ENSEIGNANT")
    //         echo "Enseignant";
    // }

    ?>
