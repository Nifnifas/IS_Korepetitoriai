<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title></title>
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
    include("include/functions.php");
    include("include/meniu.php");
    if (!isset($_SESSION['prev']))  {redirect("logout.php");exit;}
    $_SESSION['prev'] = "search.php"; 
    
    $paieska = $_POST['paieska'];
    $kiekis = count(explode(' ', $paieska));
    if($kiekis == 1){
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.vardas LIKE '%$paieska%' OR vartotojas.pavarde LIKE '%$paieska%'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
    }
    if($kiekis == 2){
        list($part1, $part2) = explode(' ', $paieska);
        $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        $db->set_charset("utf8");
        $sql = "SELECT * FROM (" . TBL_CVS
                        . " INNER JOIN " . TBL_USERS . " ON cv.fk_vartotojo_id = vartotojas.vartotojo_id) WHERE vartotojas.vardas LIKE '%$part1%' AND vartotojas.pavarde LIKE '%$part2%' OR vartotojas.vardas LIKE '%$part2%' AND vartotojas.pavarde LIKE '%$part1%'";
        $result = mysqli_query($db, $sql);
        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
    }
    if ($kiekis > 2 || $paieska == ""){
        echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Deja nieko neradome!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;
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
                <table class="center" style="border-color: white; border-width: 30px;"><tr><td>
                <div class="container p-5">
                    <table class="table">
                <thead class="thead-light">
                <tr>
                  <th style="text-align: center" colspan="6">Paieškos "<?php echo "$paieska"; ?>" rezultatai</th>
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

               <?php } ?>
                </div></td></tr></table>
                <?php
    mysqli_close($db);
?>

        </td></tr></table>
  <?php include("include/footer.php"); ?>
    </body>
</html>
