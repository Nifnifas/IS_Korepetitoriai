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
        <title>Korepetitai.lt - Susisiekti</title>
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
                $_SESSION['prev'] = "contactUs.php";
        include("include/meniu.php");
        include("include/functions.php");
        ?>
                 
        <table class="center" style="border-color: white; border-width: 45px;"><tr><td>
            
                 
        <?php
        //if "email" variable is filled out, send email
          if (isset($_REQUEST['email']))  {
            //Email information
            $admin_email = "info@korepetitai.lt";
            $email = $_REQUEST['email'];
            $subject = $_REQUEST['subject'];
            $comment = $_REQUEST['comment'];
             $_SESSION['mail_error'] = "";
              $_SESSION['tekstas_error'] = "";
            $ismailgood = checkMail($email);
            $isinputgood = checkForInput($comment, "tekstas_error");
            if($isinputgood && $ismailgood){
                  //send email
                
                  mail_utf8($admin_email, $subject, $comment, "From:" . $email);
                  //mail($admin_email, '=?utf-8?B?'.base64_encode($subject).'?=', utf8_encode($comment), "From:" . $email);
                  //Email response
                  echo "<div class=\"container p-5\"><div><div class=\"jumbotron\"><center><b>Išsiųsta. Ačiū už pranešimą!</b></center></div><div class=\"container p-5\"></div>";
            }
            else { ?>
                <div class="container bg-light p-4 rounded">
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
                </div>
            <?php }
          }

          //if "email" variable is not filled out, display the form
          else  {
        ?>



                <div class="container bg-light p-4 rounded">
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
                </div>
       <?php
         }
       ?>
                
                </td></tr></table>
                    </div>
          <div class="col">
          </div>
        </div>
         </div>
      
        <?php include("include/footer.php"); ?>
    </body>
</html>
