<?php

//---------------------------------------------------------------------------------------------
function ConnecterPDO($db,$db_username,$db_password)
{
	try
	{
		$conn = new PDO($db,$db_username,$db_password);
		$res = true;
    print_r("Connexion réussie");
		return $conn;
	}
	catch (PDOException $erreur)
	{
		echo $erreur->getMessage();
	}
}
//---------------------------------------------------------------------------------------------
function majDonnees($conn,$sql)
{
	$stmt = $conn->exec($sql);
	return $stmt;
}
//---------------------------------------------------------------------------------------------
function preparerRequete($conn,$sql)
{
	$cur = $conn->prepare($sql);
	return $cur;
}
//---------------------------------------------------------------------------------------------
function ajouterParam($cur,$param,$contenu,$type='texte',$taille=0) // fonctionne avec preparerRequete
{
// Sur Oracle, on peut tout passer sans préciser le type. Sur MySQL ???
//	if ($type == 'nombre')
//		$cur->bindParam($param, $contenu, PDO::PARAM_INT);
//	else
		//$cur->bindParam($param, $contenu, PDO::PARAM_STR, $taille);
	$cur->bindParam($param, $contenu);
	return $cur;
}
//---------------------------------------------------------------------------------------------
function majDonneesPreparees($cur) // fonctionne avec ajouterParam
{
	$res = $cur->execute();
	return $res;
}
//---------------------------------------------------------------------------------------------
function majDonneesPrepareesTab($cur,$tab) // fonctionne directement après preparerRequete
{
	$res = $cur->execute($tab);
	return $res;
}//---------------------------------------------------------------------------------------------
function LireDonneesPDO1($conn,$sql)
{
  $i=0;
  foreach  ($conn->query($sql,PDO::FETCH_ASSOC) as $ligne)     
    $tab[$i++] = $ligne;
  return $tab;
}
//---------------------------------------------------------------------------------------------
function LireDonneesPDOPreparee($cur)
{
  $res = $cur->execute();
  $tab = $cur->fetchall();
  return $tab;
}
//---------------------------------------------------------------------------------------------
function LireDonneesPDO2($conn,$sql)
{
  $i=0;
  $cur = $conn->query($sql);
  while ($ligne = $cur->fetch(PDO::FETCH_ASSOC))
    $tab[$i++] = $ligne;
  return $tab;
}
//---------------------------------------------------------------------------------------------
function LireDonneesPDO3($conn,$sql)
{
  $cur = $conn->query($sql);
  $tab = $cur->fetchall(PDO::FETCH_ASSOC);
  return $tab;
}
//---------------------------------------------------------------------------------------------
function AfficherDonnee($tab)
{
  foreach($tab as $ligne)
  {
    foreach($ligne as $cle =>$valeur)
	{
		$valeur = utf8_encode($valeur);
		echo $cle.":".$valeur."\t";
	}
    echo "<br/>";
  }
}

//---------------------------------------------------------------------------------------------
function selectCodetdf($bdd){
            $sql = "SELECT CODE_TDF, NOM from TDF_PAYS ORDER BY NOM";
            $reponse = $bdd->query($sql);
            echo "<option value=''>Selectionnez un pays</option>";
           	foreach($reponse as $ligne)
  			{		
            	$code = utf8_encode($ligne['CODE_TDF']);
            	$nom = utf8_encode($ligne['NOM']);
            	echo "<option value='" . $code . "'>" . $nom . "</option>";
            }
            	
        }
//---------------------------------------------------------------------------------------------
function selectAnneeCoureur($bdd){
           	$sql = "SELECT ANNEE FROM TDF_ANNEE";
            $reponse = $bdd->query($sql);
           	foreach($reponse as $ligne)
  			{		
            	$annee = $ligne['ANNEE'];
            	echo "<option value='" . $annee . "'>" . $annee . "</option>";
            }
            	
        }
//---------------------------------------------------------------------------------------------
function selectEpreuve($bdd,$annee){
            $sql = "SELECT ANNEE, N_EPREUVE, VILLE_A, VILLE_D, JOUR FROM TDF_EPREUVE WHERE ANNEE = " .$annee;
            $reponse = $bdd->query($sql);
            foreach($reponse as $ligne)
            {   
                $num = $ligne['N_EPREUVE'];
                $arrivee = $ligne['VILLE_A'];
                $depart = $ligne['VILLE_D'];
                $date = $ligne['JOUR'];
                echo "<option value='" . $num . "'>" . $num . " | " . $depart . " => " . $arrivee . "</option>";
            }
              
        }
//---------------------------------------------------------------------------------------------
function selectCatEpreuve($bdd){
            $sql = "SELECT DISTINCT CAT_CODE from TDF_EPREUVE ORDER BY CAT_CODE";
            $reponse = $bdd->query($sql);
            echo "<option value=''>Selectionnez une catégorie</option>";
            foreach($reponse as $ligne)
            {   
                echo "<option value='" . $ligne['CAT_CODE'] . "'>" . $ligne['CAT_CODE'] . "</option>";
            }
              
        }
//---------------------------------------------------------------------------------------------
function Afficher($obj)
{
	echo "<pre><hr/>";
	print_r($obj);
	echo "</pre><hr/>";
}
//---------------------------------------------------------------------------------------------
function ApostropheInsert($str)
{
	$str = preg_replace("#'#", "''", $str);
	return $str;
}

 ?>