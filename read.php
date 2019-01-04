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
            <center><img src="include/topB.png"></center>
        <br>
            <?php
                session_start();
                include("include/meniu.php");
                include("include/functions.php");
                if (!isset($_SESSION['prev']))   { header("Location: logout.php");exit;}
                $_SESSION['prev'] = "read.php"; 
                if(isset($_POST['cv_id'])){
                    $_SESSION['art'] = $_POST['cv_id'];
                }
                else{
                    $_SESSION['art'];
                }

                $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                        $query = "SELECT cv_id, antraste, tekstas, kaina, data, dalykas, internetu, vardas, pavarde "
                            . "FROM " . TBL_CVS . ", " . TBL_USERS . " WHERE cv_id = $_SESSION[art] AND fk_vartotojo_id = vartotojo_id ORDER BY cv_id ASC";
                        $result = mysqli_query($db, $query);
                        if (!$result || (mysqli_num_rows($result) < 1))  
                                        {echo "Klaida skaitant lentelę"; exit;}
            ?>

    <br><br><table class="center" style="border-width: 2px; border-color: white;"><tr><td>
    <?php

        $row = mysqli_fetch_array($result);   //Creates a loop to loop through results
        //$viewsCount = $row['views']+1;
        echo "<div class=\"container\">
                <center>
                <h2>$row[antraste]</h2>
                <h6>
                    <small class=\"text-muted\"> Patalpinta: $row[data]</small>
                </h6>
                </center>
                <p class=\"lead\" align=\"left\">$row[tekstas]</p>
                </div>";
        /*$uql = "UPDATE " . TBL_CVS . " SET `views`= '$viewsCount'"
                    . " WHERE `article_id` = '$_SESSION[art]'";
        mysqli_query($db, $uql);
        mysqli_close($db);*/

    ?>
        <br>	
         </td></tr>
                </table><br><br>   
        
<div class="container">
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
</td></tr><tr><td> 
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
        
</body>
</html>