<!DOCTYPE html>
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
        <table class="center"><tr><td>
            <center><a href="index.php"><img src="include/banners/main-banner.png"/></a></center>
        </td></tr><tr><td> 

<?php
session_start(); 

  include("include/nustatymai.php");
  include("include/functions.php");
          if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[DEFAULT_LEVEL]))   {redirect("logout.php");exit;}
        $_SESSION['prev'] = "procnewclassmember.php";
  $fk_mokytojo_id = $_POST['mokytojo_id'];
  $fk_klases_id = getClassID($fk_mokytojo_id, "Dabartiniai");
  $fk_klases_id2 = $fk_klases_id + 1;
  $fk_user_id = $_SESSION['userid'];
  $busena = $_POST['busena'];
  $fk_cv_id = $_POST['cv_id'];
  $_SESSION['bsn_input']="$busena";
            // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
                $zl = "SELECT * FROM " . TBL_KLASES_NARIAI . " WHERE `fk_vartotojo_id` = '$fk_user_id' AND `fk_klases_id` = '$fk_klases_id2'";
                $z_result = mysqli_query($conn, $zl);
                if (mysqli_num_rows($z_result) == 1)
                {
                    $sql = "UPDATE " . TBL_KLASES_NARIAI . " SET `busena`= DEFAULT(busena), `fk_klases_id` = '$fk_klases_id' WHERE `fk_klases_id` = '$fk_klases_id2' AND `fk_vartotojo_id` = '$fk_user_id'";
                    
                    if (mysqli_query($conn, $sql)) {
                        echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Užsirašėte sėkmingai. Laukite mokytojo patvirtinimo!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                        $_SESSION['art'] = $fk_cv_id;
                        header( "refresh:2;url=read.php");
                    } else {
                       echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    
                }
                else{
                            $sql = "INSERT INTO " . TBL_KLASES_NARIAI . " (
                            fk_klases_id, 
                            fk_vartotojo_id 
                        )
                        VALUES (
                            '$fk_klases_id',
                                '$fk_user_id'
                            )";

                    if (mysqli_query($conn, $sql)) {
                            echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Užsirašėte sėkmingai. Laukite mokytojo patvirtinimo!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                            $_SESSION['art'] = $fk_cv_id;
                            header( "refresh:2;url=read.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
                mysqli_close($conn);
                
            
?>
        </td></tr></table>
      </body>
</html>