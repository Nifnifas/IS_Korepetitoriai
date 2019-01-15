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
<table class="center"><tr><td>
            <center><a href="index.php"><img src="include/banners/main-banner.png"/></a></center>
        </td></tr><tr><td>
                <?php 
                    session_start();
                    if (!isset($_SESSION['prev']))  {redirect("logout.php");exit;}
                    $_SESSION['prev'] = "kontaktai.php";
                    include ("include/functions.php");
                    include ("include/meniu.php");?>
       
     <div class="container bg-light p-5 rounded">

                <?php {echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Susisiekti galite el. paštu: " . $link = autolink("info@korepetitai.lt") . "</b></center></div><div class=\"container p-5\"></div></td</tr></table>";} ?>	
			
     </div>
    </td></tr></table>
                  <?php include("include/footer.php"); ?>
</body>
</html>