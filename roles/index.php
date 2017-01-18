<?php
    require_once ('../configuration.php');
    require_once ('../SPDO.php');
    $pdo = SPDO::getInstance();

    if(isset($_GET['col']))
    {
        $col = $_GET['col'];
        if(isset($_GET['tri']) AND $_GET['tri'] == "up")
        {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY $col";
        } else {
            $query = "SELECT name, count(idrole), role.id FROM role LEFT JOIN user ON user.idrole = role.id GROUP BY role.id, name ORDER BY $col desc";
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

    //user

    if(isset($_GET['tab2']))
    {
        $req="SELECT * from user LEFT JOIN role ON user.idrole = role.id";
        $tab2 = $_GET['tab2']+3;
        if(isset($_GET['tri']) AND $_GET['tri'] == "up")
        {
            $req = $req." ORDER BY $tab2";
        } else {
            $req.=" ORDER BY $tab2 desc";
        }
    }    


    if(isset($_GET['rechercheUser'])){
        $req.= " WHERE name like '%".$_GET['rechercheUser']."%' GROUP BY role.id, name";
    }

    if(isset($query)) {

    $res=$pdo->prepare($req);
    $res->execute();
    $row=$res->fetchAll(PDO::FETCH_BOTH);

    ob_start();
    foreach ($row  as $item) {
        echo "<tr>";
        echo "<td>$item[3]</td>";
        echo "<td>$item[4]</td>";
        echo "<td>$item[5]</td>";
        echo "<td>$item[9]</td>";
        echo "<td><a href='show.php?id=$item[2]'><span class=\"glyphicon glyphicon-eye-open\" aria-hidden=\"true\"><span></a>";
        echo "<a href='update.php?id=$item[2]'><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a>";
        echo "<a href='delete.php?id=$item[2]'><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a></td>";
        echo "</tr>";
    } 
    $content2=ob_get_contents();  
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
                <input name="rechercheUser" type="text" class="form-control" id="usr">
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
                    <th>Action
                    </th>
                   
                </tr>
            </thead>
            <tbody>
               <?php echo $content ?>
            </tbody>
        </table>
    </div>
    <!-- USER-->
    <div class="container">
        <form action="" method="get">
            <div class="form-group">
                <label for="usr">Rechercher un utilisateur :</label>
                <input name="recherche" type="text" class="form-control" id="usr">
            </div>
        </form>
        <br>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nom
                        <a href="?tab2=3&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?tab2=3&tri=down"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                    </th>
                    <th>Prenom
                        <a href="?tab2=4&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?tab2=4&tri=down    "><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                    </th>
                     <th>Email
                        <a href="?tab2=5&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?tab2=5&tri=down    "><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                        
                    </th>
                    <th>Role
                        <a href="?tab2=6&tri=up"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                        <a href="?tab2=6&tri=down    "><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                    </th>
                    <th>Action
                    </th>
                </tr>
            </thead>
            <tbody>
               <?php echo $content2 ?>
            </tbody>
        </table>
    </div>


</body>
</html>
