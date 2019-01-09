<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" />
        <title></title>
    </head>
    <body>
        <table class="center"><tr><td>
            <center><img src="include/banners/banner2.png"></center>
        </td></tr><tr><td> 
        <?php
            session_start();
            include("include/functions.php");

            if (!empty($_SESSION['user']))     //Jei vartotojas prisijungęs, valom logino kintamuosius ir rodom meniu
            {                                  // Sesijoje nustatyti kintamieji su reiksmemis is DB
                                               // $_SESSION['user'],$_SESSION['ulevel'],$_SESSION['userid'],$_SESSION['umail']

                        inisession("part");   //   pavalom prisijungimo etapo kintamuosius
                        $_SESSION['prev']="index"; 


                include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
        ?>

                        <div style="text-align: center;color:green">
                            <br><br>
                            <h1>Pradinis sistemos puslapis.</h1>
                            <h1>Projektą finansuoja noras gaut pytaki</h1>
                        </div><br>
        <?php
            }                
                  else {   			 

                      if (!isset($_SESSION['prev'])) inisession("full");             // nustatom sesijos kintamuju pradines reiksmes 
                      else {if ($_SESSION['prev'] != "proclogin") inisession("part"); // nustatom pradines reiksmes formoms
                           }  
                                  // jei ankstesnis puslapis perdavė $_SESSION['message']
                                        echo "<div align=\"center\">";echo "<font size=\"4\" color=\"#ff0000\">".$_SESSION['message'] . "<br></font>";          

                        echo "<table class=\"center\"><tr><td>";
                  include("include/login.php");                    // prisijungimo forma
                        echo "</td></tr></table></div><br><br>";

                          }
        ?>
        </table>
    </body>
</html>
