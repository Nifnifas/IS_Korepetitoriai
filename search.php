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
    include("include/meniu.php");
    include("include/functions.php");
    if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
    $_SESSION['prev'] = "search.php"; 
    
    $paieska = $_POST['paieska'];
    $kiekis = count(explode(' ', $paieska));
    if($kiekis == 1){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_USERS . " WHERE vardas LIKE '%$paieska%' OR pavarde LIKE '%$paieska%'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
    if($kiekis == 2){
        list($part1, $part2) = explode(' ', $paieska);
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM " . TBL_USERS . " WHERE vardas LIKE '%$part1%' AND pavarde LIKE '%$part2%' OR vardas LIKE '%$part2%' AND pavarde LIKE '%$part1%'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;}
    }
    if ($kiekis > 2 || $paieska == ""){
        echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>Deja nieko neradome!</td></tr></table><br>";exit;
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
                  <th scope="col" style="text-align: center">Vartotojas</th>
                  <th scope="col" style="text-align: center">Statusas</th>
                  <th colspan="2" style="text-align: center"></th>
                </tr>
              </thead>
              <tbody> <?php
                        $count = 1;
                        while($row = mysqli_fetch_array($result)){   //Creates a loop to loop through results
                            $mml = "SELECT cv_id FROM " . TBL_CVS . " WHERE fk_vartotojo_id = '$row[vartotojo_id]'";
                            $result2 = mysqli_query($db, $mml);
                            $cvrow = mysqli_fetch_array($result2);
                            echo "<tr><th scope=\"row\"><button class='btn btn-link' disabled>" . $count++ . "</button></th><td>";
                            echo "<form action='read.php' method='POST'><input name='cv_id' value='$cvrow[cv_id]' hidden><button class='btn btn-link' type='submit' name='submit'>$row[vardas] $row[pavarde]</button></form></td><td style=\"text-align: center\">";
                            echo "<button class='btn btn-link' disabled><b>" . $row['statusas'] . "</b></td></tr>";
                        }
            echo "</tbody></table>"; // start a table tag in the HTML
    mysqli_close($db);
    
    if($count-- == 0){
        echo "<b>Jūs neturite pažymėtų cv!</b>";exit;
    }
?>
                </td></tr>
	</table><br>
        </td></tr></table>
    </body>
</html>
