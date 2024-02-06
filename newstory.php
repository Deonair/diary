<?php
require_once 'src/dbclass.php';
require_once("src/session.php");
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> New Story</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/newstory.css">
</head>

<body>
    <!--navbar -->
    <nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="diary.php"><img src="img/diarylogo.png" width="50px" height="62"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="src/uitloggen.php?logout=true"><img src="img/person.png">Logout</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="welkom.php"><img src="img/home.png">Welkom</a>
                    </li>
                </ul>
            </div>
        </div>

    </nav>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div id="wrapper">
        <form name="posts" action="forms/verhaal.php" method="post">

            <h1 id="title">New Story<h1>
                    <?php
                    require_once("src/session.php");

                    require_once("src/dbclass.php");
                        //Check of sessie bestaat
                    ;
                    if (isset($_SESSION['gebruiker_data'])) {

                        //unpack session

                        $user = unserialize($_SESSION['gebruiker_data']);

                        //Zet sessie id in uid variable

                        $uid = $user->id;
                    }

                    if (isset($uid)) {


                        require_once('src/dbclass.php');

                        //pak sessie data uit

                        $user = unserialize($_SESSION['gebruiker_data']);

                        //Fetch dagboeken

                        $dagboeken_data = $user->getDiary();
                    }

                    ?>
                    <select type="select" name="id_dagboek">
                        <?php
                        foreach ($dagboeken_data as $dagboek_data) {

                        ?>

                            <option value="<?php echo $dagboek_data['id_dagboek']; ?>">
                                <?php echo $dagboek_data['naam']; ?>
                            </option>

                        <?php

                            $a++;
                        } ?>
                    </select>
                    <div class="col-sm-12">
                        <textarea class="textarea" name="posts" rows="20" cols="85"></textarea>
                    </div>


                    <input type="submit" id="submit" name="submit" value="Add to diary!">
    </div>

    <!-- <button> Voeg toe aan dagboek!</button> -->
    <br>
    </form>
</body>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(nicEditors.allTextAreas);
</script>

</html>