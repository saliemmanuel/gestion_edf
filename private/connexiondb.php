<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

function connexionDb()
{
    $host = "localhost";
    $dbname = "edf_db";
    $user = "root";
    $pass = "";
    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (Exception $e) {
    }
    return $bdd;
}
