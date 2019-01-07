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
        
    </body>
</html>

<?php
session_start(); 

  include("include/nustatymai.php");
  include("include/functions.php");
 if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   { header("Location: logout.php");exit;}
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
                echo "<br><br><br><h3>Mokinys sėkmingai išmestas iš klasės!</h3>";
                header( "refresh:2;url=myclass.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
mysqli_close($conn);
//header("Location:articles.php");exit;
?>
  
  