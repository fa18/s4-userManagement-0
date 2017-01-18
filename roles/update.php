<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();


if(isset($_GET['id']) AND is_numeric($_GET['id'])){

    if(isset($_POST['nomR']))
    {
        $nom = $_POST['nomR'];
        $query = "UPDATE role set name = '$nom' where id = ".$_GET['id'];
        $sth = $pdo->prepare($query);
        $sth->execute();
        echo "Modifié !";
    }

    $query = "SELECT name FROM role WHERE role.id = ".$_GET['id']." LIMIT 1";
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_BOTH);
    if(!$row)
    {
        echo "Le role n'existe pas";
    } else {
        $name = $row[0];
    }
}



?>
<!DOCTYPE html>
<html>
<head>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link href='../assets/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
</head>
<body>
<div class="container">
    <form action="" method="post">
        <div class="form-group">
            <label for="usr">Nom du role :</label>
            <input name="nomR" type="text" value="<?php if(isset($name)) echo $name ?>" class="form-control" id="usr">
            <input type="submit" value="mettre a jour" class="button" id="usr">
        </div>
    </form>
</div>
</body>
</html>