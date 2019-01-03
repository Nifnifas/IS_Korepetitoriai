<html>
    <head>
        <title>CV įkėlimas</title>
                <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="include/styles.css" rel="stylesheet" type="text/css" >
    </head>
    <body>
        
        <table class="center"><tr><td><img src="include/topB.png"></td></tr><tr><td><br>
                                
<?php
session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] == 0))   {header("Location: logout.php");exit;}
        $_SESSION['prev'] = "newcv.php";
include("include/meniu.php");
include("include/functions.php");
?>
  <br><br><table class="center" style="border-width: 2px;"><tr><td>                              
                                <div class="container">
                                    <h1 class="form-heading">CV sukūrimas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Užpildykite visus laukus</p>
                                                </div>
                                                <form action="proccv.php" method="POST"> 
                                                    <div class="form-group">
                                                        <input type="text" name="antraste" class="form-control" value="<?php echo $_SESSION['antraste_input']?>" placeholder="Antraštė"/>
                                                        <?php echo $_SESSION['letters_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                        <select class="custom-select" name="dalykas">
                                                            <option>Pasirinkite...</option>
                                                            <?php
                                                                $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
                                                                $conn->set_charset("utf8");
                                                                if (!$conn) {
                                                                    die("Connection failed: " . mysqli_connect_error());

                                                                }

                                                                $sql = 'SHOW COLUMNS FROM cv WHERE field="dalykas"';
                                                                $res = mysqli_query($conn, $sql);
                                                                $row = mysqli_fetch_array($res);
                                                                $i = 1;
                                                                foreach(explode("','",substr($row['Type'],6,-2)) as $option) { ?>
                                                                   <option value="<?php echo $i ?>" <?php if($_SESSION['dalykas_input']==$i){echo "selected";}?>><?php echo $option ?></option>
                                                                    <?php
                                                                    $i++;
                                                                } ?>
                                                        </select>
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect02">Dėstomas dalykas</label>
                                                        </div>
                                                        </div>
                                                        <?php echo $_SESSION['dalykas_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <textarea class="form-control" type="text" name="tekstas" id="exampleFormControlTextarea1" rows="4" placeholder="Trumpai aprašykite save"><?php echo $_SESSION['tekstas_input']?></textarea>
                                                        <?php echo $_SESSION['tekstas_error']; ?>
                                                    </div>
                                                    <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                          <span class="input-group-text">€/val.</span>
                                                        </div>
                                                        <input type="number" class="form-control" name="kaina" style="text-align:center;" value="<?php echo $_SESSION['kaina_input']?>" placeholder="Pamokos kaina">
                                                        <div class="input-group-append">
                                                          <span class="input-group-text">.00</span>
                                                        </div>
                                                    </div>
                                                        <?php echo $_SESSION['kaina_error']; ?>
                                                    </div>
                                                     <div class="form-group">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==1){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="1" id="option1" autocomplete="off" <?php if($_SESSION['internetu_input']==1){echo "checked";}?>>Taip
                                                        </label>
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==2){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="2" id="option2" autocomplete="off" <?php if($_SESSION['internetu_input']==2){echo "checked";}?>>Ne
                                                        </label>
                                                        <div class="input-group-append">
                                                          <span class="input-group-text">Mokysiu internetu</span>
                                                        </div>
                                                    </div>
                                                     </div>
                                                    <?php echo $_SESSION['internetu_error']; ?>
                                                    <center><button type="submit" name="submit" class="btn btn-primary">Sukurti</button></center>
                                                </form>                       
                                            </div>
                                        </div>          
                                </div>
                        </td></tr>
                </table><br><br>
        </body>
</html>
