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
        if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[MOKYTOJAS_LEVEL]))   {redirect("logout.php");exit;}
        $_SESSION['prev'] = "myclass.php";
        $fk_klases_id = getClassID($userid, "Dabartiniai");
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
                $query = "SELECT * FROM (((" . TBL_KLASES_NARIAI
                        . " INNER JOIN " . TBL_CLASS . " ON klases_nariai.fk_klases_id = klase.klases_id)"
                        . " INNER JOIN " . TBL_USERS . " ON klases_nariai.fk_vartotojo_id = vartotojas.vartotojo_id)"
                        . " INNER JOIN " . TBL_CVS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE klases_nariai.busena = 'Priimtas' AND klases_nariai.fk_klases_id = '$fk_klases_id'";
                        
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Jūsų klasė tuščia!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
        ?>


                <table class="center" style="border-color: white; border-width: 30px;"><tr><td>
     <div class="container bg-light p-5 rounded">
 
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
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[vardas] $row[pavarde]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['busena'] . "</b></td><td>";
                            echo "<form action=\"deleteStudentFromClass.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite šalinti šį mokinį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button>"
                            . "<input type=\"hidden\" name=\"klases_id\" value=\"$row[klases_id]\"><input type=\"hidden\" name=\"vartotojo_id\" value=\"$row[vartotojo_id]\"><input type=\"hidden\" name=\"status_id\" value=\"1\">";
                            echo "</form></td></tr>";
                        }
            echo "</tbody></table></div>"; // start a table tag in the HTML
    mysqli_close($db);
?>
                </td></tr>
	</table><br>
			
			
    </div><br></table>
                  <?php include("include/footer.php"); ?>
</body>
</html>