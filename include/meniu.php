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
            <a class="nav-link" href="articlesList.php?naujausi">Naujausi straipsniai</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Kategorijos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="articlesList.php?sportas">Sportas</a>
              <a class="dropdown-item" href="articlesList.php?mokslas">Mokslas</a>
              <a class="dropdown-item" href="articlesList.php?politika">Politika</a>
              <a class="dropdown-item" href="articlesList.php?kriminalai">Kriminalai</a>
              <a class="dropdown-item" href="articlesList.php?verslas">Verslas</a>
              <a class="dropdown-item" href="articlesList.php?gyvenimas">Gyvenimas</a>
              <a class="dropdown-item" href="articlesList.php?menas">Menas</a>
              <a class="dropdown-item" href="articlesList.php?maistas">Maistas</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="articlesList.php?skaitomiausi">Skaitomiausi</a>
            </div>
          </li>

          <?php if ($userlevel == $user_roles[ADMIN_LEVEL] ) { 
              ?>
            <li class="nav-item">
                <a class="nav-link" href="newArticlesList.php">Nepatvirtinti straipsniai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Vartotojų valdymas</a>
            </li>
          <?php } ?>
        </ul>

        <?php if ($_SESSION['user'] != "guest"){
              ?> 
        <form class="form-inline my-2 my-lg-0">
            <div class="btn-group">
              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$user";?></button>
              <div class="dropdown-menu">
                <p class="dropdown-item" align="center">Jūs esate: <b><?php echo "$role";?></b></p>
                <div class="dropdown-divider"></div>
                <?php if($userlevel != 5){
                 ?>   
                
                <a class="dropdown-item" href="newarticle.php">Įkelti straipsnį</a>
                <a class="dropdown-item" href="myArticles.php">Mano straipsniai</a>
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
                <p class="dropdown-item" align="center">Jūs esate: <b>Svečias</b></p>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Atsijungti</a>
              </div>
            </div>
        </form>
        <?php } ?>

      </div>
    </nav>
    </body>
</html>

     


