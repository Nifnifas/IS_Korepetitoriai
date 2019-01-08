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
  $internetu = $_POST['internetu'];
  date_default_timezone_set('Europe/Vilnius');
  $time = date("Y-m-d H:i:s");
  $fk_user_id = $_SESSION['userid'];
  $userlevel = $_SESSION['ulevel'];
  $_SESSION['letters_error']="";
  $_SESSION['dalykas_error']="";
  $_SESSION['tekstas_error']="";
  $_SESSION['internetu_error']="";
  $_SESSION['antraste_input']="$antraste";
  $_SESSION['dalykas_input']="$dalykas";
  $_SESSION['tekstas_input']="$tekstas";
  
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

  checkForInput($antraste, "letters_error");  
  checkForInput($tekstas, "tekstas_error");
  checkForDropSelection($dalykas, "dalykas_error");
  checkForDropSelection($internetu, "internetu_error");
if(checkForInput($antraste, "letters_error") && checkForInput($tekstas, "tekstas_error") && checkForDropSelection($dalykas, "dalykas_error") &&  $priceStatus
        && checkForDropSelection($internetu, "internetu_error")){
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
                if(isset($_FILES['upload']))
	{
		// file name, type, size, temporary name
		$file_name = $_FILES['upload']['name'];
		$file_type = $_FILES['upload']['type'];
		$file_tmp_name = $_FILES['upload']['tmp_name'];
		$file_size = $_FILES['upload']['size'];
 
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
			echo "<br><h3>Pasirinkta nuotrauka negali būti įkelta!</h3>";
		}
	}
                echo "<br><br><br><h3>Jūsų CV sėkmingai sukurtas!</h3>";
                header( "refresh:2;url=index.php");
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
            
            $sql = "UPDATE " . TBL_CVS . " SET antraste='$antraste', tekstas='$tekstas', kaina='$kaina', dalykas='$dalykas', data='$time', internetu='$internetu' WHERE fk_vartotojo_id='$fk_user_id'";

            if (mysqli_query($conn, $sql)) {
                // check for uploaded file
	if(isset($_FILES['upload']))
	{
		// file name, type, size, temporary name
		$file_name = $_FILES['upload']['name'];
		$file_type = $_FILES['upload']['type'];
		$file_tmp_name = $_FILES['upload']['tmp_name'];
		$file_size = $_FILES['upload']['size'];
 
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
			echo "<br><h3>Pasirinkta nuotrauka negali būti įkelta!</h3>";
		}
	}
                echo "<br><br><br><h3>Jūsų CV sėkmingai atnaujintas!</h3>";
                header( "refresh:2;url=index.php");
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);
    }
}
else{
        // griztam taisyti
        //header("Location:newcv.php");exit;
}

//header("Location:articles.php");exit;
?>
  
  