<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-center">
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <form action="sort.php" class="form-inline" method="POST">
                                    <div class="col-6">
                                                        <div class="input-group mb-3">
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
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect02">Dalykas</label>
                                                        </div>
                                                        </div>
                                    </div>
                                    <div class="col-6">
                                                        <div class="input-group mb-3">
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
                                                         <div class="input-group-append">
                                                            <label class="input-group-text" for="inputGroupSelect03">Miestas</label>
                                                        </div>
                                                        </div>
                                    </div>
                <button class="btn btn-outline-success btn-lg btn-block my-2 my-sm-0" type="submit">Ieškoti</button>
                </form>
      </div>
    </nav>
    </body>
</html>
