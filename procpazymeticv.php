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
        
    </body>
</html>
<?php
session_start(); 

  include("include/nustatymai.php");
  include("include/functions.php");
        if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest")   {redirect("logout.php");exit;}
        $_SESSION['prev'] = "proccv.php";
  $busena = $_POST['busena'];
  $fk_cv_id = $_POST['cv_id'];
  $fk_user_id = $_SESSION['userid'];
  $_SESSION['busena_input']="$busena";
    if($busena == "1"){
            // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO " . TBL_PAZYMETI . " (
                    fk_cv_id, 
                    fk_vartotojo_id 
                )
                VALUES (
                    '$fk_cv_id',
                        '$fk_user_id'
                    )";

            if (mysqli_query($conn, $sql)) {
                echo "<br><br><br><h3>Sėkmingai pažymėta!</h3>";
                $_SESSION['art'] = $fk_cv_id;
                header("Location:read.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
    }
    if($busena == "2"){
              // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "DELETE FROM " . TBL_PAZYMETI . " WHERE fk_cv_id = '$fk_cv_id' AND fk_vartotojo_id = '$fk_user_id'";
            if(mysqli_query($conn, $sql)){
                echo "<br><br><br><h3>Ištrinta sėkmingai!</h3>";
                $_SESSION['art'] = $fk_cv_id;
                header("Location:read.php");
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
    }
?>
  
  