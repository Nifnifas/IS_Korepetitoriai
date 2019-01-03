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
        $_SESSION['prev'] = "proccv.php";
  $antraste = $_POST['antraste'];
  $dalykas = $_POST['dalykas'];
  $tekstas = $_POST['tekstas'];
  $kaina = $_POST['kaina'];
  $internetu = $_POST['internetu'];
  date_default_timezone_set('Europe/Vilnius');
  $time = date("Y-m-d H:i:s");
  $fk_user_id = $_SESSION['userid'];
  
  $_SESSION['letters_error']="";
  $_SESSION['dalykas_error']="";
  $_SESSION['tekstas_error']="";
  $_SESSION['kaina_error']="";
  $_SESSION['internetu_error']="";
  $_SESSION['antraste_input']="$antraste";
  $_SESSION['dalykas_input']="$dalykas";
  $_SESSION['tekstas_input']="$tekstas";
  $_SESSION['kaina_input']="$kaina";
  $_SESSION['internetu_input']="$internetu";

  checkForInput($antraste, "letters_error");  
  checkForInput($tekstas, "tekstas_error");
  checkForDropSelection($dalykas, "dalykas_error");
  checkForPrice($kaina, "kaina_error");
  checkForDropSelection($internetu, "internetu_error");
if(checkForInput($antraste, "letters_error") && checkForInput($tekstas, "tekstas_error") && checkForDropSelection($dalykas, "dalykas_error") &&  checkForPrice($kaina, "kaina_error")
        && checkForDropSelection($internetu, "internetu_error")){
    // Create connection
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO " . TBL_CVS . " (
            antraste, 
            tekstas, 
            kaina,
            dalykas,
            data,
            internetu,
            fk_vartotojo_id
        )
        VALUES (
            '$antraste',
                '$tekstas',
                    '$kaina',
                        '$dalykas',
                            '$time',
                                '$internetu',
                                    '$fk_user_id'

            )";

    if (mysqli_query($conn, $sql)) {
        echo "<br><br><br><h3>Jūsų CV sėkimgai sukurtas!</h3>";
        header( "refresh:2;url=index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
else{
        // griztam taisyti
        header("Location:newcv.php");exit;
}

//header("Location:articles.php");exit;
?>
  
  