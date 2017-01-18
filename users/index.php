<?php
require_once ('../configuration.php');
require_once ('../SPDO.php');
$pdo = SPDO::getInstance();

if(isset($_GET['col']))
{
    $col = $_GET['col'];
    if(isset($_GET['tri']) AND $_GET['tri'] == "up")
    {
        $query = "SELECT login, firstname, lastname, email, image, idrole, id FROM user ORDER BY $col";
    } else {
        $query = "SELECT login, firstname, lastname, email, image, idrole, id FROM user ORDER BY $col desc";
    }
} else {
    $query = "SELECT login, firstname, lastname, email, image, idrole, id FROM user";
}

if(isset($query))
{
    $sth = $pdo->prepare($query);
    $sth->execute();
    $row = $sth->fetchAll(PDO::FETCH_NUM);

    ob_start();
    foreach ($row as $item) {
        echo "<tr>";
        foreach ($item as $row => $items) {
            if($row != 6)
                echo "<td>$items</td>";
        }
        echo "<td><a href='show.php?id=$item[6]'><span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span></a>";
        echo "<a href='update.php?id=$item[6]'><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a>";
        echo "<a href='delete.php?id=$item[6]'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></td>";
        echo "</tr>";
    }
    $content = ob_get_contents();
    ob_end_clean();
} else {
    $content = "Erreur";
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
            <th>login
                <a href="?col=1&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=1&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>firstname
                <a href="?col=2&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=2&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>lastname
                <a href="?col=3&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=3&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>email
                <a href="?col=4&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=4&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>image
                <a href="?col=5&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=5&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>roles
                <a href="?col=6&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                <a href="?col=6&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        <?php echo $content ?>
        </tbody>
    </table>
</div>
</body>
</html>
