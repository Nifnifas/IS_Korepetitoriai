<html>
    <head>
        <title></title>
    </head>
    <body>
        
    </body>
</html>
<?php
// logout.php naikina sesija ir cookius
session_start();
echo "sesija:".$_SESSION['prev'];
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();
include("guest.php");
?>


