<?php
// funkcijos  include/functions.php

function inisession($arg) {   //valom sesijos kintamuosius
            if($arg =="full"){
                $_SESSION['message']="";
                $_SESSION['user']="";
	       		$_SESSION['ulevel']=0;
				$_SESSION['userid']=0;
				$_SESSION['umail']=0;
            }			    	 
		$_SESSION['name_login']="";
		$_SESSION['pass_login']="";
		$_SESSION['mail_login']="";
		$_SESSION['name_error']="";
                $_SESSION['surname_error']="";
                $_SESSION['pass_error']="";
		$_SESSION['mail_error']="";
                $_SESSION['type_error']="";
                $_SESSION['phone_error']="";
                $_SESSION['name_input']="";
                $_SESSION['surname_input']="";
                $_SESSION['phone_input']="";
                $_SESSION['mail_input']="";
                $_SESSION['userType_input']="";
        }

function checkName ($name){   // Vartotojo vardo sintakse
	   if (!$name || strlen($name = trim($name)) == 0) 
			{$_SESSION['name_error']=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas vardas</font>";
			 "";
			 return false;}
            else if (!preg_match("/^([a-zA-Z])*$/", $name))  /* Check if username is not alphabetic */ 
			{$_SESSION['name_error']=
				"<font size=\"2\" color=\"#ff0000\">* Galimos tik raidės</font>";
		     return false;}
	        else return true;
}

function checkSurname ($surname){   // Vartotojo vardo sintakse
	   if (!$surname || strlen($surname = trim($surname)) == 0) 
			{$_SESSION['surname_error']=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvesta pavardė</font>";
			 "";
			 return false;}
            else if (!preg_match("/^([a-zA-Z])*$/", $surname))  /* Check if username is not alphabetic */ 
			{$_SESSION['surname_error']=
				"<font size=\"2\" color=\"#ff0000\">* Galimos tik raidės</font>";
		     return false;}
	        else return true;
}
             
 function checkPass($pwd,$dbpwd) {     //  slaptazodzio tikrinimas (tik demo: min 4 raides ir/ar skaiciai) ir ar sutampa su DB esanciu
	   if (!$pwd || strlen($pwd = trim($pwd)) == 0) 
			{$_SESSION['pass_error']=
			  "<font size=\"2\" color=\"#ff0000\">* Neįvestas slaptažodis</font>";
			 return false;}
            elseif (!preg_match("/^([0-9a-zA-Z])*$/", $pwd))  /* Check if $pass is not alphanumeric */ 
			{$_SESSION['pass_error']="<font size=\"2\" color=\"#ff0000\">* Slaptažodis sudaromas tik iš skaičių arba raidžių</font>";
		     return false;}
            elseif (strlen($pwd)<4)  // per trumpas
			         {$_SESSION['pass_error']=
						  "<font size=\"2\" color=\"#ff0000\">* Slaptažodžio ilgis <4 simbolius</font>";
		              return false;}
	          elseif ($dbpwd != substr(hash( 'sha256', $pwd ),5,32))
               {$_SESSION['pass_error']=
				   "<font size=\"2\" color=\"#ff0000\">* Neteisingas slaptažodis</font>";
                return false;}
            else return true;
   }
 
 function checkEmailDB($userMail){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_USERS . " WHERE `el_pastas` = '$userMail'";
    $result = mysqli_query($db, $sql);
    if (!$result || (mysqli_num_rows($result) != 1)) // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
                {  // neradom vartotojo DB
		   return true;
                }
                else {
                    $_SESSION['mail_error']=
				"<font size=\"2\" color=\"#ff0000\">* Toks el. paštas sistemoje jau egzistuoja!</font>";
                    return false;
                }
 }

function checkMail($mail) {   // e-mail sintax error checking  
	   if (!$mail || strlen($mail = trim($mail)) == 0) 
			{$_SESSION['mail_error']=
				"<font size=\"2\" color=\"#ff0000\">* Neįvestas e-pašto adresas</font>";
			   return false;}
            elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) 
			      {$_SESSION['mail_error']=
					   "<font size=\"2\" color=\"#ff0000\">* Neteisingas e-pašto adreso formatas</font>";
		            return false;}
	        else return true;
   }
   
   function checkPhone ($phone){   // Vartotojo vardo sintakse
	   if (!$phone || strlen($phone = trim($phone)) == 0) 
			{$_SESSION['phone_error']=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas telefono numeris</font>";
			 "";
			 return false;}
            else if (!preg_match("/^([0-9])*$/", $phone))  /* Check if username is not alphabetic */ 
			{$_SESSION['phone_error']=
				"<font size=\"2\" color=\"#ff0000\">* Vartotojo telefono numeris turi būti sudarytas<br>
				&nbsp;&nbsp;tik iš skaičių</font>";
		     return false;}
            elseif (strlen($phone)!=11)  // per trumpas arba per ilgas
			         {$_SESSION['phone_error']=
						  "<font size=\"2\" color=\"#ff0000\">* Telefonas turi būti iš 11 skaitmenų</font>";
		              return false;}
	        else return true;
}

function checkType($userType){
    if($userType > 0){
        return true;
    }
    else{
        $_SESSION['type_error']="<font size=\"2\" color=\"#ff0000\">* Nepasirinktas vartotojo tipas</font>";
			 "";
        return false;
    }
}
 ?>
 