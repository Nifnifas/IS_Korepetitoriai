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
//if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "newarticle"))
//{ header("Location: articles.php");exit;}

  include("include/nustatymai.php");
  include("include/functions.php");
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   { header("Location: logout.php");exit;}
  $_SESSION['prev'] = "delete_comment.php";
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$uql = "SELECT * FROM " . TBL_COMMENTS . " WHERE atsakymo_id = $_POST[comment_id]";
$result = mysqli_query($conn, $uql);
if (mysqli_num_rows($result) > 0){
    echo "<br><br><br><h3>Klaida! Trinti šį komentarą galėsite tik tada, kai ištrinsite visus atsakymus į šį komentarą!</h3>";
    header( "refresh:2;url=read.php");
}
else{
    $sql = "DELETE FROM " . TBL_COMMENTS . " WHERE komentaro_id = $_POST[comment_id]";
    if(mysqli_query($conn, $sql)){
        echo "<br><br><br><h3>Komentaras ištrintas sėkmingai!</h3>";
        header( "refresh:1;url=read.php");
    }
}
mysqli_close($conn);
?>
  
  