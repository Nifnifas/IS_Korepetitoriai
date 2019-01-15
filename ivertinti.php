<?php
session_start();
if (!isset($_SESSION['prev']) || $_SESSION['user'] == "guest")   {redirect("logout.php");exit;}
    $_SESSION['prev'] = "ivertinti.php";
    $reiksme = $_POST['reiksme'];
    $fk_user_id = $_SESSION['userid'];
    $kam_skirtas = $_POST['skiriama'];
    include("include/nustatymai.php");
    // Create connection
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset("utf8");
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "INSERT INTO " . TBL_IVERTINIMAS . " (
                    verte,
                    skirtas_id,
                    fk_vartotojo_id
                )
                VALUES (
                    '$reiksme',
                        '$kam_skirtas',
                            '$fk_user_id'

                    )";
            
            if (mysqli_query($conn, $sql)) {
                echo "Success";
            }
            mysqli_close($conn);
?>