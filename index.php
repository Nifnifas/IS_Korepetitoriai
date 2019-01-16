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
            include("include/functions.php");

            if (!empty($_SESSION['user']))     //Jei vartotojas prisijungęs, valom logino kintamuosius ir rodom meniu
            {                                  // Sesijoje nustatyti kintamieji su reiksmemis is DB
                                               // $_SESSION['user'],$_SESSION['ulevel'],$_SESSION['userid'],$_SESSION['umail']
                        //echo "<div align=\"center\">";echo "<font size=\"4\" color=\"#ff0000\">".$_SESSION['message'] . "<br></font>";    
                        inisession("part");   //   pavalom prisijungimo etapo kintamuosius
                        $_SESSION['prev']="index"; 


                include("include/meniu.php"); //įterpiamas meniu pagal vartotojo rolę
        ?>

                <?php
                            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                            $db->set_charset("utf8");
                            $sql = "SELECT * FROM (" . TBL_CVS
                                                    . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) ORDER BY data DESC LIMIT 5";
                            $result = mysqli_query($db, $sql) or trigger_error("SQL", E_USER_ERROR);                
                            if (!$result || (mysqli_num_rows($result) < 1))  
                                            {echo "<table class=\"center\" style=\"border-color: white;\"><br><br><tr><td>CV nėra!</td></tr></table><br>";exit;}
                ?>
                <style>
                    .jumbotron {
                          padding: 15px;
                    }
                    .img-thumbnail{
                        background-color:gray;
                        position: absolute;
                        margin: auto;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                    }
                </style>
                <div class="container p-5">
                <?php
                $i = 1;
                while($row = mysqli_fetch_array($result)){ ?>
                    <form method="POST" action="read.php">
                    <div class="jumbotron" onclick="this.parentNode.submit();" id="something<?php echo "$i";?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-1" text-center><img src="<?php echo "$row[profilio_nuotrauka]"; ?>"  alt="" class="rounded-circle img-thumbnail"/></div>
                                <div class="col-8 text-left"><?php echo "<b>$row[antraste]</b> (<i>$row[statusas]</i>)<br>"; ?>
                                        <?php echo "$row[tekstas]"; ?>
                                    </div>
                                <script>
                                    $('#something<?php echo "$i";?>')
                                      .css('cursor', 'pointer')
                                      .hover(
                                        function(){
                                          $(this).css('background', '#3a98bf');
                                        },
                                        function(){
                                          $(this).css('background', '');
                                        }
                                      );
                                  </script>
                                <div class="col text-right"><?php echo "<b>$row[vardas] $row[pavarde]</b><br>$row[data]<br>$row[dalykas]"; $i++;?></div>
                              </div>
                            
                                   <input type="text" id="cv_id" name="cv_id" value="<?php echo "$row[cv_id]"; ?>" hidden/>
                            
                        
                      </div>
                    </div>
                        </form>

               <?php } ?>
                </div>
                
        <?php
            }                
                  else {
                      if (!isset($_SESSION['prev'])) inisession("full");             // nustatom sesijos kintamuju pradines reiksmes 
                      else {if ($_SESSION['prev'] != "proclogin") inisession("part");
                      include("guest.php");// nustatom pradines reiksmes formoms
                           }  
                                  // jei ankstesnis puslapis perdavė $_SESSION['message']
                                        echo "<div align=\"center\">";echo "<font size=\"4\" color=\"#ff0000\">".$_SESSION['message'] . "<br></font>";          

                        echo "<table class=\"center\"><tr><td>";
                        include("guest.php");
                  //include("include/login.php");                    // prisijungimo forma
                        echo "</td></tr></table></div><br><br>";

                          }
        ?>
        </table>
        <?php include("include/footer.php"); ?>
    </body>
</html>
