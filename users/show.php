<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();

if(isset($_GET['id']) AND is_numeric($_GET['id'])){
    $query = "SELECT login, firstname, lastname, email, image, idrole FROM user WHERE id = ".$_GET['id']." LIMIT 1";
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetch(PDO::FETCH_NUM);

    if($row){
        ob_start();
        echo "<tr>";
        foreach ($row  as $key => $item) {
            if($key == 4)
                echo "<td><img src='$item'/></td>";
            else
                echo "<td>$item</td>";
        }
        echo "</tr>";
        $content = ob_get_contents();
        ob_end_clean();
    } else {
        $content = "utilsiateur existe pas";
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
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>login</th>
            <th>firstname</th>
            <th>lastname</th>
            <th>email</th>
            <th>image</th>
            <th>roles </th>
        </tr>
        </thead>
        <tbody>
        <?php echo $content ?>
        </tbody>
    </table>
</div>
</body>
</html>
