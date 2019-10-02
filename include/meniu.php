
<center><a href="index.php"><img class="img-responsive center-block" style="width: 75%; padding-top: 15px" src="include/banners/main-banner.png"/></a></center> 
  <?php
        // meniu.php  rodomas meniu pagal vartotojo rolę

        if (!isset($_SESSION)) { header("Location: logout.php");exit;}
        include("include/nustatymai.php");
        $user=$_SESSION['user'];
        $userid = "";
        if($user != "guest"){
            $userid = $_SESSION['userid'];
        }
        $role = $_SESSION['urole'];
        $userlevel = $_SESSION['ulevel'];
        ?>
      <nav class="navbar fixed navbar-expand-lg navbar-light bg-light ">
      <div class="container">
          
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent" style="text-align: center">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Pagrindinis<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#collapseExample2, #collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample2">Paieška</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cvnaujausi.list.php">Naujausi CV</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Kategorijos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="cvangluk.list.php">Anglų k.</a>
              <a class="dropdown-item" href="cvlietuviuk.list.php">Lietuvių k.</a>
              <a class="dropdown-item" href="cvmatematika.list.php">Matematika</a>
              <a class="dropdown-item" href="cvfizika.list.php">Fizika</a>
              <a class="dropdown-item" href="cvchemija.list.php">Chemija</a>
              <a class="dropdown-item" href="cvit.list.php">IT</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="cvpopuliariausi.list.php">Populiariausi</a>
            </div>
          </li>

          <?php if ($userlevel == $user_roles[MOKYTOJAS_LEVEL] ) { ?>
            <li class="nav-item">
                
            </li>
        </ul>
          <form class="form-inline my-2 my-lg-0">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$user";?></button>
              <div class="dropdown-menu">
                <p class="dropdown-item" align="center">Jūs esate: <b><?php echo "$role";?></b></p>
                <div class="dropdown-divider"></div>
                <?php if($userlevel > 0) { ?>   
                <a class="dropdown-item" href="pazymeticv.php">Pažymėtų CV sąrašas</a>
                <a class="dropdown-item" href="newcv.php">Susikurti/Atnaujinti CV</a>
                <a class="dropdown-item" href="read.php">Mano CV</a>
                <a class="dropdown-item" href="mynewclassmembers.php">Norintys užsirašyti</a>
                <a class="dropdown-item" href="myclass.php">Mano mokiniai</a>
                <?php } ?>
                <a class="dropdown-item" href="useredit.php">Keisti paskyros duomenis</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
          <?php } ?>
          
          <?php if ($userlevel == $user_roles[ADMIN_LEVEL]) { ?> 
          <li class="nav-item">
            <a class="nav-link" href="admin.php">Vartotojų valdymas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reportedCVs.php">Raportuoti CV</a>
          </li>
      </ul>
        <form class="form-inline my-2 my-lg-0">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$user";?></button>
              <div class="dropdown-menu">
                <p class="dropdown-item" align="center">Jūs esate: <b><?php echo "$role";?></b></p>
                <div class="dropdown-divider"></div>
                <?php if($userlevel > 0) { ?>   
                <a class="dropdown-item" href="pazymeticv.php">Pažymėtų CV sąrašas</a>
                <?php } ?>
                <a class="dropdown-item" href="useredit.php">Keisti paskyros duomenis</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
        <?php } ?>
        

        <?php if ($userlevel == $user_roles[DEFAULT_LEVEL]) { ?> 
      </ul>
        <form class="form-inline my-2 my-lg-0">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$user";?></button>
              <div class="dropdown-menu">
                <p class="dropdown-item" align="center">Jūs esate: <b><?php echo "$role";?></b></p>
                <div class="dropdown-divider"></div> 
                <a class="dropdown-item" href="pazymeticv.php">Pažymėtų CV sąrašas</a>
                <a class="dropdown-item" href="newcv.php">Susikurti/Atnaujinti CV</a>
                <a class="dropdown-item" href="read.php">CV peržiūra</a>
                <a class="dropdown-item" href="useredit.php">Keisti paskyros duomenis</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
        <?php } if ($_SESSION['user'] == "guest"){
            ?>
      </ul>
      
       	<ul class="navbar-nav">
            <li class="nav-item p-2">
                <a href="login.php" class="btn btn-danger nav-item px-4">Prisijungti</a>
            </li>
            <li class="nav-item p-2">
                <a href="register.php" class="btn btn-danger nav-item px-4">Registruotis</a>
            </li>   
        </ul>
      
        <?php } ?>
      </div>
      </div>
    </nav>
        
        <div class="collapse show" id="collapseExample">
             <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <form action="sort.php" class="form-group" method="POST">
                    <div class="row">
                                    <div class="col-md-6 my-2">
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect02">Dalykas</label>
                                                        </div>
                                                        <select class="custom-select" name="subject">
                                                            <option>Visi dalykai</option>
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
                                                                   <option value="<?php echo $option ?>" <?php if($_SESSION['subject_input'] == $option){echo "selected";}?>><?php echo $option ?></option>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                                ?>
                                                        </select>
                                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                                        <div class="input-group">
                                                        <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect03">Miestas</label>
                                                        </div>
                                                        <select class="custom-select" name="place">
                                                            <option>Visi miestai</option>
                                                            <?php
                                                                $conn->set_charset("utf8");
                                                                if (!$conn) {
                                                                    die("Connection failed: " . mysqli_connect_error());

                                                                }

                                                                $sql_u = "SELECT id, miestas FROM miestai";
                                                                    $res_u = mysqli_query($conn, $sql_u);
                                                                                                foreach($res_u as $key => $val) {
                                                                                                        ?>
                                                                                   <option value="<?php echo $val['miestas']; ?>" <?php if($_SESSION['place_input'] == $val['miestas']){echo "selected";}?>><?php echo "$val[miestas]"; ?></option>
                                                                                                        <?php
                                                                                                }
                                                                                                echo "</select>";
                                                        ?>
                                                        </div>
                                    </div>
                    </div>
                    <div class="row justify-content-center my-2">
                        <button class="btn btn-outline-success btn-lg" type="submit">Ieškoti</button>
                </form>
      </div>
    </nav>
        </div>

    <div class="collapse" id="collapseExample2">
             <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <form action="search.php" class="form-group" method="POST">
                    <div class="row">
                        <input class="form-control my-2 mb-2" size="28" type="search" placeholder="Vartotojo vardas ir/arba pavardė" name="paieska" aria-label="Search"/>
                    </div>
                    <div class="row justify-content-center my-2">
                        <button class="btn btn-outline-success btn-lg" type="submit">Ieškoti</button>
                    </div>
                </form>
      </div>
    </nav>
        </div>