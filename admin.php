<html>
    <head>
        <title>Vartotojų valdymas</title>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><img src="include/banners/main-banner.png"></center>
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
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   { header("Location: logout.php");exit;}
$_SESSION['prev']="admin";
?>

		<form name="vartotojai" action="procadmin.php" method="post">

<?php
    
	$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
	$sql = "SELECT * "
            . "FROM " . TBL_USERS . " ORDER BY prisijungimo_laikas ASC,pavarde";
	$result = mysqli_query($db, $sql);
	if (!$result || (mysqli_num_rows($result) < 1))  
			{echo "Klaida skaitant lentelę users"; exit;}
?>
    <table class="center"  border="1" cellspacing="0" cellpadding="3">
    <tr><td><b>Vartotojo vardas</b></td><td><b>Rolė</b></td><td><b>E-paštas</b></td><td><b>Paskutinį kartą aktyvus</b></td><td><b>Šalinti?</b></td></tr>
<?php
        while($row = mysqli_fetch_assoc($result)) 
	{	 
	    $level=$row['statusas']; 
	  	$user= $row['vardas'] . " " . $row['pavarde'];
	  	$email = $row['el_pastas'];
      	$time = date("Y-m-d G:i", strtotime($row['prisijungimo_laikas']));
      	echo "<tr><td>".$user. "</td><td>";
    	echo "<select name=\"role_".$user."\">";
      	$yra=false;
		foreach($user_roles as $x=>$x_value)
  			{echo "<option ";
        	 if ($x == $level) {$yra=true;echo "selected ";}
             echo "value=\"".$x_value."\" ";
         	 echo ">".$x."</option>";
        	 }
		if (!$yra)
        {echo "<option selected value=".$level.">Botas=".$level."</option>";}
        $UZBLOKUOTAS=UZBLOKUOTAS; echo "<option ";
        if ($level == UZBLOKUOTAS) echo "selected ";
          echo "value=".$UZBLOKUOTAS." ";
        echo ">Užblokuotas</option>";      // papildoma opcija
      echo "</select></td>";
          
      echo "<td>".$email."</td><td>".$time."</td>";
      echo "<td><input type=\"checkbox\" name=\"naikinti_".$user."\">";
   }
?>
        </table>
                    <br> <center><input type="submit" class="btn btn-primary" value="Vykdyti"></center><br>
                                </td></tr>
                </table><br><br>
        </form>
    </body></html>
