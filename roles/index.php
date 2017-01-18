<meta charset=utf-8>
<?php 
    //Connexion à la BDD
    include("../includes/connexionBDD.php"); echo '</br>';

    $ch = "SELECT name, count(idrole) as nombre, role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name";
    $tab = LireDonneesPDO1($conn,$ch);
    AfficherDonnee($tab);



 	 
 
?>