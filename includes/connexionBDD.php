<?php

include("fonction_oracle.php");

//Fichier permettant de se connecter à la BDD 
//Le fichier est inclu dans le header
    $session = "root";
    $mdp = "";
    $instance = "mysql:host=localhost;dbname=phalcon-td0";
    $conn = ConnecterPDO($instance,$session,$mdp);
?>