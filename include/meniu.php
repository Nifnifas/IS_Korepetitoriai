<?php
// meniu.php  rodomas meniu pagal vartotojo rolę

if (!isset($_SESSION)) { header("Location: logout.php");exit;}
include("include/nustatymai.php");
$user=$_SESSION['user'];
$userid = $_SESSION['userid'];
$role = $_SESSION['urole'];
$userlevel = $_SESSION['ulevel'];
?>
<html>
    <head>
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Pagrindinis<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Paieška</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cvlist.php?naujausi">Naujausi CV</a>
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
              <a class="dropdown-item" href="cvlist.php?populiariausi">Populiariausi</a>
            </div>
          </li>

          <?php if ($userlevel == $user_roles[ADMIN_LEVEL] ) { ?>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Vartotojų valdymas</a>
            </li>
          <?php } ?>
        </ul>

        <?php if ($_SESSION['user'] != "guest") { ?> 
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
                <a class="dropdown-item" href="newarticle.php">Sukurti klasę</a>
                <a class="dropdown-item" href="myArticles.php">Mano klasės</a>
                <?php } ?>
                <a class="dropdown-item" href="useredit.php">Keisti paskyros duomenis</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
        <?php } if ($_SESSION['user'] == "guest"){
            ?>
        <form class="form-inline my-2 my-lg-0">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$user";?></button>
              <div class="dropdown-menu">
                <p class="dropdown-item" align="center">Jūs esate: <b><?php echo "$role";?></b></p>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
        <?php } ?>
      </div>
    </nav>
        
        <div class="collapse" id="collapseExample">
            <nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-center">
                <div class="col-6">
                <input class="form-control mr-sm-2" type="search" placeholder="Paieška" aria-label="Search">
                </div>
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ieškoti</button>
            </nav>
        </div>
    </body>
</html>

     


