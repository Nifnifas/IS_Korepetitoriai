<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
      <div class="container">
        <div class="row">
          <div class="col">
          </div>
          <div class="col-12">
          
    <?php
    session_start();
    if (!isset($_SESSION['prev'])) {redirect("logout.php");exit;}
    $_SESSION['prev'] = "sort.php";
    $subject = $_POST['subject'];
    $place = $_POST['place'];
    $_SESSION['place_input'] = $place;
    $_SESSION['subject_input'] = $subject;
    include("include/functions.php");
    include("include/meniu.php");
    $_SESSION['place_input'] = "";
    $_SESSION['subject_input'] = "";
    $tipas = getUserLookupType($userlevel);
    
    if($subject == "Visi dalykai" && $place == "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        if($tipas != "Svecias"){
             $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.statusas='$tipas' ORDER BY data DESC";
        }
        else{
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) ORDER BY data DESC";
        }
       
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></div>
        </div></div>
        <div class=\"col\">
        </div>
    </div>
</div>"; include("include/footer.php"); echo "</body></html>"; exit;}
    }
    if($subject == "Visi dalykai" && $place != "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        if($tipas != "Svecias"){
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.statusas='$tipas' AND cv.miestas = '$place' ORDER BY data DESC";
        }
        else{
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.miestas = '$place' ORDER BY data DESC";
        }
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></div>
        </div></div>
        <div class=\"col\">
        </div>
    </div>
</div>"; include("include/footer.php"); echo "</body></html>"; exit;}
    }
    if($subject != "Visi dalykai" && $place == "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        if($tipas != "Svecias"){
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.statusas='$tipas' AND cv.dalykas = '$subject' ORDER BY data DESC";
        }
        else{
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$subject' ORDER BY data DESC";
        }
            $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></div>
        </div></div>
        <div class=\"col\">
        </div>
    </div>
</div>"; include("include/footer.php"); echo "</body></html>"; exit;}
    }
    if($subject != "Visi dalykai" && $place != "Visi miestai"){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        if($tipas != "Svecias"){
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.statusas='$tipas' AND cv.dalykas = '$subject' AND cv.miestas = '$place' ORDER BY data DESC";
        }
        else{
            $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$subject' AND cv.miestas = '$place' ORDER BY data DESC";
        }
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "
        <div class=\"container p-5\">
            <div>
                <div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center>
                </div>
                <div class=\"container p-5\">
                </div>
            </div>
        </div>
        </div>
        <div class=\"col\">
        </div>
    </div>
</div>"; include("include/footer.php"); echo "</body></html>"; exit;}
    }
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
                    <table class="table">
                <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="6">Paieškos "<?php echo "$place"; ?>" ir "<?php echo "$subject"; ?> " rezultatai</th>
                </tr>
              </thead>
                    </table>
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

               <?php 
               
                }
    mysqli_close($db);
?>
        </div>
          <div class="col">
          </div>
        </div>
      </div>
    </div>
  <?php include("include/footer.php"); ?>
    </body>
</html>