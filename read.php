<html>
    <head>
        <title></title>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
                  
    </head>
    <body>
        <table class="center" ><tr><td>
            <center><a href="index.php"><img src="include/banners/banner2.png"/></a></center>
        <br>
            <?php
                session_start();
                include("include/meniu.php");
                include("include/functions.php");
                if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
                $_SESSION['prev'] = "read.php";
                if(isset($_POST['cv_id'])){
                    $_SESSION['art'] = $_POST['cv_id'];
                    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                    $db->set_charset("utf8");
                        $query = "SELECT cv_id, antraste, tekstas, ivertinimas, miestas, kaina, data, dalykas, internetu, vardas, pavarde, el_pastas, telefono_nr, statusas, fk_vartotojo_id, views, profilio_nuotrauka "
                            . "FROM " . TBL_CVS . ", " . TBL_USERS . " WHERE cv_id = $_SESSION[art] AND fk_vartotojo_id = vartotojo_id ORDER BY cv_id ASC";
                        $result = mysqli_query($db, $query);
                        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Šis vartotojas neturi CV!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
                }
                else{
                    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                    $db->set_charset("utf8");
                        $query = "SELECT cv_id, antraste, tekstas, ivertinimas, miestas, kaina, data, dalykas, internetu, vardas, pavarde, el_pastas, telefono_nr, statusas, fk_vartotojo_id, views, profilio_nuotrauka "
                            . "FROM " . TBL_CVS . ", " . TBL_USERS . " WHERE vartotojo_id = '$userid' AND fk_vartotojo_id = '$userid' ORDER BY cv_id ASC";
                        $result = mysqli_query($db, $query);
                        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Jūs dar neturite savo CV!</b></center></div><div class=\"container p-5\"></div></td</tr></table>"; include("include/footer.php");exit;}
                }
                
            ?>

    <table class="center" style="border-width: 10px; border-color: white;"><tr><td>
    <?php

        $row = mysqli_fetch_array($result);   //Creates a loop to loop through results
        $viewsCount = $row['views']+1;
            if($row['fk_vartotojo_id'] != $userid){
                $ql = "SELECT * FROM " . TBL_PAZYMETI . " WHERE `fk_vartotojo_id` = '$userid' AND `fk_cv_id` = '$_SESSION[art]'";
                $q_result = mysqli_query($db, $ql);
                if (mysqli_num_rows($q_result) == 1)
                {
                    $row2 = mysqli_fetch_array($q_result);
                    $_SESSION['busena_input'] = "2";
                }
                else
                {
                    $_SESSION['busena_input'] = "1";
                }
                $fk_klases_id = getClassID($row['fk_vartotojo_id'], "Dabartiniai");
                $zl = "SELECT * FROM " . TBL_KLASES_NARIAI . " WHERE `fk_vartotojo_id` = '$userid' AND `fk_klases_id` = '$fk_klases_id'";
                $z_result = mysqli_query($db, $zl);
                if (mysqli_num_rows($z_result) == 1)
                {
                    $row3 = mysqli_fetch_array($z_result);
                    $_SESSION['bsn_input'] = "2";
                }
                else
                {
                    $_SESSION['bsn_input'] = "1";
                }
            }
        $uql = "UPDATE " . TBL_CVS . " SET `views`= '$viewsCount'"
                    . " WHERE `cv_id` = '$_SESSION[art]'";
        mysqli_query($db, $uql);
        
    ?>   	
         </td></tr>
                </table>
    
   
        <div class="container bg-light p-4 rounded">

      <div class="row">
    <div class="col"></div>
    <div class="col-10">
          <div class="row">
    <div class="col-md-4 img">
        <img src="<?php echo "$row[profilio_nuotrauka]"; ?>"  alt="" class="rounded-circle">
    </div>
    <div class="col-md-6 details">
          <div class="row">
        <h3><?php echo "$row[vardas] $row[pavarde]"; ?></h3>
        <?php if($userid != $row['fk_vartotojo_id'] && $userid != ""){ ?>
        <form method="POST" action="procpazymeticv.php">
                    <input type="hidden" name="cv_id" id="cv_id" value="<?php echo $_SESSION['art']?>"/>
                    <input type="hidden" name="busena" id="busena" value="<?php if($_SESSION['busena_input']==1){echo "1";}else{echo "2";}?>"/>
                    <button type="submit" name="submit" id="submit" style="padding: 0; border:0px solid transparent; background: none; cursor: pointer;"><?php if($_SESSION['busena_input'] == 2){ echo "<img src='include/full_star.png'/>"; } else { echo "<img src='include/star.png'/>";} ?></button></center>
        </form>
        <?php } ?>
          </div>
      <p>
            
          <?php
          if($row['fk_vartotojo_id'] != $userid && $userid != ""){
                $ivertinimai = "SELECT * FROM " . TBL_IVERTINIMAS . " WHERE `fk_vartotojo_id` = '$userid' AND `skirtas_id` = '$row[fk_vartotojo_id]'";
                $rez_ivert = mysqli_query($db, $ivertinimai);
                if (mysqli_num_rows($rez_ivert) == 0){ ?>
          
            <div class="container">
		<div class="row">
				<div class="rating-block" id="rating">
                                    <form id="form" method="POST">
                                        <input type="text" id="skiriama" name="skiriama" value="<?php echo "$row[fk_vartotojo_id]"; ?>" hidden/>
                                        <button id="ivertinti1" value="1" class="btn btn-warning" aria-label="Left Align">1</button>
                                        <button id="ivertinti2" value="2" class="btn btn-warning" aria-label="Left Align">2</button>
                                        <button id="ivertinti3" value="3" class="btn btn-warning" aria-label="Left Align">3</button>
                                        <button id="ivertinti4" value="4" class="btn btn-warning" aria-label="Left Align">4</button>
                                        <button id="ivertinti5" value="5" class="btn btn-warning" aria-label="Left Align">5</button>
                                    </form>
				</div>	
		</div>	
            </div>
      
          <?php } } 
          mysqli_close($db);
          ?>

