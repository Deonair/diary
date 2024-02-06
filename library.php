<?php
require_once 'src/dbclass.php';
require_once("src/session.php");
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Library</title>
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
                    <th scope="col">#</th>
                    <th scope="col">Diary</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                <?php

                //zet variable $a op 1 (zodat hij later kan optellen)

                $number = 1;

                
                $user = unserialize($_SESSION['gebruiker_data']);
                //Pass POST variable

                $dagboeken_data = $user->getDiary();
                //Foreach to go through all rows
                foreach ($dagboeken_data as $dagboek_data) {

                ?>

                    <tr>

                        <td><?php echo $number ?></td>

                        <td><?php echo $dagboek_data['naam'] ?></td>

                        <td>

                            <form method="get" action="stories.php">
                                
                                <input type="hidden" name="id_gebruiker" value="<?php echo $dagboek_data['id_gebruiker'] ?>">
                                
                                <input type="hidden" name="id_dagboek" value="<?php echo $dagboek_data['id_dagboek'] ?>"><!--Displays diaryname-->

                                <button>View</button>

                            </form>

                        </td>
                        <td>
                        </td>
                    </tr>

                <?php

                    $number++;
                }

                ?>
                <br>
    </div>
    </form>
</body>

</html>