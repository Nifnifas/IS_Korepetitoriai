<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
                <link rel="icon" type="image/png" sizes="32x32" href="include/icons/favicon-32x32.png">
        <meta name=”viewport” content=”width=device-width, initial-scale=1″>
        <title>Korepetitai.lt - Fizika</title>
    </head>
    <body>
        <table class="center"><tr><td>
            <center><a href="index.php"><img src="include/banners/main-banner.png"/></a></center>
        </td></tr><tr><td>
                
    <?php
        session_start();
        include("include/functions.php");
        include("include/meniu.php");
        if (!isset($_SESSION['prev']))   {redirect("logout.php");exit;}
        $_SESSION['prev'] = "cvfizika.list.php";
            $header = "fizika";
            $tipas = getUserLookupType($userlevel);
            if($userlevel > 0 && $userlevel != 10){
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db->set_charset("utf8");
            $sql = "SELECT COUNT(*) FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header' AND vartotojas.statusas='$tipas'";
            $result = mysqli_query($db, $sql) or trigger_error("SQL", E_USER_ERROR);
            $r = mysqli_fetch_row($result);
            $numrows = $r[0];

            //eiluciu kiekis per puslapi
            $rowsperpage = 5;
            //puslapiu kiekis
            $totalpages = ceil($numrows / $rowsperpage);
            //randam dabartini arba default
            if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
               $pageid = (int) $_GET['pageid'];
            } else {
               //default puslapio numeris
               $pageid = 1;
            }
            if ($pageid > $totalpages) {
               $pageid = $totalpages;
            } 
            if ($pageid < 1) {
               $pageid = 1;
            }
            $offset = ($pageid - 1) * $rowsperpage;

            $sql2 = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header' AND vartotojas.statusas='$tipas' ORDER BY data DESC LIMIT $offset, $rowsperpage";
            $result2 = mysqli_query($db, $sql2) or trigger_error("SQL", E_USER_ERROR);
            
                if (!$result2 || (mysqli_num_rows($result2) < 1))  
                                {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Šioje kategorijoje CV dar nėra!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
            }
            else{
            $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $db->set_charset("utf8");
            $sql = "SELECT COUNT(*) FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header'";
            $result = mysqli_query($db, $sql) or trigger_error("SQL", E_USER_ERROR);
            $r = mysqli_fetch_row($result);
            $numrows = $r[0];

            //eiluciu kiekis per puslapi
            $rowsperpage = 5;
            //puslapiu kiekis
            $totalpages = ceil($numrows / $rowsperpage);
            //randam dabartini arba default
            if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
               $pageid = (int) $_GET['pageid'];
            } else {
               //default puslapio numeris
               $pageid = 1;
            }
            if ($pageid > $totalpages) {
               $pageid = $totalpages;
            } 
            if ($pageid < 1) {
               $pageid = 1;
            }
            $offset = ($pageid - 1) * $rowsperpage;
            
            $sql2 = "SELECT * FROM (" . TBL_CVS
                                    . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE cv.dalykas = '$header' ORDER BY data DESC LIMIT $offset, $rowsperpage";
            $result2 = mysqli_query($db, $sql2) or trigger_error("SQL", E_USER_ERROR);                
            if (!$result2 || (mysqli_num_rows($result2) < 1))  
                            {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Šioje kategorijoje CV dar nėra!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
        }
?>
    <table class="center" style="border-color: white;"><tr><td>
    <?php
        $cc = 1;
        
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
                  <th style="text-align: center" colspan="6"><?php echo $header ?></th>
                </tr>
              </thead>
                    </table>
                <?php
                $i = 1;
                while($row = mysqli_fetch_array($result2)){ ?>
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
        
        echo "<center>";
        //kiek rodyti puslapiu
            $range = 1;
            if ($pageid > 1) {
               //rodom linka atgal
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=1'><<</a> ";
               //gaunam pries tai buvusio puslapi
               $prevpage = $pageid - 1;
               //grizti i pirma psl
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$prevpage'><</a> ";
            }

            //tam kad rodytu puslapius aplink dabartini page
            for ($x = ($pageid - $range); $x < (($pageid + $range) + 1); $x++) {
               //jei teisingas nr
               if (($x > 0) && ($x <= $totalpages)) {
                  //jei esam dabartiniame puslapy
                  if ($x == $pageid) {
                     //pazymi, bet nedaro link
                     echo " <button class='btn btn-primary' disabled>$x</button> ";
                  //jei ne dabartinis psl
                  } else {
                     //darom linka
                     echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$x'>$x</a> ";
                  }
               }
            }

            //jei nepaskutinis psl, rodom linkus i prieki ir atgal        
            if ($pageid != $totalpages) {
               //gaunam sekanti psl
               $nextpage = $pageid + 1;
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$nextpage'>></a> ";
               echo " <a class='btn btn-primary' href='{$_SERVER['PHP_SELF']}?pageid=$totalpages'>>></a></center> ";
            }
        
        
        mysqli_close($db);
?>
    </td></tr>
    </table><br>		
    </div><br></table>
          <?php include("include/footer.php"); ?>
</body>
</html>