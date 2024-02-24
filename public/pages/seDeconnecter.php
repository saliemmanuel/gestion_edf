<?php
    // Page de deconnexion
    session_start();
    // destruction de la session d'utilisation
    session_destroy();
    // redirection
    header('location:login.php');
   
?>
