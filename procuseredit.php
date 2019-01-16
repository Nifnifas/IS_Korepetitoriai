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
// cia sesijos kontrole
if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest" || $_SESSION['prev'] != "useredit")   {redirect("logout.php");exit;}

  include("include/nustatymai.php");
  include("include/functions.php");
  $_SESSION['prev'] = "procuseredit";
  $_SESSION['pass_error']="";
  $_SESSION['mail_error']="";
  $_SESSION['passn_error']="";
  $user=$_SESSION['user'];
  $userid=$_SESSION['userid'];
  $pass=$_POST['oldpass'];$_SESSION['pass_login']=$pass;    //senas
  $passn=$_POST['passn'];$_SESSION['passn_login']=$passn;   //naujas
  $mail=$_POST['email']; $_SESSION['mail_login']=$mail; 

  $ar_pass = checkPass($pass,substr(hash('sha256',$pass),5,32));
  $ar_teisingas = verifyPass(substr(hash('sha256',$pass),5,32), $userid);
  
  if($ar_pass && $ar_teisingas){
                $ar_mail = checkMail($mail);                        // ar geras epasto laukas
                if($mail == $user){
                    $ar_mail_db = true;
                }
                else {
                    $ar_mail_db = checkEmailDB($mail);
                }
                
                if ($ar_mail && $ar_mail_db){ 
                    if (isset($passn)){
                        $ar_passn = checkPass($passn,substr(hash('sha256',$passn),5,32));
                        $_SESSION['passn_error']=$_SESSION['pass_error'];$_SESSION['pass_error']="";
                        if($ar_passn && ($pass != $passn)){
                            $dbpass=substr(hash('sha256',$passn),5,32);
                            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            $sql = "UPDATE ". TBL_USERS." SET slaptazodis='$dbpass' ,  el_pastas='$mail'   WHERE  vartotojo_id='$userid'";
                            if (!mysqli_query($db, $sql)) {
                                echo " DB klaida keiciant slaptazodi ir epasto adresa: " . $sql . "<br>" . mysqli_error($db);
                                exit;
                            }
		            $_SESSION['message']="Paskyra sėkmingai atnaujinta! Prisijunkite iš naujo.";
                                $_SESSION['user'] = "guest";
                                $_SESSION['ulevel'] ="0";
                                $_SESSION['urole'] ="Svečias";
                            header("Location:login.php");exit; 
                        } 
                        if($passn == "") {
                            
                            $_SESSION['passn_error']="";
                            $_SESSION['message']="Pakeitimų nerasta!";
                            header("Location:useredit.php");exit; 
                        }
                        else{
                            header("Location:useredit.php");exit; 
                        }
                    }
                    else{
                            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            $sql = "UPDATE ". TBL_USERS." SET el_pastas='$mail'   WHERE  vartotojo_id='$userid'";
                            if (!mysqli_query($db, $sql)) {
                                echo " DB klaida keičiant el. pašto adresą: " . $sql . "<br>" . mysqli_error($db);
                                exit;
                            }
		            $_SESSION['message']="Paskyra sėkmingai atnaujinta! Prisijunkite iš naujo.";
                                $_SESSION['user'] = "guest";
                                $_SESSION['ulevel'] ="0";
                                $_SESSION['urole'] ="Svečias";
                            header("Location:login.php");exit;
                    }
	  }
  }
  
   // taisyti
   $_SESSION['message']="Klaida!";
  // session_regenerate_id(true);
   header("Location:useredit.php");exit;
?>
  
  