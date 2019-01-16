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
        
    </body>
</html>
<?php
// proclogin.php tikrina prisijungimo reikšmes
// formoje įvestas reikšmes išsaugo $_SESSION['xxxx_login']
// jei randa klaidų jas sužymi $_SESSION['xxxx_error']
// jei vardas ir slaptažodis tinka, užpildo $_SESSION['user'] ir $_SESSION['ulevel'],$_SESSION['userid'],$_SESSION['umail']  atžymi prisijungimo laiką DB
// po sėkmingo arba ne bandymo jungtis vėl nukreipia i index.php
//
// jei paspausta "Pamiršote slaptažodį", formoje turi būti jau įvestas vardas , nukreips į forgotpass.php, o ten pabars ir į newpass.php

session_start(); 
// cia sesijos kontrole: proclogin tik is login  :palikti taip
  if (!isset($_SESSION['prev']) || $_SESSION['user'] != "guest")   {redirect("logout.php");exit;}

  include("include/nustatymai.php");
  include("include/functions.php");
  $_SESSION['prev'] = "proclogin";
  $_SESSION['mail_error']="";
  $_SESSION['pass_error']="";

 
  $userEmail=strtolower($_POST['mail']);   // i mazasias raides      
  $pass=$_POST['pass']; $_SESSION['pass_login']=$pass;
  
  $_SESSION['mail_login']=$userEmail;
  $_SESSION['mail_input']=$userEmail;
  
  checkMail($userEmail);
  checkPass($pass,substr(hash('sha256',$pass),5,32));
  
  if(checkMail($userEmail) && checkPass($pass,substr(hash('sha256',$pass),5,32))){
      if(checkIfUserIsBlocked($userEmail)){
          $pass=substr(hash('sha256',$pass),5,32); 
            if(verifyLogin($userEmail, $pass))
            {
                //prijungiam
                                $time=time();  // irasom kada sekmingai prisijunge paskutini karta
                                $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                                $sql = "UPDATE ". TBL_USERS." SET prisijungimo_laikas=NOW() WHERE  el_pastas='$userEmail'";
                                               if (!mysqli_query($db, $sql)) {
                         echo " DB klaida įrašant timestamp: " . $sql . "<br>" . mysqli_error($db);
                                     exit;}
                    getUserID($userEmail);
                    $_SESSION['user']=$userEmail;
                                $_SESSION['prev']="proclogin";
                    $_SESSION['message']="";
                    header("Location:index.php");exit;
            }
            else{
            $_SESSION['message']="Blogi prisijungimo duomenys!";
            header("Location:login.php");exit;
            }
      }
      else{
          $_SESSION['message']="Jūs esate užblokuotas!";
            header("Location:login.php");exit;
      }
  }
  else{
      $_SESSION['message']="Blogi prisijungimo duomenys!";
      header("Location:login.php");exit;
  }
  
     ?>
  