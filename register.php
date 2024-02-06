<?php
require_once 'src/dbclass.php';

session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    </head>

    <body>

        <nav class="navbar navbar-dark navbar-expand-md fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="diary.php"><img src="img/diarylogo.png" width="50px" height="62"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menu">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><img src="img/person.png">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="newdiary.php"><img src="img/plus.png">Create Diary</a>
                        </li>



                    </ul>
                </div>
            </div>

        </nav>
        <br>
        <br>
        <br>
        <br>
        <div class="loginbox">
            <img src="img/orangeicon.png" class="avatar">
            <h1>Register</h1>
            <form name="gebruikers" action="forms/register.php" method="post">
                <input type="text" name="voornaam" placeholder="Firstname" />
                <input type="text" name="tussenvoegsels" placeholder="Insertion" />
                <input type="text" name="achternaam" placeholder="Lastname" />
                <input type="text" name="email" placeholder="Email" />
                <input type="password" name="wachtwoord" placeholder="Password" />
                <input type="password" name="wachtwoord2" placeholder="Confirm Password" />
                <input type="submit" name="submit" value="Register" />
                <a href="login.php">Already have a account? Click here!</a><br>
                <?php
                //error message en toont de error   
                if (isset($_SESSION['ERRORS'])) {
                    echo $_SESSION['ERRORS'];
                    unset($_SESSION['ERRORS']);
                    // echo"Dit werkt niet";
                }


                ?>
            </form>


            <br>

        </div>

    </body>

</html>