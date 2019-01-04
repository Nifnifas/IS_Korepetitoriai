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
        // operacija1.php
        // skirtapakeisti savo sudaryta operacija pratybose

        session_start();
        // cia sesijos kontrole
        //if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
        //{ header("Location:articles.php");exit;}
        //include("include/nustatymai.php");
        include("include/functions.php");
        include("include/meniu.php");
        if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "cvlist.php"; 
        $value = 0;
        if($_SERVER['QUERY_STRING'] == "kriminalai"){
            $value = 8;
        }
        if($_SERVER['QUERY_STRING'] == "politika"){
            $value = 7;
        }
        if($_SERVER['QUERY_STRING'] == "maistas"){
            $value = 6;
        }
        if($_SERVER['QUERY_STRING'] == "menas"){
            $value = 5;
        }
        if($_SERVER['QUERY_STRING'] == "gyvenimas"){
            $value = 4;
        }
        if($_SERVER['QUERY_STRING'] == "verslas"){
            $value = 3;
        }
        if($_SERVER['QUERY_STRING'] == "mokslas"){
            $value = 2;
        }
        if($_SERVER['QUERY_STRING'] == "sportas"){
            $value = 1;
        }
        if($value > 0){
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                $query = "SELECT article_id, category_name, title, text, username, time_stamp, statusas, views "
                    . "FROM " . TBL_ARTICLES . ", " . TBL_USERS . ", " . TBL_CATEGORIES . " WHERE fk_user_id = userid AND category = category_id AND category_id = $value AND statusas = 2"
                        . " ORDER BY time_stamp DESC";
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Straipsnių nėra!</td></tr></table><br>";exit;}
        }
        if($value == 0){
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                $query = "SELECT cv_id, antraste, tekstas, kaina, dalykas, data, internetu, fk_vartotojo_id "
                    . "FROM " . TBL_CVS . " ORDER BY data DESC LIMIT 5";
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>CV nėra!</td></tr></table><br>";exit;}
        }
        if($_SERVER['QUERY_STRING'] == "skaitomiausi"){
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                $query = "SELECT article_id, category_name, title, text, username, time_stamp, statusas, views "
                    . "FROM " . TBL_ARTICLES . ", " . TBL_USERS . ", " . TBL_CATEGORIES . " WHERE fk_user_id = userid AND category = category_id AND statusas = 2"
                        . " ORDER BY views DESC  LIMIT 5";
                $result = mysqli_query($db, $query);
                if (!$result || (mysqli_num_rows($result) < 1))  
                                {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Straipsnių nėra!</td></tr></table><br>";exit;}
        }


        
?>
    <table class="center" style="border-color: white;"><br><br><tr><td>
    <?php
    $header = strtoupper($_SERVER['QUERY_STRING']);
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
                            /*echo "<form action='editArticle.php' method='POST'><input name='article_id' value='$row[article_id]' hidden><button class=\"btn btn-outline-warning\" type='submit' name='submit'>Redaguoti</button></form>"
                                         ."</td><td>" . "<form action=\"procArticleDelete.php\" method=\"post\" onsubmit=\"return confirm('Ar tikrai norite ištrinti šį straipsnį?');\"><button class=\"btn btn-outline-danger\" type=\"submit\">Šalinti</button><input type=\"hidden\" name=\"article_id\" value=\"$row[article_id]\">";
                            echo "</form></td></tr>";*/
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
        }
        else if ($user == "guest") { ?>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Naujausi straipsniai</th>
                </tr>
              </thead>
              <tbody> <?php
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                echo "<form action='readGuest.php' method='POST'><input name='article_id' value='$row[article_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[title]</button></form></td></tr>";
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
            
        }
        else{ ?>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Naujausi straipsniai</th>
                </tr>
              </thead>
              <tbody> <?php
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $cc++ . "</button></th><td>";
                echo "<form action='read.php' method='POST'><input name='article_id' value='$row[article_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[title]</button></form></td></tr>";
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
            
        }
        mysqli_close($db);
?>
    </td></tr>
    </table><br>		
    </div><br></table>
</body>
</html>