<?php
// register.php registracijos forma
// jei pats registruojasi rolė = DEFAULT_LEVEL, jei registruoja ADMIN_LEVEL vartotojas, rolę parenka
// Kaip atsiranda vartotojas: nustatymuose $uregister=
//                                         self - pats registruojasi, admin - tik ADMIN_LEVEL, both - abu atvejai galimi
// formos laukus tikrins procregister.php

    session_start();
    if (empty($_SESSION['prev'])) { header("Location: logout.php");exit;} // registracija galima kai nera userio arba adminas
// kitaip kai sesija expirinasi blogai, laikykim, kad prev vistik visada nustatoma
    include("include/functions.php");
    if (!isset($_SESSION['prev']) || $_SESSION['user'] != "guest")   {redirect("logout.php");exit;} // pradinis bandymas registruoti

    $_SESSION['prev']="register";
?>
        <html>
        <head>  
            <title>Registracija</title>
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
                        <?php include("include/meniu.php"); ?>
                        
                                <table class="center" style="border-width: 30px; border-color: white;"><tr><td>
                                            <div class="container bg-light p-5 rounded">
                                <div class="container">
                                    <h1 class="form-heading">Registracijos langas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Įveskite žemiau nurodytus duomenis</p>
                                                </div>
                                                <form action="procregister.php" method="POST"> 
                                                    <div class="form-group">
                                                        <div class="row">
                                                        <div class="col-sm">
                                                            <input type="text" name="name" class="form-control" id="inputUsername" value="<?php echo $_SESSION['name_input'];?>" placeholder="Vardas"/>
                                                            <?php echo $_SESSION['name_error'];?> 
                                                        </div>
                                                        <div class="col-sm">
                                                            <input type="text" name="surname" class="form-control" id="inputSurname" value="<?php echo $_SESSION['surname_input'];?>" placeholder="Pavardė"/>
                                                            <?php echo $_SESSION['surname_error'];?> 
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="number" name="phone" class="form-control" id="inputPhone" value="<?php echo $_SESSION['phone_input'];?>" placeholder="Telefono nr. +370..."/>
                                                        <?php echo $_SESSION['phone_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="email" class="form-control" id="inputPassword" value="<?php echo $_SESSION['mail_input'];?>" placeholder="El. paštas"/>
                                                        <?php echo $_SESSION['mail_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Slaptažodis"/>
                                                        <?php echo $_SESSION['pass_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="custom-select" name="userType">
                                                        <option value="0">Jūs esate...</option>
                                                        <option value="1" <?php if($_SESSION['userType_input']==1){echo "selected";}?>>Mokytojas</option>
                                                        <option value="2" <?php if($_SESSION['userType_input']==2){echo "selected";}?>>Mokinys</option>
                                                        </select>
                                                        <?php echo $_SESSION['type_error']; ?>
                                                    </div>
                                                    <div class="container">
                                                        <center><button type="submit" name="registracija" class="btn btn-primary">Registruotis</button></center>
                                                    </div>
                                                </form>
                                                                               
                                            </div>
                                        </div>          
                                </div></div>
                        </td></tr></table>
                    </td></tr></table> 
                  <?php include("include/footer.php"); ?>
        </body>
    </html>