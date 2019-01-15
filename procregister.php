<html>
    <head>
        <title>IS Zurnalo redakcija</title>
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
// procregister.php tikrina registracijos reikšmes
// įvedimo laukų reikšmes issaugo $_SESSION['xxxx_login'], xxxx-name, pass, mail
// jei randa klaidų jas sužymi $_SESSION['xxxx_error']
// jei vardas, slaptažodis ir email tinka, įraso naują vartotoja į DB, nukreipia į index.php
// po klaidų- vel į register.php 

session_start(); 
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || $_SESSION['user'] != "guest" || $_SESSION['prev'] != "register")   {redirect("logout.php");exit;}

  include("include/nustatymai.php");
  include("include/functions.php");
 
  $_SESSION['name_error']="";
  $_SESSION['surname_error']="";
  $_SESSION['pass_error']="";
  $_SESSION['mail_error']="";
  $_SESSION['type_error']="";
  $_SESSION['phone_error']="";
  $userEmail=strtolower($_POST['email']);$_SESSION['mail_login']=$userEmail; 
  $pass=$_POST['pass'];$_SESSION['pass_login']=$pass;
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $phone = $_POST['phone'];
  $userType = $_POST['userType'];
  date_default_timezone_set('Europe/Vilnius');
  $time = date("Y-m-d H:i:s");
  
  $_SESSION['name_input'] = $name;
  $_SESSION['surname_input'] = $surname;
  $_SESSION['phone_input'] = $phone;
  $_SESSION['mail_input'] = $userEmail;
  $_SESSION['userType_input'] = "$userType";
  
  $_SESSION['prev'] = "procregister";

    // registracijos formos lauku  kontrole
    checkName($name);
    checkSurname($surname);
    checkPhone($phone);
    checkMail($userEmail);
    checkPass($pass,substr(hash('sha256',$pass),5,32));
    checkType($userType);
    checkEmailDB($userEmail);
    if(checkName($name) && checkSurname($surname) && checkMail($userEmail) && checkType($userType) && checkPhone($phone) && checkPass($pass,substr(hash('sha256',$pass),5,32)) && checkEmailDB($userEmail)){
        $userid=md5(uniqid($userEmail));                          //naudojam toki userid
        $pass=substr(hash('sha256',$pass),5,32);     // DB password skirti 32 baitai, paimam is maisos vidurio 
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "INSERT INTO " . TBL_USERS. " (vartotojo_id, vardas, pavarde, el_pastas, slaptazodis, telefono_nr, statusas, prisijungimo_laikas)
               VALUES ('$userid', '$name', '$surname','$userEmail', '$pass', '$phone', '$userType', '$time')";
        if (mysqli_query($db, $sql)){
            if($userType == "1"){
               $dabartiniai = "INSERT INTO " . TBL_CLASS. " (rusis, fk_vartotojo_id)
                                VALUES ('1', '$userid')";
                mysqli_query($db, $dabartiniai);
                $buvusieji = "INSERT INTO " . TBL_CLASS. " (rusis, fk_vartotojo_id)
                                VALUES ('2', '$userid')";
                mysqli_query($db, $buvusieji);
            }
            $_SESSION['message']="Registracija sėkminga! Dabar galite prisijungti.";
        }
        else {
            $_SESSION['message']="DB registracijos klaida:" . $sql . "<br>" . mysqli_error($db);
        }
        header("Location:login.php");exit;
    }
    else{
        // griztam taisyti
        header("Location:register.php");exit;
    }
 
?>
  
  