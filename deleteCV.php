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
         <table class="center"><tr><td>
            <center><a href="index.php"><img src="include/banners/main-banner.png"/></a></center>
        </td></tr><tr><td> 

<?php
session_start(); 

  include("include/nustatymai.php");
  include("include/functions.php");
 if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] <= 0))   {redirect("logout.php");exit;}
  $atejoIs = $_SESSION['prev'];
  $_SESSION['prev'] = "deleteCV.php";
  $id = $_POST['cv_id'];
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$cql = "DELETE FROM " . TBL_COMMENTS . " WHERE fk_cv_id= '$id'";
        if(!mysqli_query($conn, $cql)){
            echo "Klaida komentaru skiltyje.";
        }
        else{
            $pql = "DELETE FROM " . TBL_PAZYMETI . " WHERE fk_cv_id= '$id'";
            if(!mysqli_query($conn, $pql)){
                echo "Klaida pazymetuju skiltyje.";
            }
            else{
                $cql = "DELETE FROM " . TBL_COMMENTS . " WHERE fk_cv_id= '$id'";
                if(!mysqli_query($conn, $cql)){
                    echo "Klaida komentaru skiltyje.";
                }
                else{
                    $rpql = "DELETE FROM " . TBL_REPORTUOTI . " WHERE fk_cv_id= '$id'";
                    if(!mysqli_query($conn, $rpql)){
                        echo "Klaida raportu skiltyje.";
                    }
                    else{
                        $cvql = "DELETE FROM " . TBL_CVS . " WHERE cv_id= '$id'";
                        if(!mysqli_query($conn, $cvql)){
                            echo "Klaida cv skiltyje.";
                        }
                        else{
                            echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>CV ir visa kita susijusi informacija<br>sėkmingai pašalinta!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                            if($atejoIs == "reportedCVs.php"){
                                header( "refresh:2;url=reportedCVs.php");
                            }else{
                                header( "refresh:2;url=index.php");
                            }        
                            
                        }
                    }
                }
            }
        }
        

mysqli_close($conn);
?>
        </td></tr></table>
</body>
</html>
