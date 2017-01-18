<?php
    require_once ('../configuration.php');
    require_once ('../SPDO.php');
    $pdo = SPDO::getInstance();

    if(isset($_GET['col']) AND $_GET['col'] == 1)
    {
        if(isset($_GET['tri']) AND $_GET['tri'] == "up")
        {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY 1";
        } else {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY 1 desc";
        }
    } else if (isset($_GET['col']) AND $_GET['col'] == 2)
    {
        if(isset($_GET['tri']) AND $_GET['tri'] == "up")
        {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY 2";
        } else {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY 2 desc";
        }
    } else {
        $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name";
    }

    if(isset($_GET['recherche'])){
        $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id WHERE name like '%".$_GET['recherche']."%' GROUP BY role.id, name";
    }

    if(isset($query))
    {
        $sth = $pdo->prepare($query);
        $sth->execute();
        $row = $sth->fetchAll(PDO::FETCH_BOTH);

        ob_start();
            foreach ($row  as $item) {
                echo "<tr>";
                echo "<td>$item[0]</td>";
                echo "<td>$item[1]</td>";
                echo "<td><a href='show.php?id=$item[2]'><span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"></span></a>";
                echo "<a href='update.php?id=$item[2]'><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a>";
                echo "<a href='delete.php?id=$item[2]'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></td>";
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
        <form action="" method="get">
            <div class="form-group">
                <label for="usr">Rechercher un role :</label>
                <input name="recherche" type="text" class="form-control" id="usr">
            </div>
        </form>
        <br>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nom
                        <a href="?col=1&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?col=1&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                    </th>
                    <th>Nombres d'utilisateurs
                        <a href="?col=2&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?col=2&tri=down    "><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
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
