<?php
//Fichier connexion à la base de Données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestion_departement_mi","root", "");

}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}
?>

