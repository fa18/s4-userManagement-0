<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();


if(isset($_GET['id']) AND is_numeric($_GET['id']))
{
    $query = "SELECT * FROM user WHERE id = ".$_GET['id'];
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_BOTH);

    if(!$row)
    {
        echo "L'utilisateur n'existe pas";
    } else {
        $ok = true;
    }

    if(isset($_POST['supprimer']) AND isset($ok))
    {
        $query = "DELETE from user where id = ".$_GET['id'];
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
                <label for="usr">Vous voulez vraiment supprimer ce user ?</label>
                <input type="submit" name="supprimer" value="supprimer" class="button" id="usr">
            </div>
        </form>
    <?php } ?>
</div>
</body>
</html>