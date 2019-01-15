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
                // useredit.php 
                // vartotojas gali pasikeisti slaptažodį ar email
                // formos reikšmes tikrins procuseredit.php. Esant klaidų pakartotinai rodant formą rodomos ir klaidos

                session_start();
                // sesijos kontrole
                include("include/functions.php");
                include("include/meniu.php");
                if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest")   {redirect("logout.php");exit;}							  
                        $_SESSION['mail_login'] = $_SESSION['user'];
                        $_SESSION['passn_login'] = "";
                if($_SESSION['prev'] != "procuseredit"){
                    $_SESSION['message']="";
                    $_SESSION['passn_error']="";
                }
                $_SESSION['prev'] = "useredit"; 
                ?>

 
                        
                        <table class="center" style="border-width: 30px; border-color: white;"><tr><td>
                                     <div class="container bg-light p-4 rounded">
                                
                                <div class="container">
                                    <h1 class="form-heading">Paskyros redagavimas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <br>
                                                <form action="procuseredit.php" method="POST"> 
                                                    <div class="form-group">
                                                        <input type="password" name="oldpass" class="form-control" placeholder="Dabartinis slaptažodis"/>
                                                        <?php echo $_SESSION['pass_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" name="passn" class="form-control" placeholder="Naujas slaptažodis"/>
                                                        <?php echo $_SESSION['passn_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="email" name="email" class="form-control" id="inputPassword" placeholder="El. paštas" value="<?php echo $_SESSION['user']; ?>"/>
                                                        <?php echo $_SESSION['mail_error']; ?>
                                                    </div>
                                                    <center><button type="submit" name="userEdit" class="btn btn-primary">Keisti duomenis</button><center> 
                                                            <?php echo $_SESSION['message']; ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>  
                                     </div>
                                </td></tr>
                </table><br><br>          
  </td></tr>
  </table>           
              <?php include("include/footer.php"); ?>
 </body>
</html>
	


