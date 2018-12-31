<html>
    <head>
        <title>Prisijungti</title>
        <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
<?php 
// login.php - tai prisijungimo forma, index.php puslapio dalis 
// formos reikšmes tikrins proclogin.php. Esant klaidų pakartotinai rodant formą rodomos klaidos
// formos laukų reikšmės ir klaidų pranešimai grįžta per sesijos kintamuosius
// taip pat iš čia išeina priminti slaptažodžio.
// perėjimas į registraciją rodomas jei nustatyta $uregister kad galima pačiam registruotis

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
$_SESSION['prev'] = "login";
include("include/nustatymai.php");
?>
    <div class="container">
        <h1 class="form-heading">Prisijungimo langas</h1>
            <div class="login-form">
                <div class="main-div">
                    <div class="panel">
                        <p>Įveskite vartotojo vardą ir slaptažodį</p>
                    </div>
                    <form action="proclogin.php" method="POST"> 
                        <div class="form-group">
                            <input type="text" name="user" class="form-control" id="inputUsername" placeholder="Vartotojo vardas"/>
                            <?php echo $_SESSION['name_error'];?>
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Slaptažodis"/>
                            <?php echo $_SESSION['pass_error'];?>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-sm"><button type="submit" name="login" class="btn btn-primary">Prisijungti</button></div>
                                <div class="col-sm"><input type="button" value="Svečias" name="guest" onclick="location.href='guest.php'" class="btn btn-primary"/></div>
                                <div class="col-sm"><input type="button" value="Registracija" name="registracija" onclick="location.href='register.php'" class="btn btn-primary"/></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>          
    </div>
    </body>
</html>