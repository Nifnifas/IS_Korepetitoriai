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
            <center><img src="include/topB.png"></center>
        </td></tr><tr><td> 
                
        <?php
        session_start();
        include("include/meniu.php");
        include("include/functions.php");
        // cia sesijos kontrole
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "pazymeticv.php";

        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        
                $query = "SELECT vartotojas.vardas, cv.antraste FROM ((" . TBL_PAZYMETI
                        . " INNER JOIN " . TBL_USERS . " ON pazymeti_cv.fk_vartotojo_id = vartotojas.vartotojo_id)"
                        . " INNER JOIN " . TBL_CVS . " ON pazymeti_cv.fk_cv_id = cv.cv_id) WHERE pazymeti_cv.fk_vartotojo_id = '$_SESSION[userid]'";
                        
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Jūs neturite pažymėtų cv!</td></tr></table><br>";exit;}
        ?>


                <table class="center" style="border-color: white;"><br><br><tr><td>

 
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Mano straipsniai</th>
                  <th scope="col" style="text-align: center">Įkėlimo data</th>
                  <th scope="col" style="text-align: center">Statusas</th>
                  <th colspan="2" style="text-align: center">Funkcijos</th>
                </tr>
              </thead>
              <tbody> <?php
                        $count = 1;
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='article_id' value='$row[article_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[pavarde]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['vardas'] . "</b></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['statusas_name'] . "</b></td><td>";
                            echo "<form action='editArticle.php' method='POST'><input name='article_id' value='$row[article_id]' hidden><button class=\"btn btn-outline-warning\" type='submit' name='submit'>Redaguoti</button></form>"
                                         ."</td><td>" . "<form action=\"procArticleDelete.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite ištrinti šį straipsnį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"article_id\" value=\"$row[article_id]\">";
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
</body>
</html>