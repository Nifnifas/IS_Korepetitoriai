<?php
//nustatymai.php

define("DB_SERVER", "localhost");
define("DB_USER", "aus14274_lukkru2");
define("DB_PASS", "Siokoledas77");
define("DB_NAME", "aus14274_korepetitoriai");
define("TBL_USERS", "vartotojas");
define("TBL_CVS", "cv");
define("TBL_PAZYMETI", "pazymeti_cv");
define("TBL_COMMENTS", "komentaras");
define("TBL_CLASS", "klase");
define("TBL_KLASES_NARIAI", "klases_nariai");
define("TBL_IVERTINIMAS", "ivertinimas");
define("TBL_REPORTUOTI", "reportuoti_cv");

$user_roles=array(      // vartotojų rolių vardai lentelėse ir  atitinkamos userlevel reikšmės
	"Mokytojas"=>"5",
	"Mokinys"=>"1",
        "Administratorius"=>"10");   // 
define("DEFAULT_LEVEL","Mokinys");  // paprasciausia role
define("MOKYTOJAS_LEVEL","Mokytojas");  // mokytojo role
define("ADMIN_LEVEL","Administratorius"); // admin role
?>
