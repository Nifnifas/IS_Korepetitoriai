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
 if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] != $user_roles[ADMIN_LEVEL]))   {redirect("logout.php");exit;}
  $_SESSION['prev'] = "deleteUser.php";
  $id = $_POST['vartotojo_id'];
  $statusas = $_POST['status'];
  $sistema = "sistema";
// Create connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if($statusas == "Mokinys"){
    $cql = "UPDATE " . TBL_COMMENTS . " SET fk_vartotojo_id='$sistema' WHERE fk_vartotojo_id= '$id'";
        if(!mysqli_query($conn, $cql)){
            echo "Klaida komentaru skiltyje.";
        }
        else{
            $iql = "UPDATE " . TBL_IVERTINIMAS . " SET fk_vartotojo_id='$sistema' WHERE fk_vartotojo_id= '$id'";
            if(!mysqli_query($conn, $iql)){
                echo "Klaida ivertinimu skiltyje.";
            }
            else{
                $pql = "DELETE FROM " . TBL_PAZYMETI . " WHERE fk_vartotojo_id= '$id'";
                if(!mysqli_query($conn, $pql)){
                    echo "Klaida pazymetu cv skiltyje.";
                }
                else{
                    $rpql = "DELETE FROM " . TBL_REPORTUOTI . " WHERE fk_vartotojo_id= '$id'";
                    if(!mysqli_query($conn, $rpql)){
                        echo "Klaida raportu skiltyje.";
                    }
                        else{
                            $knql = "DELETE FROM " . TBL_KLASES_NARIAI . " WHERE fk_vartotojo_id= '$id'";
                            if(!mysqli_query($conn, $knql)){
                                echo "Klaida klases nariu skiltyje.";
                            }
                            else{
                                    $cvql = "DELETE FROM " . TBL_CVS . " WHERE fk_vartotojo_id= '$id'";
                                    if(!mysqli_query($conn, $cvql)){
                                        echo "Klaida cv skiltyje.";
                                    }
                                    else{
                                        $vql = "DELETE FROM " . TBL_USERS . " WHERE vartotojo_id= '$id'";
                                        if(!mysqli_query($conn, $vql)){
                                            echo "Klaida vartotoju skiltyje.";
                                        }
                                        else{
                                            echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Vartotojas ir visa su juo susijusi informacija<br>sėkmingai pašalinta!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                                            header( "refresh:2;url=admin.php");
                                        }
                                    }
                            }
                        }
                }
            }
        }
}
else if($statusas == "Mokytojas"){
    $klasesid1 = getClassID($id, "Dabartiniai");
    $klasesid2 = getClassID($id, "Buvusieji");
    $cql = "UPDATE " . TBL_COMMENTS . " SET fk_vartotojo_id='$sistema' WHERE fk_vartotojo_id= '$id'";
        if(!mysqli_query($conn, $cql)){
            echo "Klaida komentaru skiltyje.";
        }
        else{
            $iql = "UPDATE " . TBL_IVERTINIMAS . " SET fk_vartotojo_id='$sistema' WHERE fk_vartotojo_id= '$id'";
            if(!mysqli_query($conn, $iql)){
                echo "Klaida ivertinimu skiltyje.";
            }
            else{
                $pql = "DELETE FROM " . TBL_PAZYMETI . " WHERE fk_vartotojo_id= '$id'";
                if(!mysqli_query($conn, $pql)){
                    echo "Klaida pazymetu cv skiltyje.";
                }
                else{
                    $rpql = "DELETE FROM " . TBL_REPORTUOTI . " WHERE fk_vartotojo_id= '$id'";
                    if(!mysqli_query($conn, $rpql)){
                        echo "Klaida raportu skiltyje.";
                    }
                    else{
                        $knql = "DELETE FROM " . TBL_KLASES_NARIAI . " WHERE fk_klases_id= '$klasesid1' OR fk_klases_id= '$klasesid2'";
                        if(!mysqli_query($conn, $knql)){
                            echo "Klaida klases nariu skiltyje.";
                        }
                        else{
                            $kql = "DELETE FROM " . TBL_CLASS . " WHERE fk_vartotojo_id= '$id'";
                            if(!mysqli_query($conn, $kql)){
                                echo "Klaida klasiu skiltyje.";
                            }
                            else{
                                $cvql = "DELETE FROM " . TBL_CVS . " WHERE fk_vartotojo_id= '$id'";
                                if(!mysqli_query($conn, $cvql)){
                                    echo "Klaida cv skiltyje.";
                                }
                                else{
                                    $vql = "DELETE FROM " . TBL_USERS . " WHERE vartotojo_id= '$id'";
                                    if(!mysqli_query($conn, $vql)){
                                        echo "Klaida vartotoju skiltyje.";
                                    }
                                    else{
                                        echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Vartotojas ir visa su juo susijusi informacija<br>sėkmingai pašalinta!</b></center></div><div class=\"container p-5\"></div></td</tr></table>";
                                        header( "refresh:2;url=admin.php");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
}
else{
    echo "Negalima ištrinti.";
}

mysqli_close($conn);
?>
        </td></tr></table>
</body>
</html>
