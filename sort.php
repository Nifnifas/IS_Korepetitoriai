<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <br>
    <?php
    session_start();
    if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
    $_SESSION['prev'] = "sort.php";
    $subject = $_POST['subject'];
    $place = $_POST['place'];
    $_SESSION['place_input'] = $place;
    $_SESSION['subject_input'] = $subject;
    include("include/meniu.php");
    include("include/functions.php");
    $_SESSION['place_input'] = "";
    $_SESSION['subject_input'] = "";
    
    
    if($subject == "Visi dalykai" && $place == "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_CVS;
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
    if($subject == "Visi dalykai" && $place != "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_CVS . " WHERE miestas = '$place'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
    if($subject != "Visi dalykai" && $place == "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_CVS . " WHERE dalykas = '$subject'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
    if($subject != "Visi dalykai" && $place != "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_CVS . " WHERE dalykas = '$subject' AND miestas = '$place'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
   ?>
        <table class="center" style="border-color: white;"><br><br><tr><td>
        
        <table class="table">
            <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="6">Paieškos rezultatai</th>
                </tr>
              </thead>
              <thead class="thead-light">
                <tr>
                  <th scope="col"></th>
                  <th scope="col" style="text-align: center">Antraštė</th>
                  <th scope="col" style="text-align: center">Dalykas</th>
                  <th colspan="2" style="text-align: center"></th>
                </tr>
              </thead>
              <tbody> <?php
                        $count = 1;
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$row[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[antraste]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['dalykas'] . "</b></td></tr>";
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
    mysqli_close($db);
?>
                </td></tr>
	</table><br>
        </td></tr></table>
    </body>
</html>
