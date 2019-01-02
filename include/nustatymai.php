<?php
//nustatymai.php

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "korepetitoriai");
define("TBL_USERS", "vartotojas");
define("TBL_ARTICLES", "articles");
define("TBL_CATEGORIES", "categories");
define("TBL_COMMENTS", "comments");
define("TBL_STATUS", "status");

$user_roles=array(      // vartotojų rolių vardai lentelėse ir  atitinkamos userlevel reikšmės
	"Redaktorius"=>"9",
	"Skaitytojas"=>"5",
	"Skaitytojas*"=>"4");   // galioja ir vartotojas "guest", kuris neturi userlevel
define("DEFAULT_LEVEL","Skaitytojas");  // kokia rolė priskiriama kai registruojasi
define("ADMIN_LEVEL","Redaktorius");  // kas turi vartotojų valdymo teisę
define("UZBLOKUOTAS","255");      // vartotojas negali prisijungti kol administratorius nepakeis rolės

$uregister="both";  // kaip registruojami vartotojai
// self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai

// * Email Constants - 
define("EMAIL_FROM_NAME", "Demo");
define("EMAIL_FROM_ADDR", "demo@ktu.lt");
define("EMAIL_WELCOME", false);

?>
