
<?php
session_start();
// cia sesijos kontrole
//if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
//{ header("Location:articles.php");exit;}
include("include/nustatymai.php");
include("include/functions.php");
$user=$_SESSION['user'];
$userid = $_SESSION['userid'];
$userlevel=$_SESSION['ulevel'];
if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest")   { header("Location: logout.php");exit;}
$_SESSION['prev'] = "fetch_comment.php"; 
$connect = new PDO('mysql:host=localhost;dbname=korepetitoriai', 'root', '');
$connect->exec("set names utf8");
$query = "SELECT vardas, pavarde, data, tekstas, komentaro_id FROM " . TBL_COMMENTS . ", " . TBL_USERS . 
        " WHERE fk_vartotojo_id = vartotojo_id AND atsakymo_id = '0' AND fk_cv_id = '$_SESSION[art]' ORDER BY komentaro_id DESC";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();
$output = '';
foreach($result as $row){
    if($userlevel == $user_roles[ADMIN_LEVEL]){
        $output .= '
             <div class="container p-4 rounded" style="background-color: dee3e8;">
             <div class="panel-heading"><b>'.$row["vardas"] . " " . $row["pavarde"].'</b> <small class=\"text-muted\">(<i>'.$row["data"].'</i>)</small></div>
             <div class="panel-body" align="left">'.$row["tekstas"].'</div>
                 <div class="panel-footer" align="right"><form action="delete_comment.php" method="post"><button type="submit" onclick="return confirm(\'Ar tikrai norite ištrinti šį komentarą?\');" class="btn btn-default reply" style="background-color: a5b3c0;">Šalinti</button><input type="hidden" name="comment_id" value="'.$row["komentaro_id"].'"/><input type="hidden" name="fk_cv_id" value="'.$_SESSION['art'].'"/></form><button type="button" class="btn btn-default reply" style="background-color: a5b3c0;" id="'.$row["komentaro_id"].'">Atsakyti</button></div>
            </div><div class="container p-2"></div>
            ';
        $output .= get_reply_comment($connect, $row["komentaro_id"]);
    }
    else{
        $output .= '
            <div class="container p-4 rounded" style="background-color: dee3e8;">
             <div class="panel-heading"><b>'.$row["vardas"] . " " . $row["pavarde"].'</b> <small class=\"text-muted\">(<i>'.$row["data"].'</i>)</small></div>
             <div class="panel-body" align="left">'.$row["tekstas"].'</div>
                 <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" style="background-color: a5b3c0;" id="'.$row["komentaro_id"].'">Atsakyti</button></div>
                     
            </div>
            <div class="container p-2"></div>
            ';
        $output .= get_reply_comment($connect, $row["komentaro_id"]);
    }
}

echo $output;

function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
{
 $user=$_SESSION['user'];
 $userid = $_SESSION['userid'];
 $userlevel=$_SESSION['ulevel'];
 $adminLevel = 10;
 $query = "SELECT vardas, pavarde, data, tekstas, komentaro_id FROM " . TBL_COMMENTS . ", " . TBL_USERS . 
         " WHERE fk_vartotojo_id = vartotojo_id AND atsakymo_id = '" . $parent_id ."' AND fk_cv_id = '$_SESSION[art]' ORDER BY komentaro_id DESC";
 $output = '';
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $count = $statement->rowCount();
 if($parent_id == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
 if($count > 0)
 {
  foreach($result as $row){
      if($userlevel == $adminLevel){
            $output .= '
                <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
                    <div class="container p-4 rounded" style="background-color: dee3e8;">
                 <div class="panel-heading"><b>'.$row["vardas"] . " " . $row["pavarde"].'</b> <small class=\"text-muted\">(<i>'.$row["data"].'</i>)</small></div>
                 <div class="panel-body" align="left">'.$row["tekstas"].'</div>
                 <div class="panel-footer" align="right"><form action="delete_comment.php" method="post"><button type="submit" class="btn btn-default reply" style="background-color: a5b3c0;" onclick="return confirm(\'Ar tikrai norite ištrinti šį komentarą?\');">Šalinti</button><input type="hidden" name="comment_id" value="'.$row["komentaro_id"].'"/><input type="hidden" name="fk_cv_id" value="'.$_SESSION['art'].'"/></form><button type="button" class="btn btn-default reply" style="background-color: a5b3c0;" id="'.$row["komentaro_id"].'">Atsakyti</button></div>
                </div></div><div class="container p-2"></div>
                ';
            $output .= get_reply_comment($connect, $row["komentaro_id"], $marginleft);
      }
      else{
          $output .= '
              <div class="panel panel-default" style="margin-left: '.$marginleft.'px">
                <div class="container p-4 rounded" style="background-color: dee3e8;">
                 <div class="panel-heading"><b>'.$row["vardas"] . " " . $row["pavarde"].'</b> <small class=\"text-muted\">(<i>'.$row["data"].'</i>)</small></div>
                 <div class="panel-body">'.$row["tekstas"].'</div>
                 <div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" style="background-color: a5b3c0;" id="'.$row["komentaro_id"].'">Atsakyti</button></div>
                </div></div><div class="container p-2"></div>
                ';
          $output .= get_reply_comment($connect, $row["komentaro_id"], $marginleft);
      }
    }
 }
 return $output;
}

?>
