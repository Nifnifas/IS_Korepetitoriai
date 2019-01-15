﻿<?php
//nustatymai.php

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "korepetitoriai");
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
define("UZBLOKUOTAS","255");      // vartotojas negali prisijungti kol administratorius nepakeis rolės

$uregister="both";  // kaip registruojami vartotojai
// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai

// * Email Constants - 
define("EMAIL_FROM_NAME", "Demo");
define("EMAIL_FROM_ADDR", "demo@ktu.lt");
define("EMAIL_WELCOME", false);

?>
