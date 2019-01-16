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
    if (!isset($_SESSION['prev']) || (($_SESSION['ulevel'] != $user_roles[DEFAULT_LEVEL]) && ($_SESSION['ulevel'] != $user_roles[MOKYTOJAS_LEVEL])))   {redirect("logout.php");exit;}
        $_SESSION['prev'] = "proccv.php";

  $file_name = $_FILES['upload']['name'];
  $imageFileType = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
  $file_type = $_FILES['upload']['type'];
  $file_tmp_name = $_FILES['upload']['tmp_name'];
 $imgDimensions = true;
 if($file_name != ""){
    $image_info = getimagesize($file_tmp_name);
    $image_width = $image_info[0];
    $image_height = $image_info[1];
     if($image_height != 250 && $image_width != 250){
         $_SESSION['image_error']="<font size=\"2\" color=\"#ff0000\">* Dydis privalo būti 250x250!</font>";
         $imgDimensions = false;
     }
 }
  $file_size = $_FILES['upload']['size'];
  $antraste = $_POST['antraste'];
  $dalykas = $_POST['dalykas'];
  $tekstas = $_POST['tekstas'];
  $miestas = $_POST['miestas'];
  $internetu = $_POST['internetu'];
  date_default_timezone_set('Europe/Vilnius');
  $time = date("Y-m-d H:i:s");
  $fk_user_id = $_SESSION['userid'];
  $userlevel = $_SESSION['ulevel'];
  $_SESSION['letters_error']="";
  $_SESSION['dalykas_error']="";
  $_SESSION['tekstas_error']="";
  $_SESSION['miestas_error']="";
  $_SESSION['internetu_error']="";
  $_SESSION['antraste_input']="$antraste";
  $_SESSION['dalykas_input']="$dalykas";
  $_SESSION['tekstas_input']="$tekstas";
  $_SESSION['miestas_input']="$miestas";
  $_SESSION['internetu_input']="$internetu";
  $priceStatus = false;
  if($userlevel == 1){
      $kaina = "0";
      $priceStatus = true;
  }
  if($userlevel == 5){
      $kaina = $_POST['kaina'];
      $_SESSION['kaina_error']="";
      $_SESSION['kaina_input']="$kaina";
      $priceStatus = checkForPrice($kaina, "kaina_error");
  }
  $imgStatus = true;
  if($file_name != ""){
      $imgStatus = checkForImage($imageFileType);
  }

  checkForInput($antraste, "letters_error");  
  checkForInput($tekstas, "tekstas_error");
  checkForDropSelection($dalykas, "dalykas_error");
  checkForDropSelection($miestas, "miestas_error");
  checkForRadioButton($internetu, "internetu_error");
if($imgDimensions && $imgStatus && checkForInput($antraste, "letters_error") && checkForInput($tekstas, "tekstas_error") && checkForDropSelection($dalykas, "dalykas_error") && checkForDropSelection($miestas, "miestas_error") &&  $priceStatus
        && checkForRadioButton($internetu, "internetu_error")){
    if($_SESSION['cv_busena'] == "sukurimas"){
            // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset("utf8");
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "INSERT INTO " . TBL_CVS . " (
                    antraste, 
                    tekstas,
                    miestas,
                    kaina,
                    dalykas,
                    data,
                    internetu,
                    fk_vartotojo_id
                )
                VALUES (
                    '$antraste',
                        '$tekstas',
                            '$miestas',
                                '$kaina',
                                    '$dalykas',
                                        '$time',
                                            '$internetu',
                                                '$fk_user_id'

                    )";

            if (mysqli_query($conn, $sql)) {
                if(isset($_FILES['upload']))
                {
                    // target directory
                    $target_dir = "uploads/";

                    // uploding file
                    if(move_uploaded_file($file_tmp_name,$target_dir.$file_name))
                    {
                            $ql = "UPDATE " . TBL_USERS . " SET profilio_nuotrauka='$target_dir$file_name' WHERE vartotojo_id='$fk_user_id'";
                            mysqli_query($conn, $ql);
                            echo "<h3></h3>";
                    }
                    else
                    {
                            echo "<h3></h3>";
                    }
                }
                echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Jūsų CV sėkmingai sukurtas!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                header( "refresh:2;url=read.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
    }
    if($_SESSION['cv_busena'] == "redagavimas"){
              // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset("utf8");
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "UPDATE " . TBL_CVS . " SET antraste='$antraste', tekstas='$tekstas', miestas='$miestas', kaina='$kaina', dalykas='$dalykas', data='$time', internetu='$internetu' WHERE fk_vartotojo_id='$fk_user_id'";

            if (mysqli_query($conn, $sql)) {
                // check for uploaded file
	if(isset($_FILES['upload']))
	{
		// target directory
		$target_dir = "uploads/";
	
		// uploding file
		if(move_uploaded_file($file_tmp_name,$target_dir.$file_name))
		{
			$ql = "UPDATE " . TBL_USERS . " SET profilio_nuotrauka='$target_dir$file_name' WHERE vartotojo_id='$fk_user_id'";
			mysqli_query($conn, $ql);
                        echo "<h3></h3>";
		}
		else
		{
			echo "<h3></h3>";
		}
	}
                echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Jūsų CV sėkmingai atnaujintas!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                header( "refresh:2;url=read.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
    }
}
else{
        // griztam taisyti
        header("Location:newcv.php");exit;
}
?>
        </td></tr></table>
      </body>
</html>