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
        <title>Korepetitai.lt - Kontaktai</title>
    </head>
    <body>
<div class="container">
        <div class="row">
          <div class="col">
          </div>
          <div class="col-12">
          
                <?php 
                    session_start();
                    if (!isset($_SESSION['prev']))  {redirect("logout.php");exit;}
                    $_SESSION['prev'] = "kontaktai.php";
                    include ("include/functions.php");
                    include ("include/meniu.php");?>
       <table class="center" style="border-color: white; border-width: 0px;"><tr><td>

                <?php {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Susisiekti galite el. paštu: " . $link = autolink("info@korepetitai.lt") . "</b></center></div><div class=\"container p-5\"></div></td</tr></table>";} ?>	
		
    </td></tr></table>
              </div>
          <div class="col">
          </div>
        </div>
      </div>
                  <?php include("include/footer.php"); ?>
</body>
</html>