<script>
$(document).ready(function(){
$("#ivertinti1").click(function(){
var reiksme = $("#ivertinti1").val();
var skiriama = $("#skiriama").val();
$.post("ivertinti.php", //Required URL of the page on server
{ // Data Sending With Request To Server
reiksme:reiksme,
skiriama: skiriama
},
function(response,status){ // Required Callback Function
alert("Sėkmingai įvertinta");//"response" receives - whatever written in echo of above PHP script.
window.location.reload();
});
});
$("#ivertinti2").click(function(){
var reiksme = $("#ivertinti2").val();
var skiriama = $("#skiriama").val();
$.post("ivertinti.php", //Required URL of the page on server
{ // Data Sending With Request To Server
reiksme:reiksme,
skiriama: skiriama
},
function(response,status){ // Required Callback Function
alert("Sėkmingai įvertinta");//"response" receives - whatever written in echo of above PHP script.
window.location.reload();
});
});
$("#ivertinti3").click(function(){
var reiksme = $("#ivertinti3").val();
var skiriama = $("#skiriama").val();
$.post("ivertinti.php", //Required URL of the page on server
{ // Data Sending With Request To Server
reiksme:reiksme,
skiriama: skiriama
},
function(response,status){ // Required Callback Function
alert("Sėkmingai įvertinta");//"response" receives - whatever written in echo of above PHP script.
window.location.reload();
});
});
$("#ivertinti4").click(function(){
var reiksme = $("#ivertinti4").val();
var skiriama = $("#skiriama").val();
$.post("ivertinti.php", //Required URL of the page on server
{ // Data Sending With Request To Server
reiksme:reiksme,
skiriama: skiriama
},
function(response,status){ // Required Callback Function
alert("Sėkmingai įvertinta");//"response" receives - whatever written in echo of above PHP script.
window.location.reload();
});
});
$("#ivertinti5").click(function(){
var reiksme = $("#ivertinti5").val();
var skiriama = $("#skiriama").val();
$.post("ivertinti.php", //Required URL of the page on server
{ // Data Sending With Request To Server
reiksme:reiksme,
skiriama: skiriama
},
function(response,status){ // Required Callback Function
alert("Sėkmingai įvertinta");//"response" receives - whatever written in echo of above PHP script.
window.location.reload();
});
});
});
</script>
      
          
<img src="include/star.png" alt=""/>Įvertinimas: <b><?php $reitingas = getCurrentRating($row['fk_vartotojo_id']); echo "$reitingas"; ?></b> / 5<br>
          <img src="include/user.png" alt=""><?php echo "$row[statusas]"; ?><br>
          <img src="include/subject.png" alt=""><?php echo "$row[dalykas]"; ?><br>
          <img src="include/location.png" alt=""><?php echo "$row[miestas]"; ?><br>
          <?php if($row['statusas'] == "Mokytojas"){ ?>
          <img src="include/price.png" alt=""><?php echo "$row[kaina].00 €/val"; ?><br>
          <?php } ?>
      </p>
    </div>
  </div>
  <div class="row">
    <div class="col">
        <br>
      <blockquote>
        <h5><?php echo "$row[antraste]"; ?></h5>
        <small><cite title="Source Title">Patalpinta: <?php echo"$row[data]"; ?></small><i class="icon-map-marker"></i></cite></small>
      </blockquote>
      <p>
          <?php echo "$row[tekstas]"; ?> <br>
      </p>
    </div>
  </div>
    <div class="row">
    <div class="col">
        <h5><?php echo "Kontaktai"; ?></h5>
    </div>
        <div class="col">
      <p>
          <img src="include/phone.png" alt=""> <?php echo "+$row[telefono_nr]"; ?>
        </div>
          <div class="col">
              <img src="include/mail.png" alt=""> <?php $link = autolink($row['el_pastas']); echo "$link"; ?> <br>
      </p>
          </div>
    </div>
        <?php if($row['statusas'] == "Mokytojas"){ ?>
        <div class="row">
            <div class="col">
                <h5><?php echo "Mokiniai"; ?></h5>
                <p>
                <?php $classid = getClassID($row['fk_vartotojo_id'], "Dabartiniai"); $mm = getClassCount($classid, "Priimtas"); 
                           if($mm == 0){echo "Šiuo metu mokytojas mokinių neturi!";} else if($mm > 0 && $mm == 1){echo "Šiuo metu pas mokytoją mokosi <b>$mm</b> mokinys.";}
                           else if($mm > 0 && ($mm == 10 || $mm == 20 || $mm == 30 || $mm == 40 || $mm == 50)){echo "Šiuo metu pas mokytoją mokosi <b>$mm</b> mokinių.";}
                           else {echo "Šiuo metu pas mokytoją mokosi <b>$mm</b> mokiniai.";}?>
                </p>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="container">
                <div class="row">
                  <div class="col-sm">
                  </div>
                  <div class="col-sm">
                      <center>
                          <?php if($userid != $row['fk_vartotojo_id'] && $userlevel == 1){ ?>
                          
                          <form method="POST" action="procnewclassmember.php">
                              <input type="hidden" name="mokytojo_id" id="mokytojo_id" value="<?php echo"$row[fk_vartotojo_id]"; ?>"/>
                              <input type="hidden" name="busena" id="busena" value="<?php if($_SESSION['bsn_input']==1){echo "1";}else{echo "2";}?>"/>
                              <button type="submit" name="submit" id="submit" class="btn btn-primary" <?php if($_SESSION['bsn_input']==1){echo "value=\"Užsirašyti pas mokytoją\"";}else{echo "value=\"Jūs jau užsirašęs!\" disabled";}?> /></center>
                          </form>
                          <?php } ?>
                      </center>
                  </div>
                  <div class="col-sm">
                  </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col"></div>
  </div>
</div>
    <?php if($userlevel != 0){ ?>
    <br>
   <div class="container bg-secondary p-4 rounded">
   <form method="POST" id="comment_form">
    <div class="form-group">
        <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Įveskite komentarą" rows="5"></textarea>
    </div>
    
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <center><input type="submit" name="submit" onclick="refreshPage();" id="submit" class="btn btn-info" value="Komentuoti" /></center>
   </form>
    <div id="output" align="center" style="color: red;"></div>
    
    <div class="form-group">    
        <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
    </div>
</td></tr>
</table>
<script>
function refreshPage(){
    if (!$("#comment_content").val()) {
    $('#output').html('Užpildykite komentarui skirtą lauką!');
    }
    else{
        window.location.reload();
    }
}
</script>
<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error !== '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }
 
 $('#submit').click(function(){
      $('#comment_content').load('add_comment.php #comment_content', function() {
           /// can add another function here
      });
   });

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_content').focus();
 });
});
</script>
    <?php } ?>
</td></tr>
</table>
  <?php include("include/footer.php"); ?>
</body>
</html>