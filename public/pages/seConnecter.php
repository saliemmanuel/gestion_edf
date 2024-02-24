<?php
// Page redirection de connection
session_start();
require_once('connexiondb.php');

// recuperation des informations de connexion #login
$login = isset($_POST['login']) ? $_POST['login'] : "";
// recuperation des informations de connexion #password
$pwd = isset($_POST['pwd']) ? $_POST['pwd'] : "";
// requete récuperation des informations de l'user
$requete = "select iduser,login,email,role,etat 
                from utilisateur where login='$login' 
                and pwd=MD5('$pwd')";
// execution de la requete de recuperation des informations de connexion
$resultat = $pdo->query($requete);

if ($user = $resultat->fetch()) {
    // 
    if ($user['etat'] == 1) {
        
        //redirection vers la page admin si l'utilisateur est un Administrateur
        if ($user["role"] == "ADMIN") {
            $_SESSION['user'] = $user;
            header('location:adminPage.php');
        } 
        
        // redirection vers le dashbord du chef de departement si l'utilisateut est un chef de departement
            if ($user["role"] == "CD") {
            $_SESSION['user'] = $user;
            header('location:chefDeparPage.php');
        } 
        
        // redirection vers le dashbord de l'enseignant si l'utilisateur est un enseignant
            if ($user["role"] == "ENSEIGNANT") {
            $_SESSION['user'] = $user;
            echo "Enseignant";
            }
    } else {
        // Message d'erreur de connexion
        $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Votre compte est désactivé.<br> Veuillez contacter l'administrateur";
        header('location:login.php');
    }
} else {
        // Message d'erreur de connexion
    $_SESSION['erreurLogin'] = "<strong>Erreur!!</strong> Login ou mot de passe incorrecte!!!";
    header('location:login.php');
}
