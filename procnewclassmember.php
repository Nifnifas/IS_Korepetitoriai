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
         if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] == 0))   { header("Location: logout.php");exit;}
        $_SESSION['prev'] = "procnewclassmember.php";
  $fk_mokytojo_id = $_POST['mokytojo_id'];
  $fk_klases_id = getClassID($fk_mokytojo_id, "Dabartiniai");
  $fk_user_id = $_SESSION['userid'];
  $busena = $_POST['busena'];
  $_SESSION['bsn_input']="$busena";
            // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO " . TBL_KLASES_NARIAI . " (
                    fk_klases_id, 
                    fk_vartotojo_id 
                )
                VALUES (
                    '$fk_klases_id',
                        '$fk_user_id'
                    )";

            if (mysqli_query($conn, $sql)) {
                echo "<br><br><br><h3>Užsirašėte sėkmingai! Laukite mokytojo patvirtinimo</h3>";
                header( "refresh:2;url=index.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
?>
  
  