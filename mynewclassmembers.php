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
        <table class="center" ><tr><td>
            <center><a href="index.php"><img src="include/banners/banner2.png"/></a></center>
        </td></tr><tr><td> 
                
        <?php
        session_start();
        include("include/meniu.php");
        include("include/functions.php");
        // cia sesijos kontrole
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "mynewclassmembers.php";
        
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
                $query = "SELECT vartotojas.vardas, vartotojas.pavarde, vartotojas.vartotojo_id, klases_nariai.busena, klase.klases_id, klases_nariai.fk_klases_id FROM ((" . TBL_KLASES_NARIAI
                        . " INNER JOIN " . TBL_CLASS . " ON klases_nariai.fk_klases_id = klase.klases_id)"
                        . " INNER JOIN " . TBL_USERS . " ON klases_nariai.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE klases_nariai.busena = 'Laukiama patvirtinimo'";
                        
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Norinčių užsirašyti į Jūsų klasę nėra!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
        ?>


                <table class="center" style="border-color: white;"><tr><td>

 
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Vartotojas</th>
                  <th scope="col" style="text-align: center">Būsena</th>
                  <th colspan="2" style="text-align: center"></th>
                </tr>
              </thead>
              <tbody> <?php
                        $count = 1;
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[klases_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[vardas] $row[pavarde]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['busena'] . "</b></td><td>";
                            echo "<form action=\"changeStudentStatus.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite priimti šį mokinį?');\"><button class=\"btn btn-outline-success\" type=\"submit\">Priimti</button>"
                            . "<input type=\"hidden\" name=\"klases_id\" value=\"$row[klases_id]\"><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"><input type=\"hidden\" name=\"status_id\" value=\"1\"></form></td><td>";
                            echo "<form action=\"changeStudentStatus.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite atmesti šį mokinį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Atmesti</button>"
                            . "<input type=\"hidden\" name=\"klases_id\" value=\"$row[klases_id]\"><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"><input type=\"hidden\" name=\"status_id\" value=\"3\">";
                            echo "</form></td></tr>";
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
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