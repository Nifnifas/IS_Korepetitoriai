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
        
        <table class="center"><tr><td><a href="index.php"><img src="include/banners/banner2.png"/></a></td></tr><tr><td><br>
                                
<?php
session_start();
if (!isset($_SESSION['prev']) || ($_SESSION['ulevel'] == 0))   {header("Location: logout.php");exit;}
        $_SESSION['prev'] = "newcv.php";
include("include/meniu.php");
include("include/functions.php");

    $db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset("utf8");
    $sql = "SELECT * FROM " . TBL_CVS . " WHERE `fk_vartotojo_id` = '$userid'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) == 1 && $userlevel == 5){
                    $row = mysqli_fetch_array($result);
                    $_SESSION['antraste_input']=$row['antraste'];
                    $_SESSION['dalykas_input']=$row['dalykas'];
                    $_SESSION['tekstas_input']=$row['tekstas'];
                    $_SESSION['kaina_input']=$row['kaina'];
                    $_SESSION['miestas_input']=$row['miestas'];
                    $_SESSION['internetu_input']=$row['internetu'];
                    $_SESSION['cv_busena'] = "redagavimas";
    }
    else if (mysqli_num_rows($result) == 1 && $userlevel == 1){
        $row = mysqli_fetch_array($result);
                    $_SESSION['antraste_input']=$row['antraste'];
                    $_SESSION['dalykas_input']=$row['dalykas'];
                    $_SESSION['tekstas_input']=$row['tekstas'];
                    $_SESSION['miestas_input']=$row['miestas'];
                    $_SESSION['internetu_input']=$row['internetu'];
                    $_SESSION['cv_busena'] = "redagavimas";
    }
    else
                {
                    $_SESSION['cv_busena'] = "sukurimas";
                }
                
    if($userlevel == 5){
?>
  <table class="center" style="border-width: 20px;"><tr><td>
              <div class="container bg-light p-4 rounded">
                                <div class="container">
                                    <h1 class="form-heading">CV sukūrimas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="container p-2"></div>
                                                <form action="proccv.php" method="POST" enctype="multipart/form-data">
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
                                                                   <option value="<?php echo $i ?>" <?php if($_SESSION['dalykas_input']==$i || $_SESSION['dalykas_input'] == $option){echo "selected";}?>><?php echo $option ?></option>
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
                                                        <div class="input-group mb-3">
                                                        <select class="custom-select" name="miestas">
                                                            <option>Pasirinkite...</option>
                                                            <?php
                                                                $conn->set_charset("utf8");
                                                                if (!$conn) {
                                                                    die("Connection failed: " . mysqli_connect_error());

                                                                }

                                                                $sql_u = "SELECT id, miestas FROM miestai";
                                                                    $res_u = mysqli_query($conn, $sql_u);
                                                                                                foreach($res_u as $key => $val) {
                                                                                                        ?>
                                                                                   <option value="<?php echo $val['miestas']; ?>" <?php if($_SESSION['miestas_input'] == $val['miestas']){echo "selected";}?>><?php echo "$val[miestas]"; ?></option>
                                                                                                        <?php
                                                                                                }
                                                                                                echo "</select>";
                                                        ?>
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect03">Jūsų gyvenamasis miestas</label>
                                                        </div>
                                                        </div>
                                                        <?php echo $_SESSION['miestas_error']; ?>
                                                    </div>
                                                     <div class="form-group">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==1 || $_SESSION['internetu_input'] == "taip"){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="1" id="option1" autocomplete="off" <?php if($_SESSION['internetu_input']==1 || $_SESSION['internetu_input'] == "taip"){echo "checked";}?>>Taip
                                                        </label>
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==2 || $_SESSION['internetu_input'] == "ne"){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="2" id="option2" autocomplete="off" <?php if($_SESSION['internetu_input']==2 || $_SESSION['internetu_input'] == "ne"){echo "checked";}?>>Ne
                                                        </label>
                                                        <div class="input-group-append">
                                                          <span class="input-group-text">Mokysiu internetu</span>
                                                        </div>
                                                    </div>
                                                     </div>
                                                    <?php echo $_SESSION['internetu_error']; ?>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlFile1"><b>Pasirinkite savo profilio nuotrauką</b></label>
                                                    <input type="file" name="upload" class="form-control-file" id="exampleFormControlFile1">
                                                    <?php echo $_SESSION['image_error']; ?>
                                                    </div>
                                                    <center><button type="submit" name="submit" class="btn btn-primary">Sukurti</button></center>
                                                </form>                       
                                            </div>
                                        </div>          
                                </div>
                        </td></tr>
  </div>
                </table> 
   <?php } if($userlevel == 1) {
?>
                 <br><br><table class="center" style="border-width: 2px;"><tr><td>    
                             <div class="container bg-light p-4 rounded">
                                <div class="container">
                                    <h1 class="form-heading">CV sukūrimas</h1>
                                        <div class="login-form">
                                            <div class="main-div">
                                                <div class="panel">
                                                    <p>Užpildykite visus laukus</p>
                                                </div>
                                                <form action="proccv.php" method="POST" enctype="multipart/form-data">
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
                                                                   <option value="<?php echo $i ?>" <?php if($_SESSION['dalykas_input']==$i || $_SESSION['dalykas_input'] == $option){echo "selected";}?>><?php echo $option ?></option>
                                                                    <?php
                                                                    $i++;
                                                                } ?>
                                                        </select>
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect02">Dominanti sritis</label>
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
                                                        <select class="custom-select" name="miestas">
                                                            <option>Pasirinkite...</option>
                                                            <?php
                                                                $conn->set_charset("utf8");
                                                                if (!$conn) {
                                                                    die("Connection failed: " . mysqli_connect_error());

                                                                }

                                                                $sql_u = "SELECT id, miestas FROM miestai";
                                                                    $res_u = mysqli_query($conn, $sql_u);
                                                                                                foreach($res_u as $key => $val) {
                                                                                                        ?>
                                                                                   <option value="<?php echo $val['miestas']; ?>" <?php if($_SESSION['miestas_input'] == $val['miestas']){echo "selected";}?>><?php echo "$val[miestas]"; ?></option>
                                                                                                        <?php
                                                                                                }
                                                                                                echo "</select>";
                                                        ?>
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect03">Jūsų gyvenamasis miestas</label>
                                                        </div>
                                                        </div>
                                                        <?php echo $_SESSION['miestas_error']; ?>
                                                    </div>
                                                     <div class="form-group">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==1 || $_SESSION['internetu_input'] == "taip"){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="1" id="option1" autocomplete="off" <?php if($_SESSION['internetu_input']==1 || $_SESSION['internetu_input'] == "taip"){echo "checked";}?>>Domina
                                                        </label>
                                                        <label class="btn btn-secondary h-25 d-inline-block <?php if($_SESSION['internetu_input']==2 || $_SESSION['internetu_input'] == "ne"){echo "active";}?>" style="width: 120px;">
                                                          <input type="radio" name="internetu" value="2" id="option2" autocomplete="off" <?php if($_SESSION['internetu_input']==2 || $_SESSION['internetu_input'] == "ne"){echo "checked";}?>>Nedomina
                                                        </label>
                                                        <div class="input-group-append">
                                                          <span class="input-group-text">Pamokos internetu</span>
                                                        </div>
                                                    </div>
                                                     </div>
                                                    <?php echo $_SESSION['internetu_error']; ?>
                                                    <div class="form-group">
                                                        <label for="exampleFormControlFile1"><b>Pasirinkite savo profilio nuotrauką</b></label>
                                                    <input type="file" name="upload" class="form-control-file" id="exampleFormControlFile1">
                                                    <?php echo $_SESSION['image_error']; ?>
                                                    </div>
                                                    <center><button type="submit" name="submit" class="btn btn-primary">Sukurti</button></center>
                                                </form>                       
                                            </div>
                                        </div>          
                                </div>
                             </div>
                        </td></tr>
                </table><br><br>
    <?php } ?>
                </td></tr>
                </table>
                  <?php include("include/footer.php"); ?>
        </body>
</html>
