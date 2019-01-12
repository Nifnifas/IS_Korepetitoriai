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
            <center><a href="index.php"><img src="include/banners/main-banner.png"/></a></center>
        </td></tr><tr><td>
                
        <?php
        session_start();
        include("include/meniu.php");
        include("include/functions.php");
        // cia sesijos kontrole
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "pazymeticv.php";
        
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
                $query = "SELECT vartotojas.vardas, vartotojas.pavarde, cv.antraste, cv.cv_id, cv.dalykas FROM ((" . TBL_PAZYMETI
                        . " INNER JOIN " . TBL_CVS . " ON pazymeti_cv.fk_cv_id = cv.cv_id)"
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE pazymeti_cv.fk_vartotojo_id = '$_SESSION[userid]'";
                        
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Jūs neturite pažymėtų CV!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
        ?>


                <table class="center" style="border-color: white; border-width: 30px;"><tr><td>
     <div class="container bg-light p-4 rounded">
 
            <table class="table">
                <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="6">Pažymėti CV</th>
                </tr>
              </thead>
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Antraštė</th>
                  <th scope="col" style="text-align: center">Vartotojas</th>
                  <th scope="col" style="text-align: center">Dalykas</th>
                  <th colspan="2" style="text-align: center"></th>
                </tr>
              </thead>
              <tbody> <?php
                        $count = 1;
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['vardas'] . " " . $row['pavarde'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['dalykas'] . "</b></td><td>";
                            echo "<form action=\"procpazymeticv.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite atžymėti šį cv?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"cv_id\" value=\"$row[cv_id]\"><input type=\"hidden\" name=\"busena\" value=\"2\">";
                            echo "</form></td></tr>";
                        }
            echo "</tbody></table></div>"; // start a table tag in the HTML
            
    mysqli_close($db);
    
    if($count-- == 0){
        echo "<b>Jūs neturite pažymėtų cv!</b>";exit;
    }
?>
                </td></tr>
	</table><br>
			
			
    </div><br></table>
                  <?php include("include/footer.php"); ?>
</body>
</html>