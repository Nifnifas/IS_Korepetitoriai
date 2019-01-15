
<?php

session_start();
// cia sesijos kontrole
//if (!isset($_SESSION['prev']) || ($_SESSION['prev'] != "index"))
//{ header("Location:articles.php");exit;}
include("include/nustatymai.php");
include("include/functions.php");
if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest")   {redirect("logout.php");exit;}
$_SESSION['prev'] = "add_comment.php"; 
$connect = new PDO('mysql:host=localhost;dbname=aus14274_korepetitoriai', 'aus14274_lukkru2', 'Siokoledas77');
$connect->exec("set names utf8");
$error = '';
$comment_name = '';
$comment_content = '';


if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Jūs neįvedėte komentaro!</p>';
}
else
{
    $comment_content = $_POST["comment_content"];
}

if($error == '')
{
 $query = "
 INSERT INTO " . TBL_COMMENTS . " 
 (atsakymo_id, tekstas, fk_vartotojo_id, fk_cv_id) 
 VALUES (:parent_comment_id, :comment, :sender_id, :fk_cv_id)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':sender_id' => $_SESSION['userid'],
   ':fk_cv_id' => $_SESSION['art']
  )
 );
}

$data = array(
 'error'  => $error
);

echo json_encode($data);

?>
