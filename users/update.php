<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();


if(isset($_GET['id']) AND is_numeric($_GET['id'])){

    if(isset($_POST['modifier']))
    {
        $login = $_POST['login'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $image = $_POST['image'];
        $role = $_POST['role'];

        $query = "UPDATE user set login = '$login', firstname = '$firstname', lastname = '$lastname', email = '$email', image = '$image', idrole = $role
        where id = ".$_GET['id'];
        $sth = $pdo->prepare($query);
        $sth->execute();
        echo "Modifié !";
    }

    $query = "SELECT login, firstname, lastname, email, image, idrole, id FROM user WHERE id = ".$_GET['id']." LIMIT 1";
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_BOTH);
    if(!$row)
    {
        echo "L'user n'existe pas";
    } else {
        $login = $row[0];
        $firstname = $row[1];
        $lastname = $row[2];
        $email = $row[3];
        $image = $row[4];
        $role = $row[5];
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
            <label for="usr">login :</label>
            <input name="login" type="text" value="<?php if(isset($login)) echo $login ?>" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">firstname :</label>
            <input name="firstname" type="text" value="<?php if(isset($firstname)) echo $firstname ?>" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">lastname :</label>
            <input name="lastname" type="text" value="<?php if(isset($lastname)) echo $lastname ?>" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">email :</label>
            <input name="email" type="text" value="<?php if(isset($email)) echo $email ?>" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">image :</label>
            <input name="image" type="text" value="<?php if(isset($image)) echo $image ?>" class="form-control" id="usr">
        </div>
        <div class="form-group">
            <label for="usr">role</label>
            <input name="role" type="text" value="<?php if(isset($role)) echo $role ?>" class="form-control" id="usr">
        </div>
        <input name="modifier" type="submit" value="mettre a jour" class="button" id="usr">
    </form>
</div>
</body>
</html>