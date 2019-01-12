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
        include("include/meniu.php");
        include("include/functions.php");
        ?>
                 
        <table class="center" style="border-color: white; border-width: 30px;"><tr><td>
            <div class="container bg-light p-4 rounded">
                 
        <?php
        //if "email" variable is filled out, send email
          if (isset($_REQUEST['email']))  {
            //Email information
            $admin_email = "someone@example.com";
            $email = $_REQUEST['email'];
            $subject = $_REQUEST['subject'];
            $comment = $_REQUEST['comment'];
             $_SESSION['mail_error'] = "";
              $_SESSION['tekstas_error'] = "";
            $ismailgood = checkMail($email);
            $isinputgood = checkForInput($comment, "tekstas_error");
            if($isinputgood && $ismailgood){
                  //send email
                  mail($admin_email, "$subject", $comment, "From:" . $email);
                  //Email response
                  echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Išsiųsta. Ačiū už pranešimą!</b></center></div><div class=\"container p-5\"></div>";
            }
            else { ?>
                <div class="container">
                                    <h1 class="form-heading">Pranešimas apie klaidą</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Užpildykite žemiau esančius laukelius</p>
                                                </div>
                                                        <form method="POST">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" type="text" placeholder="Jūsų el. paštas" />
                                                                 <?php echo $_SESSION['mail_error'];?>
                                                            </div>
                                                            <div class="form-group">
                                                                <input class="form-control" name="subject" type="text" value="Pranešimas apie klaidą" hidden/>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="comment" rows="10" cols="40" placeholder="Tekstas"></textarea>
                                                                <?php echo $_SESSION['tekstas_error'];?>
                                                            </div>
                                                            <center><input class="btn btn-primary" type="submit" value="Siųsti" /></center>
                                                        </form>
                                            </div>
                                        </div>          
                                </div>
            <?php }
          }

          //if "email" variable is not filled out, display the form
          else  {
        ?>



                
                <div class="container">
                                    <h1 class="form-heading">Pranešimas apie klaidą</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Užpildykite žemiau esančius laukelius</p>
                                                </div>
                                                        <form method="POST">
                                                            <div class="form-group">
                                                                <input class="form-control" name="email" type="text" placeholder="Jūsų el. paštas" />
                                                                 <?php echo $_SESSION['mail_error'];?>
                                                            </div>
                                                            <div class="form-group">
                                                                <input class="form-control" name="subject" type="text" value="Pranešimas apie klaidą" hidden/>
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="comment" rows="10" cols="40" placeholder="Tekstas"></textarea>
                                                                <?php echo $_SESSION['tekstas_error'];?>
                                                            </div>
                                                            <center><input class="btn btn-primary" type="submit" value="Siųsti" /></center>
                                                        </form>
                                            </div>
                                        </div>          
                                </div>
       <?php
         }
       ?>
                
                </td></tr></table>
                </div>
                    </td></tr></table>
        <?php include("include/footer.php"); ?>
    </body>
</html>
