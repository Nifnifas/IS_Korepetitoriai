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

  include("include/nustatymai.php");
  include("include/functions.php");
 if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[MOKYTOJAS_LEVEL]))   {redirect("logout.php");exit;}
  $_SESSION['prev'] = "deleteStudentFromClass.php";
  $id = $_POST['vartotojo_id'];
  $fk_klases_id = $_POST['klases_id'];
  $nKlases_id = $fk_klases_id + 1;
  $status = $_POST['status_id'];

// Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "UPDATE " . TBL_KLASES_NARIAI . " SET `busena`= '$status', `fk_klases_id` = '$nKlases_id' WHERE `fk_klases_id` = '$fk_klases_id' AND `fk_vartotojo_id` = '$id'";

            if (mysqli_query($conn, $sql)) {
                 echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Mokinys sėkmingai išmestas iš klasės!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                header( "refresh:2;url=myclass.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
mysqli_close($conn);
//header("Location:articles.php");exit;
?>
        </td></tr></table>                       
      </body>
</html>
  