<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();

if(isset($_GET['id']) AND is_numeric($_GET['id'])){
    $query = "SELECT name, count(idrole), role.id FROM role JOIN user ON user.idrole = role.id WHERE role.id = ".$_GET['id']." GROUP BY role.id, name";
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetchAll(PDO::FETCH_BOTH);

    ob_start();
    foreach ($row  as $item) {
        echo "<tr>";
        echo "<td>$item[0]</td>";
        echo "<td>$item[1]</td>";
        echo "</tr>";
    }
    $content = ob_get_contents();
    ob_end_clean();
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
            <th>Nom</th>
            <th>Nombres d'utilisateurs</th>
        </tr>
        </thead>
        <tbody>
        <?php echo $content ?>
        </tbody>
    </table>
</div>
</body>
</html>
