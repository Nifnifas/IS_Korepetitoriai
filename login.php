<?php 
session_start();
if (empty($_SESSION['prev'])) { header("Location: logout.php");exit;}

?>
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
                    include("include/functions.php");
                    include("include/meniu.php");
                    ?>
                    <table class="center" style="border-width: 30px; border-color: white;"><tr><td>
                                <?php
                                    if($_SESSION['prev'] == "procregister" || $_SESSION['prev'] == "proclogin" || $_SESSION['prev'] == "procuseredit"){
                                        echo "<table class=\"center\" style=\"border-width: 10px; border-color: white;\"><tr><td><font size=\"4\" color=\"#ff0000\">$_SESSION[message]</font></td></tr></table>";
                                    }
                                    if (!isset($_SESSION['prev']) || $_SESSION['user'] != "guest")   {redirect("logout.php");exit;}
                                    $_SESSION['prev'] = "login";
                                ?>
                            <div class="container bg-light p-5 rounded">
                                <div class="container">
                                    <h1 class="form-heading">Prisijungimo langas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Įveskite vartotojo el. paštą ir slaptažodį</p>
                                                </div>
                                                <form action="proclogin.php" method="POST"> 
                                                    <div class="form-group">
                                                        <input type="text" name="mail" class="form-control" id="inputEmail" value="<?php echo $_SESSION['mail_input']?>" placeholder="El. paštas"/>
                                                        <?php echo $_SESSION['mail_error'];?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Slaptažodis"/>
                                                        <?php echo $_SESSION['pass_error'];?>
                                                    </div>
                                                    <div class="container">
                                                        <center>
                                                            <button type="submit" name="login" class="btn btn-primary">Prisijungti</button>
                                                        </center>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>          
                                </div>
                            </div>
                </td></tr></table>
            </td></tr></table>
        <?php include("include/footer.php"); ?>
    </body>
</html>