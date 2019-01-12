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
            else if($arg == "msg"){
                $_SESSION['message']="";
            }
            else{
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
                $_SESSION['antraste_input']="";
                $_SESSION['dalykas_input']="";
                $_SESSION['tekstas_input']="";
                $_SESSION['kaina_input']="";
                $_SESSION['miestas_input']="";
                $_SESSION['internetu_input']="";
                $_SESSION['letters_error']="";
                $_SESSION['dalykas_error']="";
                $_SESSION['tekstas_error']="";
                $_SESSION['kaina_error']="";
                $_SESSION['internetu_error']="";
                $_SESSION['miestas_error']="";
                $_SESSION['place_input']="";
                $_SESSION['subject_input']="";
                $_SESSION['image_error']="";
                $_SESSION['art']="";
            }	
        }


function checkName ($name){   // Vartotojo vardo sintakse
	   if (!$name || strlen($name = trim($name)) == 0) 
			{$_SESSION['name_error']=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas vardas</font>";
			 "";
			 return false;}
            else if (!preg_match("/^([a-žA-Ž])*$/", $name))  /* Check if username is not alphabetic */ 
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
            else if (!preg_match("/^([a-žA-Ž])*$/", $surname))  /* Check if username is not alphabetic */ 
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
 
function verifyLogin($userMail, $pass){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_USERS . " WHERE `el_pastas` = '$userMail' AND `slaptazodis` = '$pass'";
    $result = mysqli_query($db, $sql);
    if (!$result || (mysqli_num_rows($result) != 1)) // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
                {
                        $_SESSION['message']=
				"<font size=\"2\" color=\"#ff0000\">Klaidingi duomenys!</font>";
                    return false;
                }
                else {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['urole'] = $row['statusas'];
                    $_SESSION['ulevel'] = setUserLevel($_SESSION['urole']);
                    return true;
                }
 }
 
 function verifyPass($pass, $userid){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_USERS . " WHERE `vartotojo_id` = '$userid' AND `slaptazodis` = '$pass'";
    $result = mysqli_query($db, $sql);
    if (!$result || (mysqli_num_rows($result) != 1)) // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
                {
                        $_SESSION['pass_error']=
				"<font size=\"2\" color=\"#ff0000\">Ne toks slaptažodis!</font>";
                    return false;
                }
                else {
                    return true;
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

function setUserLevel($userType){
    if($userType == "Mokinys"){
        $level = "1";
    }
    if($userType == "Mokytojas"){
        $level = "5";
    }
    if($userType == "Administratorius"){
        $level = "10";
    }
    return $level;
}

function getUserID($userEmail){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_USERS . " WHERE `el_pastas` = '$userEmail'";
    $result = mysqli_query($db, $sql);
    if (!$result || (mysqli_num_rows($result) != 1)) // jei >1 tai DB vardas kartojasi, netikrinu, imu pirma
                {
                    return false;
                }
                else {
                    $row = mysqli_fetch_array($result);
                    $_SESSION['userid'] = $row['vartotojo_id'];
                    return true;
                }
}

function checkForInput ($text, $error_name){
	   if (!$text || strlen($text = trim($text)) == 0) 
			{$_SESSION[$error_name]=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas laukelis</font>";
			 "";
			 return false;}
                     elseif (strlen($text)<5)  // per trumpas arba per ilgas
			         {$_SESSION[$error_name]=
						  "<font size=\"2\" color=\"#ff0000\">* Turi būti panaudoti daugiau nei 5 simboliai</font>";
		              return false;}
	        else return true;
}

function checkForDropSelection($selected, $error_name){
    if($selected > 0 || $selected != "Pasirinkite..."){
        return true;
    }
    else{
        $_SESSION[$error_name]="<font size=\"2\" color=\"#ff0000\">* Nepasirinktas laukelis</font>";
			 "";
        return false;
    }
}

function checkForPrice ($text, $error_name){
	   if (!$text || strlen($text = trim($text)) == 0) 
			{$_SESSION[$error_name]=
				 "<font size=\"2\" color=\"#ff0000\">* Neįvestas laukelis</font>";
			 "";
			 return false;}
                     elseif (strlen($text)>2)  // per trumpas arba per ilgas
			         {$_SESSION[$error_name]=
						  "<font size=\"2\" color=\"#ff0000\">* Maksimalus skaitmenų kiekis - 2</font>";
		              return false;}
                              else if (!preg_match("/^([0-9])*$/", $text))
			{$_SESSION[$error_name]=
				"<font size=\"2\" color=\"#ff0000\">* Neleistinas formatas. Leistini tik sveikieji skaičiai</font>";
		     return false;}
	        else return true;
}

function getUserLookupType($userlevel){
    if($userlevel == 1){
        $tipas = "Mokytojas";
    }
    if($userlevel == 5){ 
        $tipas = "Mokinys";
    }
    if($userlevel == 0){ 
        $tipas = "Svecias";
    }
    if($userlevel == 10){ 
        $tipas = "Svecias";
    }
    return $tipas;
}

function  autolink($message) { 
    //Convert all urls to links
    $message = preg_replace('#([\s|^])(www)#i', '$1http://$2', $message);
    $pattern = '#((http|https|ftp|telnet|news|gopher|file|wais):\/\/[^\s]+)#i';
    $replacement = '<a href="$1" target="_blank">$1</a>';
    $message = preg_replace($pattern, $replacement, $message);

    /* Convert all E-mail matches to appropriate HTML links */
    $pattern = '#([0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.';
    $pattern .= '[a-wyz][a-z](fo|g|l|m|mes|o|op|pa|ro|seum|t|u|v|z)?)#i';
    $replacement = '<a href="mailto:\\1">\\1</a>';
    $message = preg_replace($pattern, $replacement, $message);
    return $message;
}

function getClassID($userid, $rusis){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT klases_id FROM " . TBL_CLASS . " WHERE `fk_vartotojo_id` = '$userid' AND `rusis` = '$rusis' LIMIT 1";
    $result = mysqli_query($db, $sql) or die(mysqli_error());
    $row = mysqli_fetch_assoc($result);
    return $row['klases_id'];
}
    
function getClassCount($classid, $rusis){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM " . TBL_KLASES_NARIAI . " WHERE `fk_klases_id` = '$classid' AND `busena` = '$rusis'";
    $result = mysqli_query($db, $sql) or die(mysqli_error());
    return mysqli_num_rows($result);
}
    
function getCurrentRating($userid){
    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT verte FROM " . TBL_IVERTINIMAS . " WHERE `skirtas_id` = '$userid'";
    $result = mysqli_query($db, $sql) or die(mysqli_error());
    $bendraSuma = 0;
    $count = 0;
    while($row = mysqli_fetch_array($result)){
        $bendraSuma += $row['verte'];
        $count++;
    }
    if($bendraSuma == 0){
        return 0;
    }
    else{
        return $bendraSuma / $count;
    }
}

function checkForImage ($imageFileType){
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $_SESSION['image_error'] = "<font size=\"2\" color=\"#ff0000\">* Failo formatas privalo būti jpg, jpeg arba png!</font>";
            return false;
        }
        return true;
}

 ?>
 