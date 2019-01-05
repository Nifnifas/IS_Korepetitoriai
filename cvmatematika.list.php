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
            <center><img src="include/topB.png"></center>
        </td></tr><tr><td>
                
    <?php
        session_start();
        include("include/functions.php");
        include("include/meniu.php");
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "cvmatematika.list.php";
            $header = "Matematika";
            $tipas = getUserLookupType($userlevel);
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db->set_charset("utf8");
            $sql = "SELECT COUNT(*) FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header' AND vartotojas.statusas='$tipas'";
            $result = mysqli_query($db, $sql) or trigger_error("SQL", E_USER_ERROR);
            $r = mysqli_fetch_row($result);
            $numrows = $r[0];

            //eiluciu kiekis per puslapi
            $rowsperpage = 5;
            //puslapiu kiekis
            $totalpages = ceil($numrows / $rowsperpage);
            //randam dabartini arba default
            if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
               $pageid = (int) $_GET['pageid'];
            } else {
               //default puslapio numeris
               $pageid = 1;
            }
            if ($pageid > $totalpages) {
               $pageid = $totalpages;
            } 
            if ($pageid < 1) {
               $pageid = 1;
            }
            $offset = ($pageid - 1) * $rowsperpage;

            $sql2 = "SELECT vartotojas.vardas, vartotojas.pavarde, cv.antraste, cv.cv_id, cv.dalykas, cv.tekstas, cv.kaina, cv.data, cv.internetu FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header' AND vartotojas.statusas='$tipas' ORDER BY data DESC LIMIT $offset, $rowsperpage";
            $result2 = mysqli_query($db, $sql2) or trigger_error("SQL", E_USER_ERROR);
            
                if (!$result2 || (mysqli_num_rows($result2) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>CV nėra!</td></tr></table><br>";exit;}
?>
    <table class="center" style="border-color: white;"><br><br><tr><td>
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
                        while($row = mysqli_fetch_array($result2)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['kaina'] . " €</b></td><td>";
                            echo "<button class='btn btn-link' disabled>" . $row['data'] . "</form></td></tr>";
                            /*echo "<form action='editArticle.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class=\"btn btn-outline-warning\" type='submit' name='submit'>Redaguoti</button></form>"
                                         ."</td><td>" . "<form action=\"procArticleDelete.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite ištrinti šį straipsnį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"cv_id\" value=\"$row[cv_id]\">";
                            echo "</form></td></tr>";*/
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
            
            //kiek rodyti puslapiu
            $range = 3;
            if ($pageid > 1) {
               //rodom linka atgal
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=1'><<</a> ";
               //gaunam pries tai buvusio puslapi
               $prevpage = $pageid - 1;
               //grizti i pirma psl
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$prevpage'><</a> ";
            }

            //tam kad rodytu puslapius aplink dabartini page
            for ($x = ($pageid - $range); $x < (($pageid + $range) + 1); $x++) {
               //jei teisingas nr
               if (($x > 0) && ($x <= $totalpages)) {
                  //jei esam dabartiniame puslapy
                  if ($x == $pageid) {
                     //pazymi, bet nedaro link
                     echo " [<b>$x</b>] ";
                  //jei ne dabartinis psl
                  } else {
                     //darom linka
                     echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$x'>$x</a> ";
                  }
               }
            }

            //jei nepaskutinis psl, rodom linkus i prieki ir atgal        
            if ($pageid != $totalpages) {
               //gaunam sekanti psl
               $nextpage = $pageid + 1;
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$nextpage'>></a> ";
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$totalpages'>>></a> ";
            }
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
                        while($row = mysqli_fetch_assoc($result2)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['vardas'] . " " . $row['pavarde'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['dalykas'] . "</b></td><td>";
                            echo "<button class='btn btn-link' disabled><b>" . $row['kaina'] . " €</b></td><td>";
                            echo "<button class='btn btn-link' disabled>" . $row['data'] . "</form></td></tr>";
                        }
            echo "</tbody></table><center>"; // start a table tag in the HTML
            
            //kiek rodyti puslapiu
            $range = 3;
            if ($pageid > 1) {
               //rodom linka atgal
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=1'><<</a> ";
               //gaunam pries tai buvusio puslapi
               $prevpage = $pageid - 1;
               //grizti i pirma psl
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$prevpage'><</a> ";
            }

            //tam kad rodytu puslapius aplink dabartini page
            for ($x = ($pageid - $range); $x < (($pageid + $range) + 1); $x++) {
               //jei teisingas nr
               if (($x > 0) && ($x <= $totalpages)) {
                  //jei esam dabartiniame puslapy
                  if ($x == $pageid) {
                     //pazymi, bet nedaro link
                     echo " [<b>$x</b>] ";
                  //jei ne dabartinis psl
                  } else {
                     //darom linka
                     echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$x'>$x</a> ";
                  }
               }
            }

            //jei nepaskutinis psl, rodom linkus i prieki ir atgal        
            if ($pageid != $totalpages) {
               //gaunam sekanti psl
               $nextpage = $pageid + 1;
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$nextpage'>></a> ";
               echo " <a href='{$_SERVER['PHP_SELF']}?pageid=$totalpages'>>></a></center>";
            }
        }
        mysqli_close($db);
?>
    </td></tr>
    </table><br>		
    </div><br></table>
</body>
</html>