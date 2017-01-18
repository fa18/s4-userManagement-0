<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();


if(isset($_GET['id']) AND is_numeric($_GET['id']))
{

    $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id WHERE role.id = ".$_GET['id']." GROUP BY role.id, name";
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_BOTH);

    if(!$row)
    {
        echo "Le role n'existe pas";
    } else {
        if($row[1] > 0)
        {
            echo "Le role est utilisé par des utilisateurs";
        } else {
            $ok = true;
        }
    }

    if(isset($_POST['supprimer']) AND isset($ok))
    {
        $query = "DELETE from role where id = ".$_GET['id'];
        $sth = $pdo->prepare($query);
        $sth->execute();
        echo "Supprimé !";
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
    <?php if(isset($ok)) { ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="usr">Vous voulez vraiment supprimer le role ?</label>
            <input type="submit" name="supprimer" value="supprimer" class="button" id="usr">
        </div>
    </form>
    <?php } ?>
</div>
</body>
</html>