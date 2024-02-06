<?php
require_once 'src/dbclass.php';
require_once("src/session.php");
$dbid = $_GET['id_dagboek'];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> View Story</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/Bibliotheek.css">
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
                        <a class="nav-link" href="welkom.php"><img src="img/home.png">Welcome</a>
                    </li>



                </ul>
            </div>
        </div>

    </nav>
    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <h2>Choose Diary</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>

                    <th scope="col">Story</th>

                    <th scrope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php

                //zet variable $a op 1 (zodat hij later kan optellen)



                //Foreach om door alle rows een loop te doen
                $user = unserialize($_SESSION['gebruiker_data']);
                //Pass POST variable

                $stories_data = $user->getStories($dbid);
                foreach ($stories_data as $story_data) {

                ?>

                    <tr>
                        <td><?php echo $story_data['post'] ?></td>
                        <td> <?php echo $story_data['datum'] ?></td>





                    </tr>

                <?php


                }

                ?>
                <br>
    </div>
    </form>
</body>

</html>