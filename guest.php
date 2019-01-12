<?php
// guest.php
// nustato user="guest", userlevel=""

session_start(); 
// cia sesijos kontrole:
  $_SESSION['prev'] = "guest";
  $_SESSION['user'] = "guest";
  $_SESSION['ulevel'] ="0";
  $_SESSION['urole'] ="Svečias";
header("Location:index.php");exit;
 ?>
