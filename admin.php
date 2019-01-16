<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
                <link rel="icon" type="image/png" sizes="32x32" href="include/icons/favicon-32x32.png">
        <meta name=”viewport” content=”width=device-width, initial-scale=1″>
        <title>Korepetitai.lt - korepetitorių paieškos sistema</title>
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><a href="index.php"><img src="include/banners/main-banner.png"></a></center>
            </td></tr><tr><td>
<?php
// admin.php
// vartotojų įgaliojimų keitimas ir naujo vartotojo registracija, jei leidžia nustatymai
// galima keisti vartotojų roles, tame tarpe uzblokuoti ir/arba juos pašalinti
// sužymėjus pakeitimus į procadmin.php, bus dar perklausta

session_start();
include("include/meniu.php");
include("include/functions.php");
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   {redirect("logout.php");exit;}
$_SESSION['prev']="admin";
?>

<?php
    
	$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");        
        $sql = "SELECT COUNT(*) FROM " . TBL_USERS . " WHERE `statusas` != 'Administratorius' ORDER BY prisijungimo_laikas ASC,pavarde";
            $result = mysqli_query($db, $sql) or trigger_error("SQL", E_USER_ERROR);
            $r = mysqli_fetch_row($result);
            $numrows = $r[0];

            //eiluciu kiekis per puslapi
            $rowsperpage = 10;
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

            $sql2 = "SELECT * FROM " . TBL_USERS . " WHERE `statusas` != 'Administratorius' ORDER BY prisijungimo_laikas ASC LIMIT $offset, $rowsperpage";
            $result2 = mysqli_query($db, $sql2) or trigger_error("SQL", E_USER_ERROR);
            
                if (!$result2 || (mysqli_num_rows($result2) < 1))  
                                {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Vartotojų nėra!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
?>
    <table class="center" style="border-color: white; border-width: 30px;"><tr><td>
    <div class="container p-5">
                    <table class="table">
                <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="7">Vartotojų valdymas</th>
                </tr>
              </thead>
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Vartotojas</th>
                  <th scope="col" style="text-align: center">Rolė</th>
                  <th scope="col" style="text-align: center">El. paštas</th>
                  <th scope="col" style="text-align: center">Pask. prisijungimas</th>
                  <th colspan="2" style="text-align: center">Funkcijos</th>
                </tr>
              </thead>
              <tbody>
<?php
                $count = 1;
                        while($row = mysqli_fetch_array($result2)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<button class='btn btn-link'><b>" . $row['vardas'] . " " . $row['pavarde'] . "</b></button></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['statusas'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['el_pastas'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['prisijungimo_laikas'] . "</b></td><td style=\"text-align: center\">";
                            if($row['blokuotas'] == 0){
                                echo "<form action=\"blockUser.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite blokuoti šį vartotoją?');\"><button class=\"btn btn-outline-warning\" type=\"submit\">Blokuoti</button><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"/><input type=\"hidden\" name=\"status\" value=\"1\"/></form></td><td>";
                            }
                            else{
                                echo "<form action=\"blockUser.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite atblokuoti šį vartotoją?');\"><button class=\"btn btn-outline-success\" type=\"submit\">Atblokuoti</button><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"/><input type=\"hidden\" name=\"status\" value=\"0\"/></form></td><td>";
                            }
                            echo "<form action=\"deleteUser.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite ištrinti šį vartotoją?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"/><input type=\"hidden\" name=\"status\" value=\"$row[statusas]\"></form>";  
                            echo "</form></td></tr>";
                        }
            echo "</tbody></table></div>"; // start a table tag in the HTML
            
            echo "<center>";
        //kiek rodyti puslapiu
            $range = 1;
            if ($pageid > 1) {
               //rodom linka atgal
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=1'><<</a> ";
               //gaunam pries tai buvusio puslapi
               $prevpage = $pageid - 1;
               //grizti i pirma psl
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$prevpage'><</a> ";
            }

            //tam kad rodytu puslapius aplink dabartini page
            for ($x = ($pageid - $range); $x < (($pageid + $range) + 1); $x++) {
               //jei teisingas nr
               if (($x > 0) && ($x <= $totalpages)) {
                  //jei esam dabartiniame puslapy
                  if ($x == $pageid) {
                     //pazymi, bet nedaro link
                     echo " <button class='btn btn-primary' disabled>$x</button> ";
                  //jei ne dabartinis psl
                  } else {
                     //darom linka
                     echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$x'>$x</a> ";
                  }
               }
            }

            //jei nepaskutinis psl, rodom linkus i prieki ir atgal        
            if ($pageid != $totalpages) {
               //gaunam sekanti psl
               $nextpage = $pageid + 1;
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$nextpage'>></a> ";
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$totalpages'>>></a></center> ";
            }
    mysqli_close($db);
?>
    </div>
            </td></tr></table>
            </td></tr></table>
                <?php include("include/footer.php"); ?>
    </body></html>
