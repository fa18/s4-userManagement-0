<?php
    require_once ('../configuration.php');
    require_once ('../SPDO.php');
    $pdo = SPDO::getInstance();

    if(isset($_POST['nomR']))
    {
        $nom = $_POST['nomR'];
        $query = "INSERT into role (name) VALUES ('$nom')";
        $sth = $pdo->prepare($query);
        $sth->execute();
        echo "Ajouté !";
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
            <input name="nomR" type="text" value="" class="form-control" id="usr" required>
            <input type="submit" value="ajouter" class="button" id="usr">
        </div>
    </form>
</div>
</body>
</html>