<html>
    <head>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center"><tr><td>
            <center><img src="include/banners/banner2.png"></center>
        </td></tr><tr><td>
                
    <?php
        session_start();
        include("include/functions.php");
        include("include/meniu.php");
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "cvpopuliariausi.list.php";
            $header = "Populiariausi CV";
            $tipas = getUserLookupType($userlevel);
            if($userlevel > 0){
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db->set_charset("utf8");
            $query = "SELECT vartotojas.vardas, vartotojas.pavarde, cv.antraste, cv.cv_id, cv.dalykas, cv.tekstas, cv.kaina, cv.data, cv.internetu FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.statusas='$tipas' ORDER BY views DESC LIMIT 10";
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>CV nėra!</td></tr></table><br>";exit;}
            }
            else{
                $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                $db->set_charset("utf8");
                $query = "SELECT vartotojas.vardas, vartotojas.pavarde, cv.antraste, cv.cv_id, cv.dalykas, cv.tekstas, cv.kaina, cv.data, cv.internetu FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) ORDER BY views DESC LIMIT 10";
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>CV nėra!</td></tr></table><br>";exit;}
            }
?>
    <table class="center" style="border-color: white;"><tr><td>
    <?php
        $cc = 1;
        if($userlevel == $user_roles[ADMIN_LEVEL]){ ?>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center"><?php echo "$header";?></th>
                  <th scope="col">Kaina</th>
                  <th scope="col">Paskelbimo data</th>
                </tr>
              </thead>
              <tbody> <?php
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['kaina'] . " €</b></td><td>";
                            echo "<button class='btn btn-link' disabled>" . $row['data'] . "</form></td></tr>";
                            /*echo "<form action='editArticle.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class=\"btn btn-outline-warning\" type='submit' name='submit'>Redaguoti</button></form>"
                                         ."</td><td>" . "<form action=\"procArticleDelete.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite ištrinti šį straipsnį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"cv_id\" value=\"$row[cv_id]\">";
                            echo "</form></td></tr>";*/
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
            
        }
        else{ ?>
            <table class="table">
                <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="6"><?php echo $header ?></th>
                </tr>
              </thead>
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Antraštė</th>
                  <th scope="col" style="text-align: center">Vartotojas</th>
                  <th scope="col" style="text-align: center">Dalykas</th>
                  <th scope="col" style="text-align: center">Kaina</th>
                  <th scope="col" style="text-align: center">Paskelbimo data</th>
                </tr>
              </thead>
              <tbody> <?php
                        while($row = mysqli_fetch_assoc($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['vardas'] . " " . $row['pavarde'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['dalykas'] . "</b></td><td>";
                            echo "<button class='btn btn-link' disabled><b>" . $row['kaina'] . " €</b></td><td>";
                            echo "<button class='btn btn-link' disabled>" . $row['data'] . "</form></td></tr>";
                        }
            echo "</tbody></table><center>"; // start a table tag in the HTML
        }
        mysqli_close($db);
?>
    </td></tr>
    </table><br>		
    </div><br></table>
</body>
</html>